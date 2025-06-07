#include <WiFi.h>             //wifi
#include <WebServer.h>        //server
#include <ESPmDNS.h>          //passar net
#include <ArduinoJson.h>      // Biblioteca para lidar com JSON
#include <WiFiClientSecure.h> //porta443
#include "DHT.h"              //sensores
#include <WiFiUdp.h>
#include <NTPClient.h>
#include <TimeLib.h>
#include <set>
#include <String.h> // Assim você pode usar 'String' com std::set
#include <EEPROM.h>  

#define DHTPIN 2     // Pino onde está conectado o DHT11
#define DHTTYPE DHT11 // Defina o tipo de sensor
#define PIN_D32 32
#define PIN_BOMBA 4 // Pino da bomba
DHT dht(DHTPIN, DHTTYPE);

const char *ssid = "";                        // Substitua pelo seu SSID
const char *password = "";

// Configurações do servidor  
const int serverPort = 80; // Porta do servidor  
const int serverPortsecure = 443;
const char* endpoint = "http://localhost:8000/device/write"; // URL para envio de dados  
const char* numeracao = "--------"; // ID do dispositivo


const int ADDR_VAZAO = 0; // Endereço da EEPROM para a vazão  
const int ADDR_UMIDADE = ADDR_VAZAO + sizeof(float); // Endereço da EEPROM para a umidade  
const int ADDR_TEMPERATURA = ADDR_UMIDADE + sizeof(float); // Endereço da EEPROM para a temperatura  
const int ADDR_PERIODO = ADDR_TEMPERATURA + sizeof(float); // Endereço da EEPROM para o período  
const int ADDR_MODO = ADDR_PERIODO + sizeof(int); // Endereço da EEPROM para o modo  
const int ADDR_HORARIOS = ADDR_MODO + 20; // Endereço da EEPROM para horários (ajuste conforme necessário)  
const int MAX_HORARIOS = 20; // Maximo de horarios  
String horarios[MAX_HORARIOS];  
int numHorarios = 0;  

int sensorPin = PIN_D32; // Pino do sensor de umidade do solo
int sensorValue = 0;     // Variável para armazenar o valor lido do sensor
int modoAutomaticoAtivo = 0;
StaticJsonDocument<512> timeDoc;
bool bombaLigada = false;            // estado em que a bomba esta
unsigned long tempoBombaLigada = 0;  // total de tempo em que a bomba permaneceu ligada
unsigned long bombaLigadaInicio = 0; // inicia a contagem do tempo de que a bomba esteve ligada
unsigned long bombaLigadaInicio2 = 0; // inicia a contagem do tempo de que a bomba esteve ligada
unsigned long tempoLigada = 0;
float tolTemp = 0.0; // total que a bomba deve permanecer ligada tempoMaximo

// variaveis provenientes do server
float umidadeLigar = 0.0; // umidade que a bomba deve ligar e que é armazenada
float atualVazao = 0.000; // Variável para armazenar a última vazão
float atualTemperatura = 0.0;
String atualModo = ""; // 1  modo automatico com base nas leituras dos senssores se for 2 modo selecionado dias e horarios a se ligar tendo ent que atualizar tais variaveis : enviado pelo server
bool horaValida = false;


// Configuração do NTP
WiFiUDP ntpUDP;
NTPClient timeClient(ntpUDP, "pool.ntp.org", -3 * 3600, 60000); // GMT offset é 0 aqui

// Inicia o servidor

WebServer server(serverPort);  // Usamos a porta 80 para o WebServer  
WebServer server2(serverPortsecure);  // Usamos a porta 443 para o servidor seguro 

StaticJsonDocument<200> jsonResponse;

#define MAX_HORARIOS 4 // Exemplo de número máximo de horários
String horariosLigados[7][MAX_HORARIOS];
std::set<String> horariosExistentes[7]; // Conjunto de horários para cada dia
// Inicialização do servidor  


// Funções

