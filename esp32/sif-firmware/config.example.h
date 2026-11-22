// Copie este arquivo para "config.h" e preencha com os seus dados.
// O config.h não vai para o git, então as senhas ficam só no seu computador.
#pragma once

// ---------- rede ----------
#define WIFI_NOME      "nome-da-sua-rede"
#define WIFI_SENHA     "senha-da-sua-rede"

// ---------- servidor (plataforma SIF em Laravel) ----------
// Endereço base, sem barra no final. Ex.: "http://192.168.0.10:8000" ou "https://sif.exemplo.com"
#define SERVIDOR_URL   "http://192.168.0.10:8000"

// Numeração do dispositivo, igual à cadastrada na plataforma (8 caracteres)
#define NUMERACAO      "00000001"

// ---------- pinos ----------
#define PINO_DHT       2    // DHT11: temperatura do ar
#define PINO_SOLO      32   // sensor de umidade do solo (analógico)
#define PINO_BOMBA     4    // relé da bomba

// Leitura do sensor de solo: valor no ar (seco) e na água (molhado).
// Meça com o seu sensor e ajuste. Os padrões abaixo são os extremos do ADC do ESP32.
#define SOLO_SECO      4095
#define SOLO_MOLHADO   0

// ---------- tempos ----------
#define FUSO_HORARIO_SEGUNDOS  (-3 * 3600)   // horário de Brasília
#define INTERVALO_ENVIO_MS     60000UL       // envia leituras a cada 1 minuto
#define INTERVALO_LEITURA_MS   5000UL        // lê os sensores a cada 5 segundos

// Segurança: a bomba nunca fica ligada mais que isto de uma vez, em nenhum modo
#define BOMBA_MAXIMO_MS        (15UL * 60UL * 1000UL)

// Modo automático: depois de ligar, desliga quando a umidade passar do alvo + esta folga (%)
#define FOLGA_UMIDADE          5
