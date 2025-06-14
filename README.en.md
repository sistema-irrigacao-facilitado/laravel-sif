### 💧 About the Project

**SIF** enables monitoring and configuration of an irrigation system via the internet, aiming to make the process as precise and automated as possible. Created with a focus on **family farming**, this project seeks to bring accessible technology to rural producers.

Originally built in pure PHP, the project was upgraded to **Laravel** to simplify deployment and long-term maintenance.

🏆 **Awarded 1st Place in the Agricultural Sciences category at FI Ciências 2024**, one of the largest science fairs in Latin America.

---

### 🚀 How to Run

> **Requirements**: Docker and Docker Compose installed.

1. Clone the repository:

   ```bash
   git clone https://github.com/sistema-irrigacao-facilitado/laravel-sif.git
   cd laravel-sif
   ```

2. Copy the `.env` example file:

   ```bash
   cp .env.example .env
   ```

3. Start the containers:

   ```bash
   docker compose up -d
   docker compose exec app bash
   ```

4. Install composer and generate the project key:

   ```bash
   composer install
   php artisan key:generate
   ```


5. Run the migrations:

   ```bash
   php artisan migrate
   ```

6. Create the public storage link:

   ```bash
   php artisan storage:link
   ```


---

### 🗂 Project Structure

```
laravel-sif/
├── app/                 # Application logic (Models, Controllers, etc.)
├── bootstrap/           # Laravel Initialization
├── config/              # Configuration files
├── database/            # Migrations, Seeders e Factories
├── docker/              # Docker specific configurations
├── node_modules/        # JS Dependencies
├── public/              # Public entry of the application (index.php)
├── resources/           # Views (Blade), Tailwind, etc.
├── routes/              # Route files (web.php, api.php)
├── storage/             # Files generated by the application (logs, cache, etc.)
├── tests/               # Automated testing
├── vendor/              # PHP Dependencies via Composer
├── .env                 # Environment variables
├── docker-compose.yml   # Docker Orchestration
├── package.json         # JS Dependencies
├── composer.json        # PHP Dependencies
└── README.md
```

---

### 🌐 Access URLs

| Service     | URL                                                        |
| ----------- | ---------------------------------------------------------- |
| User Login  | [http://localhost:8000/](http://localhost:8000/)           |
| Admin Login | [http://localhost:8000/admin](http://localhost:8000/admin) |
| phpMyAdmin  | [http://localhost:8080](http://localhost:8080)             |

---

### 🔐 Admin Login

Run the following seeder to create an administrator account:

```bash
php artisan db:seed --class=ManagerAdminSeeder
```

**Default Credentials:**

* **Email:** [admin@admin.com](mailto:admin@admin.com)
* **Password:** admin123

---

## ⚙️ Personalization

You can customize ports, database name and credentials directly in the file:

```bash
docker-compose.yml
```


In this project, we use the ESP32, a microcontroller with built-in Wi-Fi module to perform the irrigation and send data to the system. The .ino code is located inside the esp32 folder.

You will need to change the SSID – your Wi-Fi network name – and its password in the "password" field.
![image](https://github.com/user-attachments/assets/6359b47a-1dbe-4645-8516-50ddc7d027b2)

You’ll also need to change the device number, which is how the system recognizes which device is linked and its settings. This number must be exactly 8 digits long, containing only numbers. You can change it in the following line of code:
![image](https://github.com/user-attachments/assets/968a3bf2-697e-4317-ba0d-e4ecc35239ec)

After making and verifying your changes, you can upload the code to the ESP32. We recommend using the Arduino IDE for that.
