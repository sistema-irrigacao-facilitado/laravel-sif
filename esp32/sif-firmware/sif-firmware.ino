// SIF · Sistema de Irrigação Facilitado
// Firmware do dispositivo (ESP32): lê umidade do solo e temperatura, controla a bomba
// e conversa com a plataforma SIF (Laravel) pela rota POST /api/device/write.
//
// Modos (definidos na plataforma):
//   1 · automático: liga quando o solo fica mais seco que a umidade ideal da planta
//   2 · agendado:   liga nos dias e horários escolhidos, pelo tempo configurado
//
// Bibliotecas: DHT sensor library (Adafruit), NTPClient, ArduinoJson 7.

#include <WiFi.h>
#include <HTTPClient.h>
#include <WiFiClientSecure.h>
#include <WiFiUdp.h>
#include <NTPClient.h>
#include <ArduinoJson.h>
#include <Preferences.h>
#include <DHT.h>

#include "config.h"

// ---------- configuração recebida da plataforma ----------

const int MAX_HORARIOS_DIA = 6;

struct Configuracao {
    int modo = 1;                      // 1 automático, 2 agendado
    float umidadeAlvo = 0;             // % de umidade do solo ideal para a planta
    float temperaturaAlvo = 0;         // guardada para uso futuro
    float vazao = 0;                   // litros por minuto da bomba
    unsigned long periodoMs = 0;       // tempo ligado no modo agendado
    int horarios[7][MAX_HORARIOS_DIA]; // minutos desde 00:00; -1 = vazio (0 = domingo)
};

Configuracao config;
Preferences memoria;

// ---------- estado ----------

DHT dht(PINO_DHT, DHT11);
WiFiUDP udp;
NTPClient relogio(udp, "pool.ntp.org", FUSO_HORARIO_SEGUNDOS, 60000);

float umidadeSolo = 0;
float temperatura = 0;

bool bombaLigada = false;
unsigned long bombaLigadaEm = 0;      // millis() de quando ligou
unsigned long bombaLimiteMs = 0;      // por quanto tempo deve ficar ligada nesta vez
unsigned long bombaMsAcumulado = 0;   // tempo ligada desde o último envio

unsigned long ultimaLeitura = 0;
unsigned long ultimoEnvio = 0;
long ultimoHorarioDisparado = -1;     // evita ligar duas vezes no mesmo minuto

// =====================================================================
// configuração: leitura do JSON da plataforma e memória
// =====================================================================

int paraMinutos(const char *hhmm) {
    // "08:30" -> 510
    if (!hhmm || strlen(hhmm) < 4) return -1;
    int h = atoi(hhmm);
    const char *dois = strchr(hhmm, ':');
    if (!dois) return -1;
    int m = atoi(dois + 1);
    if (h < 0 || h > 23 || m < 0 || m > 59) return -1;
    return h * 60 + m;
}

// Lê um número que pode vir como texto ("60000") ou como número (60000)
unsigned long numero(JsonVariantConst valor) {
    if (valor.is<const char *>()) return strtoul(valor.as<const char *>(), nullptr, 10);
    if (valor.is<float>()) return (unsigned long)valor.as<float>();
    return 0;
}

