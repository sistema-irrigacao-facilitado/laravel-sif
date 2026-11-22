# Firmware do dispositivo (ESP32)

O código que roda no dispositivo: lê a umidade do solo e a temperatura, controla a bomba e envia as leituras para a rota `POST /api/device/write` desta plataforma. A resposta traz a configuração nova (modo, horários, tempo ligado, umidade ideal e vazão) sempre que ela muda.

Para gravar:

1. Copie `sif-firmware/config.example.h` para `sif-firmware/config.h` e preencha a rede Wi-Fi, o endereço da plataforma e a numeração do dispositivo.
2. Abra `sif-firmware/sif-firmware.ino` na Arduino IDE e instale as bibliotecas *DHT sensor library* (Adafruit), *NTPClient* e *ArduinoJson* (versão 7).

O desenvolvimento do firmware, com a ligação dos fios, o histórico das versões e a configuração para PlatformIO, fica em [nardomaciel/sif-firmware](https://github.com/nardomaciel/sif-firmware).