void setup() {  
    Serial.begin(115200);  

   EEPROM.begin(512); // Inicia a EEPROM 
    pinMode(PIN_BOMBA, OUTPUT);  
    digitalWrite(PIN_BOMBA, LOW); // Certifique-se de que a bomba está desligada inicialmente  
    delay(1000);  // Atraso para estabilização do hardware  
    bombaLigada = false; // Inicializa o estado da bomba   

    dht.begin(); // Inicializa o DHT11  

    // Lê os dados armazenados na EEPROM  
    lerDados();  

    // Mostra os dados recuperados  
    Serial.print("Dados recuperados: \n");  
    Serial.print("Vazão: "); Serial.println(atualVazao);  
    Serial.print("Umidade: "); Serial.println(umidadeLigar);  
    Serial.print("Temperatura: "); Serial.println(atualTemperatura);  
    Serial.print("Tempo ligada: "); Serial.println(tempoLigada);  
    Serial.print("Modo: "); Serial.println(atualModo);  
    Serial.print("Horários: ");  
    for (int i = 0; i < numHorarios; i++) {  
        Serial.println(horarios[i]);  
    } 

    conectarWiFi();           // Conecta-se à rede Wi-Fi  
    sincronizarTempo();       // Sincroniza o tempo NTP  
    configurarServidor();     // Configura o servidor web  
}

void loop()
{
    atualizarTempoNTP(); // Atualiza o tempo do NTP
    processarDados();    // Processa os dados de tempo e controla a bomba
    manipularCliente();  // Trata as solicitações do cliente
}

void configurarServidor()
{
    server.begin(); // Inicia o servidor
    Serial.println("Servidor iniciado");
    // Roteamento do servidor para a página inicial
    server.on("/server", []()
              { server.send(200, "text/plain", "Servidor está funcionando."); });
}



void conectarWiFi()
{
    WiFi.begin(ssid, password);
    while (WiFi.status() != WL_CONNECTED)
    {
        delay(500);
        Serial.print("Tentando conectar à rede -> ");
        Serial.println(ssid);
        Serial.print(".");
    }
    Serial.println("Conectado à rede Wi-Fi");
    Serial.print("IP: ");
    Serial.println(WiFi.localIP());
}

void sincronizarTempo()
{
    timeClient.begin();
    while (!timeClient.update())
    {
        Serial.println("Aguardando sincronização com NTP...");
        delay(1000);
    }
    Serial.println("Sincronizado com sucesso!");
}

// Inicializações do LOOP

void atualizarTempoNTP()
{
    timeClient.update(); // Atualiza o tempo do NTP
}

void manipularCliente()
{
    server.handleClient(); // Trata solicitações do cliente
    if (WiFi.status() == WL_CONNECTED)
    {
        enviarDadosParaServidor();
        delay(55000); // Envia dados a cada 30 segundos
    }
    else
    {
        Serial.println("WiFi não conectado, aguardando conexão...");
        delay(5000); // Aguarda um pouco antes de verificar novamente
    }
}

// Função para salvar todos os dados na EEPROM  
void salvarDados(float vazao, float umidade, float temperatura, int periodo, String modo) {  
    // Salva a vazão  
    EEPROM.put(ADDR_VAZAO, vazao);  
    // Salva a umidade  
    EEPROM.put(ADDR_UMIDADE, umidade);  
    // Salva a temperatura  
    EEPROM.put(ADDR_TEMPERATURA, temperatura);  
    // Salva o período  
    EEPROM.put(ADDR_PERIODO, periodo);  
    // Salva o modo  
    EEPROM.put(ADDR_MODO, modo.c_str()); // Salva a string do modo  

    // Salva os horários  
    for (int i = 0; i < MAX_HORARIOS; i++) {  
        String horario = (i < numHorarios) ? horarios[i] : "";  
        EEPROM.put(ADDR_HORARIOS + i * 20, horario); // Armazena cada horário  
    }  

    EEPROM.commit(); // Grava os dados na EEPROM  
}  