// Aplica o JSON que vem no campo "update" da resposta:
// {"mode":"2","time_on":"{\"1\":[\"08:00\"]}","period":"60000","humidity":40,"temperature":30,"flow":2.5}
bool aplicarConfiguracao(const String &json) {
    JsonDocument doc;
    if (deserializeJson(doc, json)) {
        Serial.println("[config] JSON inválido, mantendo a configuração atual");
        return false;
    }

    Configuracao nova;
    nova.modo = numero(doc["mode"]) == 2 ? 2 : 1;
    nova.umidadeAlvo = doc["humidity"] | 0.0f;
    nova.temperaturaAlvo = doc["temperature"] | 0.0f;
    nova.vazao = doc["flow"] | 0.0f;
    nova.periodoMs = numero(doc["period"]);

    for (int d = 0; d < 7; d++)
        for (int i = 0; i < MAX_HORARIOS_DIA; i++) nova.horarios[d][i] = -1;

    // time_on costuma chegar como texto com outro JSON dentro, mas também aceita um objeto direto
    JsonDocument agenda;
    JsonObjectConst dias;
    if (doc["time_on"].is<JsonObjectConst>()) {
        dias = doc["time_on"].as<JsonObjectConst>();
    } else if (doc["time_on"].is<const char *>() && !deserializeJson(agenda, doc["time_on"].as<const char *>())) {
        dias = agenda.as<JsonObjectConst>();
    }
    for (JsonPairConst dia : dias) {
        int d = atoi(dia.key().c_str());
        if (d < 0 || d > 6) continue;
        int i = 0;
        for (JsonVariantConst h : dia.value().as<JsonArrayConst>()) {
            int minutos = paraMinutos(h.as<const char *>());
            if (minutos >= 0 && i < MAX_HORARIOS_DIA) nova.horarios[d][i++] = minutos;
        }
    }

    config = nova;
    Serial.printf("[config] modo %d, umidade alvo %.0f%%, vazão %.2f L/min, período %lus\n",
                  config.modo, config.umidadeAlvo, config.vazao, config.periodoMs / 1000);
    return true;
}

void carregarConfiguracao() {
    for (int d = 0; d < 7; d++)
        for (int i = 0; i < MAX_HORARIOS_DIA; i++) config.horarios[d][i] = -1;

    memoria.begin("sif", true);
    String salvo = memoria.getString("config", "");
    memoria.end();

    if (salvo.length() > 0) aplicarConfiguracao(salvo);
    else Serial.println("[config] nenhuma configuração salva, aguardando a plataforma");
}

void salvarConfiguracao(const String &json) {
    memoria.begin("sif", false);
    memoria.putString("config", json);
    memoria.end();
}

// =====================================================================
// sensores
// =====================================================================

void lerSensores() {
    int bruto = analogRead(PINO_SOLO);
    long porcentagem = map(bruto, SOLO_SECO, SOLO_MOLHADO, 0, 100);
    umidadeSolo = constrain(porcentagem, 0, 100);

    float t = dht.readTemperature();
    if (!isnan(t)) temperatura = t;   // se o DHT falhar, mantém a última leitura válida
}

// =====================================================================
// bomba
// =====================================================================

void ligarBomba(unsigned long duracaoMs, const char *motivo) {
    if (bombaLigada) return;
    digitalWrite(PINO_BOMBA, HIGH);
    bombaLigada = true;
    bombaLigadaEm = millis();
    bombaLimiteMs = min(duracaoMs, (unsigned long)BOMBA_MAXIMO_MS);
    Serial.printf("[bomba] ligada (%s) por até %lus\n", motivo, bombaLimiteMs / 1000);
}

void desligarBomba(const char *motivo) {
    if (!bombaLigada) return;
    digitalWrite(PINO_BOMBA, LOW);
    bombaLigada = false;
    bombaMsAcumulado += millis() - bombaLigadaEm;
    Serial.printf("[bomba] desligada (%s)\n", motivo);
}

void controlarBomba() {
    // limite de tempo vale para os dois modos
    if (bombaLigada && millis() - bombaLigadaEm >= bombaLimiteMs) {
        desligarBomba("tempo atingido");
    }

    if (config.modo == 1) {
        if (config.umidadeAlvo <= 0) return;   // planta ainda não configurada
        if (!bombaLigada && umidadeSolo < config.umidadeAlvo) {
            ligarBomba(BOMBA_MAXIMO_MS, "solo seco");
        } else if (bombaLigada && umidadeSolo >= config.umidadeAlvo + FOLGA_UMIDADE) {
            desligarBomba("umidade atingida");
        }
        return;
    }

    // modo 2: agendado
    if (!relogio.isTimeSet() || config.periodoMs == 0) return;
    int dia = relogio.getDay();                                   // 0 = domingo
    int agora = relogio.getHours() * 60 + relogio.getMinutes();
    long chave = dia * 10000L + agora;                            // um disparo por minuto

    for (int i = 0; i < MAX_HORARIOS_DIA; i++) {
        if (config.horarios[dia][i] == agora && chave != ultimoHorarioDisparado) {
            ultimoHorarioDisparado = chave;
            ligarBomba(config.periodoMs, "horário agendado");
        }
    }
}

