# Sistema de Irrigação Facilitado (SIF)
Com o SIF, é possivel monitorar e configurar um sistema de irrigação com acesso a internet, com o objetivo de tornar o processo mais preciso possivel. Este projeto foi criado com o intuito de facilitar o cuidado de plantas de forma acessivel, com o principal foco a agricultura familiar.

Criado inicialmente com PHP puro, decidimos disponibilizar o projeto, porem em uma versão melhorada com o framework Laravel, para facilitar o deploy da aplicação e manutenção do projeto.

Apresentado e premiado na FI Ciências, uma das maiores feiras de ciencia da America Latina, com o 1° Lugar na categoria de Ciências Agrarias em 2024.



## Como rodar
Certifique-se de ter o Docker instalado em sua maquina

1. Clone o repositorio
````
git clone https://github.com/sistema-irrigacao-facilitado/laravel-sif.git
cd laravel-sif
````

2. Copie o arquivo .env.example para um novo arquivo .env
````
cp .env.example .env
````

3. Rode o projeto, e execute o conteiner app com bash
````
docker compose up -d
docker compose exec app bash
````

4. Por fim, rode as migrações do projeto
````
php artisan migrate
````


## Estrutura de arquivos

````

````


## 🌐 Acessos
| Serviço          | URL                                                        |
| ---------------- | ---------------------------------------------------------- |
| Login do Usuario | [http://localhost:8000/](http://localhost:8000/)           |
| Login do Admin   | [http://localhost:8000/admin](http://localhost:8000/admin) |
| phpmyadmin       | [http://localhost:8080](http://localhost:8080)             |



## Login de Administrador

Para acessar o login de administrador, será nescessario rodar um seeder para a criação de um colaborador dentro do sistema, já que não é possivel fazer o cadastro pela tela de login, para isso, rode o seguinte comando para criar um colaborador com acesso de administrador dentro do sistema, suas credenciais para login são:
E-mail: admin@admin.com, senha: admin123
````
php artisan db:seed --class=ManagerAdminSeeder
````



## ⚙️ Personalização
Você pode modificar configurações como porta, credenciais e nome do banco diretamente no arquivo docker-compose.yml.