// Função para ler todos os dados da EEPROM  
void lerDados() {  
    EEPROM.get(ADDR_VAZAO, atualVazao);  
    EEPROM.get(ADDR_UMIDADE, umidadeLigar);  
    EEPROM.get(ADDR_TEMPERATURA, atualTemperatura);  
    EEPROM.get(ADDR_PERIODO, tempoLigada);  
    
    char modoBuffer[20]; // Buffer para armazenar o modo  
    EEPROM.get(ADDR_MODO, modoBuffer);  
    atualModo = String(modoBuffer);  

    numHorarios = 0; // Reseta o contador de horários  
    for (int i = 0; i < MAX_HORARIOS; i++) {  
        String horario;  
        EEPROM.get(ADDR_HORARIOS + i * 20, horario);  
        if (horario.length() > 0) { // Verifica se há algo a ser armazenado  
            horarios[numHorarios++] = horario; // Armazena o horário  
        }  
    }  
} 

void processarDados()
{
    unsigned long epochTime = timeClient.getEpochTime();
    if (epochTime != 0)
    {                                              // Verifica se o tempo é válido
        int horaAtual = timeClient.getHours();     // Hora atual em formato 24h
        int minutoAtual = timeClient.getMinutes(); // Minutos atuais
        int diaDaSemana = timeClient.getDay();     // Dia da semana (0 = Domingo, 1 = Segunda, ..., 6 = Sábado)

        // Formatação no formato hh:mm
        String horasMinutos = String(horaAtual) + ":" + (minutoAtual < 10 ? "0" : "") + String(minutoAtual);
        formatarHoraAtual(horaAtual);

        Serial.print("Hora atual: ");
        Serial.println(horasMinutos); // Mostra a string formatada

        Serial.print("Dia da Semana: ");
        Serial.println(diaDaSemana);

        Serial.print("Umidade para ligar: ");
        Serial.println(umidadeLigar);

         Serial.print("tempo bomba ligada: ");
        Serial.println(tempoLigada);

        Serial.print("Bomba ligada: ");
        Serial.println(bombaLigada);

        // Chama a função de controle da bomba
        controlarBomba(diaDaSemana, horaAtual, minutoAtual); // Passa apenas horaAtual e minutoAtual
    }
    else
    {
        Serial.println("Erro ao obter tempo NTP.");
    }

    imprimirHorariosLigados(); // Chama a função para imprimir os horários
    delay(1000);               // Aguarda um segundo antes da próxima iteração
}

// Funções relacionadas ao processarDados()


void formatarHoraAtual(int horaAtual)
{
    // Divida a hora atual para obter horas e minutos
    int horas = horaAtual / 10000;           // Extraí as horas
    int minutos = (horaAtual % 10000) / 100; // Extraí os minutos

    // Formatar a string no formato HH:MM
    String horaFormatada = String(horas) + ":" + String(minutos);

    // Certificando-se de que está no formato de dois dígitos
    if (horas < 10)
        horaFormatada = "0" + horaFormatada; // Adiciona zero à esquerda das horas
    if (minutos < 10)
        horaFormatada += "0"; // Adiciona zero à esquerda dos minutos

    // Imprimindo a hora formatada
    Serial.print("Hora atuala: ");
    Serial.println(horaFormatada);
}

// Funções de leitura e controle de bomba

float lerTemperatura(){
   dht.begin();   
   delay(2000);   
   
  //float h = dht.readHumidity();  
   float temperatura = dht.readTemperature();  
 //isnan(umidade) ||  
   if (isnan(temperatura)) {  
     Serial.println("Falha ao ler do DHT sensor!");  

   }  
      return temperatura;
}
float lerUmidade() {  
  int sensorValue = analogRead(sensorPin); 
  float umidade = map(sensorValue, 4095, 0, 0, 100);
   delay(1000);
 return umidade; // Retorna o valor de umidade
   
}
void ligarbomba()
{
    if (!bombaLigada)
    {
        digitalWrite(PIN_BOMBA, HIGH); // Liga a bomba
        bombaLigada = true;            // Atualiza o estado da bomba
        bombaLigadaInicio = millis();  // Marca o tempo que a bomba foi ligada
        jsonResponse["status"] = "success";
        jsonResponse["message"] = "Bomba ligada.";
        Serial.println("Bomba de água ligada.");
    }
    else
    {
        jsonResponse["status"] = "error";
        jsonResponse["message"] = "A bomba já está ligada.";
    }
}