// =====================================================================
// rede e plataforma
// =====================================================================

void manterWiFi() {
    static unsigned long ultimaTentativa = 0;
    if (WiFi.status() == WL_CONNECTED) return;
    if (millis() - ultimaTentativa < 10000 && ultimaTentativa != 0) return;
    ultimaTentativa = millis();
    Serial.printf("[wifi] conectando a %s...\n", WIFI_NOME);
    WiFi.disconnect();
    WiFi.begin(WIFI_NOME, WIFI_SENHA);
}

float litrosDesdeUltimoEnvio() {
    unsigned long ms = bombaMsAcumulado;
    if (bombaLigada) ms += millis() - bombaLigadaEm;
    return (ms / 60000.0f) * config.vazao;
}

void enviarLeituras() {
    if (WiFi.status() != WL_CONNECTED) return;

    String url = String(SERVIDOR_URL) + "/api/device/write";
    String corpo = "numbering=" + String(NUMERACAO) +
                   "&humidity=" + String(umidadeSolo, 1) +
                   "&temperature=" + String(temperatura, 1) +
                   "&liters_pump=" + String(litrosDesdeUltimoEnvio(), 3);

    HTTPClient http;
    WiFiClientSecure seguro;
    if (url.startsWith("https")) {
        seguro.setInsecure();   // sem verificar certificado: troque por setCACert() em produção
        http.begin(seguro, url);
    } else {
        http.begin(url);
    }
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");
    http.addHeader("Accept", "application/json");
    http.setTimeout(10000);

    int status = http.POST(corpo);
    String resposta = http.getString();
    http.end();

    if (status != 200) {
        Serial.printf("[envio] falhou: HTTP %d %s\n", status, resposta.substring(0, 120).c_str());
        return;
    }

    // leitura aceita: zera o acumulado (se a bomba estiver ligada, recomeça a contar agora)
    bombaMsAcumulado = 0;
    if (bombaLigada) {
        bombaLimiteMs -= min(bombaLimiteMs, millis() - bombaLigadaEm);
        bombaLigadaEm = millis();
    }
    Serial.printf("[envio] ok: solo %.0f%%, %.1f°C\n", umidadeSolo, temperatura);

    // a plataforma só manda "update" quando a configuração mudou
    JsonDocument doc;
    if (deserializeJson(doc, resposta)) return;
    const char *atualizacao = doc["update"] | "";
    if (strlen(atualizacao) > 0 && aplicarConfiguracao(atualizacao)) {
        salvarConfiguracao(atualizacao);
    }
}

// =====================================================================

void setup() {
    Serial.begin(115200);
    pinMode(PINO_BOMBA, OUTPUT);
    digitalWrite(PINO_BOMBA, LOW);   // a bomba sempre começa desligada
    dht.begin();

    carregarConfiguracao();

    WiFi.mode(WIFI_STA);
    manterWiFi();
    relogio.begin();
}

void loop() {
    manterWiFi();
    if (WiFi.status() == WL_CONNECTED) relogio.update();

    if (millis() - ultimaLeitura >= INTERVALO_LEITURA_MS || ultimaLeitura == 0) {
        ultimaLeitura = millis();
        lerSensores();
    }

    controlarBomba();

    if (millis() - ultimoEnvio >= INTERVALO_ENVIO_MS || ultimoEnvio == 0) {
        ultimoEnvio = millis();
        enviarLeituras();
    }
}
