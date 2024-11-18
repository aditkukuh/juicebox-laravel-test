# Juicebox Laravel Developer Code Test

## 1 Project Setup

### Prerequisites
- PHP 8.x
- Composer
- MySQL
- Laravel CLI

### Installation Steps

#### Clone the Repository
```bash
git clone <repository-url>
cd <project-directory>
```
####  Install Dependencies
```bash
composer install
```
#### Set Up Environment
Copy .env.example to .env:

Copy code
```bash
cp .env.example .env
```
Configure the database settings in the .env file:
makefile
Copy code
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=<your-database-name>
DB_USERNAME=<your-database-username>
DB_PASSWORD=<your-database-password>

####  Generate Application Key
bash
Copy code
```bash
php artisan key:generate
```
####  Run Migrations
```bash
php artisan migrate
```
####  Serve the Application
To start the application, use the following command:
```bash
php artisan serve
```