void desligarbomba()  
{  
    if (bombaLigada)  
    {  
        Serial.println("Desligando a bomba..."); // Mensagem de depuração  
        digitalWrite(PIN_BOMBA, LOW);                     // Desliga a bomba  
        tempoBombaLigada += millis() - bombaLigadaInicio; // Calcula o tempo total que a bomba ficou ligada  
        bombaLigada = false;                              // Atualiza o estado da bomba  
        jsonResponse["status"] = "success";  
        jsonResponse["message"] = "Bomba desligada.";  
        Serial.println("Bomba de água desligada.");  
    }  
    else  
    {  
        Serial.println("A bomba já está desligada."); // Mensagem de depuração  
        jsonResponse["status"] = "error";  
        jsonResponse["message"] = "A bomba já está desligada.";  
    }  
}  

void controlarBomba(int diaDaSemana, int horaAtual, int minutoAtual)  
{  
    Serial.println("Atualizando status da bomba...");  

    float umidadeAtual = lerUmidade();  
    Serial.print("Umidade do solo: ");  
    Serial.println(umidadeAtual);  

    bool horaValida = false; // Inicializa a variável horaValida  

    // Converte a hora atual para o formato HHMM  
    int horasMinutosAtuais = (horaAtual * 100) + minutoAtual; // Agora, inclui os minutos na conversão  

    // Verifica se a hora atual é compatível com os horários de ligação  
    for (int j = 0; j < MAX_HORARIOS; j++)  
    {  
        // Verifica se há um horário armazenado  
        if (!horariosLigados[diaDaSemana][j].isEmpty())  
        {  
            String horarioStr = horariosLigados[diaDaSemana][j];  
            int horario = horarioStr.substring(0, 2).toInt() * 100 + horarioStr.substring(3, 5).toInt(); // Converte HH:MM para HHMM  

            // Imprime o horário que está sendo verificado e a hora atual  
            Serial.print("Verificando horário programado: ");  
            Serial.print(horarioStr);  
            Serial.print(" (HHMM: ");  
            Serial.print(horario);  
            Serial.print(") contra a hora atual: ");  
            Serial.println(horasMinutosAtuais);  
            Serial.print("Horas: ");  
            Serial.println(horaAtual);  

            // Verifica se a hora atual coincide exatamente com a hora programada  
            if (horasMinutosAtuais == horario)  
            {  
                horaValida = true; // Hora válida encontrada  
                break;  
            }  
        }  
    }  

    // Se a umidade estiver abaixo do limite e for o dia e hora de ligar a bomba  
    if (umidadeAtual < umidadeLigar && horaValida)  
    {  
        if (!bombaLigada)  
        {  
            ligarbomba();  
            bombaLigadaInicio2 = millis();  // Armazena o tempo em que a bomba foi ligada  
            Serial.println("Modo automático ligado.");  
        }  
    }  

    // Se a bomba estiver ligada, verifica se o tempo máximo foi atingido  
    if (bombaLigada)  
    {  
        // Verifica se já passou o tempo máximo  
        if (millis() - bombaLigadaInicio2 >= tempoLigada) // Usa tempoLigada  
        {  
            desligarbomba(); // Desliga a bomba após o tempo máximo  
            bombaLigada = false; // Atualiza o estado da bomba  
            Serial.println("Modo automático desligado.");  
        }  
    }  
}
void imprimirHorariosLigados()
{
    Serial.println("Horários Ligados:");
    for (int dia = 0; dia < 7; dia++)
    { // Para cada dia da semana
        Serial.print("Dia ");
        Serial.print(dia);
        Serial.print(": ");
        bool temHorarios = false; // Para verificar se há horários
        for (int horario = 0; horario < MAX_HORARIOS; horario++)
        { // Para cada horário
            if (horariosLigados[dia][horario] != "")
            {
                Serial.print(horariosLigados[dia][horario]);
                Serial.print(" "); // Espaço entre os horários
                temHorarios = true;
            }
        }
        if (!temHorarios)
        {
            Serial.print("Nenhum horário ligado."); // Mensagem caso não tenha horários
        }
        Serial.println(); // Nova linha após imprimir todos os horários de um dia
    }
}


