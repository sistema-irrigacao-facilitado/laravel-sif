### 💧 Sobre o Projeto

O **SIF** permite monitorar e configurar um sistema de irrigação via internet, tornando o processo mais preciso e automatizado. Criado com foco na **agricultura familiar**, o projeto busca democratizar o acesso à tecnologia no campo.

Inicialmente desenvolvido em PHP puro, foi posteriormente migrado para **Laravel** visando facilitar o deploy, manutenibilidade e escalabilidade.

🏆 **Premiado com 1º Lugar na categoria Ciências Agrárias da FI Ciências 2024**, uma das maiores feiras de ciência da América Latina.

---

## 🚀 Como Rodar

> **Pré-requisitos**: Docker e Docker Compose instalados.

1. Clone o repositório:

   ```bash
   git clone https://github.com/sistema-irrigacao-facilitado/laravel-sif.git
   cd laravel-sif
   ```

2. Copie o `.env` de exemplo:

   ```bash
   cp .env.example .env
   ```

3. Inicie os containers:

   ```bash
   docker compose up -d
   docker compose exec app bash
   ```

4. Rode as migrações:

   ```bash
   php artisan migrate
   ```

---

## 🗂 Estrutura do Projeto

```
laravel-sif/
├── app/                 # Lógica da aplicação (Models, Controllers, etc.)
├── bootstrap/           # Inicialização do Laravel
├── config/              # Arquivos de configuração
├── database/            # Migrations, Seeders e Factories
├── docker/              # Configurações específicas do Docker
├── node_modules/        # Dependências JS
├── public/              # Entrada pública da aplicação (index.php)
├── resources/           # Views (Blade), Tailwind, etc.
├── routes/              # Arquivos de rotas (web.php, api.php)
├── storage/             # Arquivos gerados pela aplicação (logs, cache, etc.)
├── tests/               # Testes automatizados
├── vendor/              # Dependências PHP via Composer
├── .env                 # Variáveis de ambiente
├── docker-compose.yml  # Orquestração do Docker
├── package.json         # Dependências JS
├── composer.json        # Dependências PHP
└── README.md
```

---

## 🌐 Acessos

| Serviço          | URL                                                        |
| ---------------- | ---------------------------------------------------------- |
| Login do Usuário | [http://localhost:8000/](http://localhost:8000/)           |
| Login do Admin   | [http://localhost:8000/admin](http://localhost:8000/admin) |
| phpMyAdmin       | [http://localhost:8080](http://localhost:8080)             |

---

## 🔐 Login de Administrador

Para criar um usuário administrador, execute o seguinte seeder:

```bash
php artisan db:seed --class=ManagerAdminSeeder
```

**Credenciais Padrão:**

* **E-mail:** [admin@admin.com](mailto:admin@admin.com)
* **Senha:** admin123

---

## ⚙️ Personalização

É possível personalizar portas, nome do banco de dados e credenciais diretamente no arquivo:

```bash
docker-compose.yml
```
