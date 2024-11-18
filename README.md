# Laravel RESTful API Project

## Objective
This project demonstrates proficiency in Laravel API development, including authentication, database design, and adherence to best practices through a RESTful API implementation.

## Project Setup

### Prerequisites
- PHP 8.x
- Composer
- MySQL
- Laravel CLI

### Installation Steps

#### 1. Clone the Repository
```bash
git clone <repository-url>
cd <project-directory>
2. Install Dependencies
bash
Copy code
composer install
3. Set Up Environment
Copy .env.example to .env:

bash
Copy code
cp .env.example .env
Configure the database settings in the .env file:

makefile
Copy code
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=<your-database-name>
DB_USERNAME=<your-database-username>
DB_PASSWORD=<your-database-password>
4. Generate Application Key
bash
Copy code
php artisan key:generate
5. Run Migrations
bash
Copy code
php artisan migrate
6. Serve the Application
To start the application, use the following command:

bash
Copy code
php artisan serve