// Funções relacionadas ao manipularCliente()

void enviarDadosParaServidor()
{
    float litros_bomba = 0;
    litros_bomba = (tempoBombaLigada / 60000.0) * (double)atualVazao; // Calcular litros de água

    Serial.print("Umidade do solo: ");
    Serial.print(lerUmidade());
    Serial.print(" | Temperatura: ");
    Serial.print(lerTemperatura());
    Serial.print(" | Total que a bomba ficou ligada: ");
    Serial.print(tempoBombaLigada);
    Serial.print(" ms | Litros de água utilizados: ");
    Serial.print(litros_bomba);
    Serial.println(" L");

   WiFiClientSecure client;  // Usando WiFiClientSecure para HTTPS  
     client.setInsecure(); // Para conexões sem verificação do certificado (não recomendado)  

   // Conectar ao servidor usando o nome mDNS  
      Serial.print("Tentando conectar ao servidor: ");  
      Serial.print(endpoint);  
      Serial.print(":");  
      Serial.println(serverPort); 

     if (!client.connect("sistemafacilitado.alphi.media", serverPortsecure)) {  
         Serial.println("Connection to server failed");  
         return;  
     } else {  
         Serial.println("Connected to server");  
     }   
     // Prepare os dados a serem enviados  
     String postData = "temperatura=" + String(lerTemperatura()) +  
                       "&umidade=" + String(lerUmidade()) +  
                       "&litros_bomba=" + String(litros_bomba) +  
                       "&numeracao=" + String(numeracao);
                      
  client.print(String("POST ") + "/include/adddados_disp.php HTTP/1.1\r\n" + 
                  "Host: sistemafacilitado.alphi.media\r\n" +  
                  "Content-Type: application/x-www-form-urlencoded\r\n" +  
                  "Content-Length: " + postData.length() + "\r\n\r\n" +
                  postData); 

    unsigned long timeout = millis();
    String response = "";  // Garantir que a variável 'response' seja limpa a cada execução
    while (client.available() == 0)
    {
        if (millis() - timeout > 50000)
        {
            Serial.println("Timeout de leitura do servidor");
            client.stop();
            return;
        }
    }

    while (client.available())
    {
        String line = client.readStringUntil('\n');
        Serial.println(line); // Imprime cada linha recebida
        response += line + '\n';
    }
    // Separar conteúdo do JSON
    int jsonStart = response.indexOf('{'); // Encontra o índice do começo do JSON
    if (jsonStart != -1)
    {
        response = response.substring(jsonStart);     // Pega apenas o JSON
        Serial.println("JSON Completo: " + response); // Imprime o JSON extraído
        processResponse(response);
    }
    else
    {
        Serial.println("Erro: JSON não encontrado na resposta.");
    }

    // Reiniciar tempoBombaLigada se necessário  
    tempoBombaLigada = 0; // Zera o tempo de operação da bomba após enviar os dados  

    client.stop();
    Serial.println("Dados enviados ao servidor com sucesso.");
}

// Função para processar a resposta e salvar os dados  
void processResponse(String response) {  
    StaticJsonDocument<1024> doc;  
    DeserializationError error = deserializeJson(doc, response);  
    if (error) {  
        Serial.print(F("Falha ao analisar JSON! Código de erro: "));  
        Serial.println(error.c_str());  
        return;  
    }  

    float vazao = doc["vazao"] | 0.000;  
    float newUmidade = doc["atualUmidade"] | 0.0;  
    float newTemperatura = doc["atualTemperatura"] | 0.0;  

    // Captura o campo "periodo" e converte para inteiro  
    String periodoStr = doc["periodo"] | "0"; // Captura como string  
    int periodo = periodoStr.toInt(); // Converte para inteiro  

    String modo = doc["modo"] | "";  

    if (vazao != atualVazao) {  
        atualVazao = vazao;  
        Serial.print("Vazão atualizada: ");  
        Serial.println(atualVazao);  
    }  

    if (newUmidade != umidadeLigar) {  
        umidadeLigar = newUmidade;  
        Serial.print("Umidade atualizada: ");  
        Serial.println(umidadeLigar);  
    }  

    if (newTemperatura != atualTemperatura) {  
        atualTemperatura = newTemperatura;  
        Serial.print("Temperatura atualizada: ");  
        Serial.println(atualTemperatura);  
    }  

    // Atualizando mapeamento do período  
    if (periodo != tempoLigada) {  
        tempoLigada = periodo;  
        Serial.print("Tempo de bomba ligada atualizado: ");  
        Serial.println(tempoLigada);  
    } else {  
        Serial.println("O período não mudou.");  
    }  

    if (modo != atualModo) {  
        atualModo = modo; // Atualiza o modo atual  
        Serial.print("Modo atualizado: ");  
        Serial.println(modo);  
    }  

    // Captura o tempo e armazena os dias e horários  
    String timeJson = doc["time"]; // Captura a string do tempo  

    // Remove as aspas externas  
    timeJson.remove(0, 1);                      // Remove o primeiro caractere de escape  
    timeJson.remove(timeJson.length() - 1);     // Remove o último caractere de escape  

    // Substitui as sequências de escape  
    timeJson.replace("\\\"", "\"");              // Substitui as aspas escapadas por aspas normais  

    // Para depuração, mostre a string timeJson após o processamento  
    Serial.print("String timeJson processada: ");  
    Serial.println(timeJson);  

    // Agora, precisamos desserializar o JSON interno  
    StaticJsonDocument<512> timeDoc; // Documento para armazenar o JSON interno  
    error = deserializeJson(timeDoc, timeJson);  
    if (error) {  
        Serial.print(F("Falha ao analisar JSON interno! Código de erro: "));  
        Serial.println(error.c_str()); // Mostra o código de erro  
        return;  
    }  

    // Chama a função para capturar os horários  
    numHorarios = 0; // Reinicia o contador de horários  
    for (JsonVariant horario : timeDoc["horarios"].as<JsonArray>()) {  
        if (numHorarios < MAX_HORARIOS) {  
            horarios[numHorarios++] = horario.as<String>(); // Armazena o horário  
        } else {  
            Serial.println("Número máximo de horários atingido.");  
        }  
    }  

     // Chama a função para capturar os horários  
    capturarHorarios(timeJson); 
    // Salva todos os dados na EEPROM  
    salvarDados(atualVazao, umidadeLigar, atualTemperatura, tempoLigada, atualModo); 

    
    
}
void capturarHorarios(String timeJson)
{
    String jsonString = String(timeJson); // Armazena a entrada do JSON

    // Remove as aspas externas e decodifica as barras invertidas
    if (jsonString.startsWith("\"{") && jsonString.endsWith("\"}"))
    {
        jsonString = jsonString.substring(1, jsonString.length() - 1); // Remove as aspas externas
    }

    // Debugar a string capturada antes da limpeza
    Serial.print("JSON Original: ");
    Serial.println(jsonString);

    // Limpeza de barras invertidas
    jsonString.replace("\\\"", "\""); // Remove a escapagem das aspas
    jsonString.replace("\\\\", "\\"); // Remove barras invertidas adicionais

    // Debugar a string após limpeza
    Serial.print("JSON Cleaned: ");
    Serial.println(jsonString);

    // Limpar o conteúdo do StaticJsonDocument
    limparJsonDocument();

    // Criar documento JSON
    DeserializationError timeError = deserializeJson(timeDoc, jsonString);
    if (timeError)
    {
        Serial.print("Erro ao ler JSON de tempo: ");
        Serial.println(timeError.c_str());
        return;
    }

    // Limpar todos os horários existentes antes de atualizar
    limparHorarios();
    // Captura os dias e horários
    for (int i = 0; i < 7; i++)
    {                           // Loop pelos dias da semana (0 a 6)
        String key = String(i); // Converte o inteiro i para string

        Serial.print("Verificando chave: "); // Mensagem de depuração para cada chave
        Serial.println(key);

        if (timeDoc.containsKey(key))
        {                                           // Uso da chave como string
            JsonArray novosHorarios = timeDoc[key]; // Captura o array de horários para o dia
            atualizarHorarios(i, novosHorarios);    // Atualiza os horários para o dia
        }
        else
        {
            Serial.print("Dia "); // Mensagem de depuração para o dia
            Serial.print(i);
            Serial.println(" não encontrado."); // Mensagem se não encontrar horários para o dia
        }
    }

    // Imprimir horários ligados após a atualização
    Serial.println("Horários capturados e atualizados:"); // Mensagem de atualização
    imprimirHorariosLigados();
}

void limparJsonDocument() {
    // Limpa o conteúdo do StaticJsonDocument
    timeDoc.clear();  
    Serial.println("Dados do StaticJsonDocument foram limpos.");
}

void limparHorarios()
{
    for (int i = 0; i < 7; i++)
    { // Para cada dia da semana
        for (int j = 0; j < MAX_HORARIOS; j++)
        {                               // Limpa cada horário armazenado
            horariosLigados[i][j] = ""; // Definindo como string vazia
        }
    }
    Serial.println("Todos os horários foram limpos."); // Mensagem após limpeza
}

void atualizarHorarios(int dia, JsonArray &novosHorarios)
{
    if (dia < 0 || dia >= 7)
    {
        Serial.println("Dia inválido.");
        return;
    }

    // Limpa os horários antigos antes de atualizar
    for (int k = 0; k < MAX_HORARIOS; k++)
    {
        horariosLigados[dia][k] = ""; // Limpa o horário, se desejado
    }

    // Loop através dos novos horários
    for (int j = 0; j < novosHorarios.size(); j++)
    {
        String novoHorario = novosHorarios[j].as<String>();

        // Se o novo horário não está no conjunto, adiciona
        if (horariosExistentes[dia].find(novoHorario) == horariosExistentes[dia].end())
        {
            adicionarHorario(dia, novoHorario);
            Serial.print("Adicionado: Dia ");
            Serial.print(dia);
            Serial.print(", Horário: ");
            Serial.println(novoHorario);
        }
        else
        {
            Serial.print("Horário já existente não adicionado: ");
            Serial.println(novoHorario);
        }
    }

    Serial.print("Horários do dia ");
    Serial.print(dia);
    Serial.println(" atualizados.");
}

void adicionarHorario(int dia, String &horario)
{
    bool horarioAdicionado = false; // Flag para verificar se o horário foi adicionado

    for (int k = 0; k < MAX_HORARIOS; k++)
    {
        if (horariosLigados[dia][k].isEmpty())
        {                                      // Encontre um espaço vazio para adicionar o horário
            horariosLigados[dia][k] = horario; // Armazena o horário
            Serial.print("Adicionado: Dia ");
            Serial.print(dia);
            Serial.print(", Horário: ");
            Serial.println(horario);
            horarioAdicionado = true; // Marca que o horário foi adicionado
            break;                    // Sai do loop após adicionar
        }
        else if (horariosLigados[dia][k] == horario)
        {
            Serial.print("Horário já está programado: ");
            Serial.println(horario);
            return; // Não adiciona se já existir
        }
    }

    // Caso não tenha adicionado, avise que não há espaço
    if (!horarioAdicionado)
    {
        Serial.print("Não foi possível adicionar o horário: ");
        Serial.println(horario);
        Serial.print(" - Limite de horários atingido para o dia: ");
        Serial.println(dia);
    }
}



