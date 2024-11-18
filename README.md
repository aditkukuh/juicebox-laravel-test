# Juicebox Laravel Developer Code Test

## 1 Project Setup (Laravel 11)

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

```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=<your-database-name>
DB_USERNAME=<your-database-username>
DB_PASSWORD=<your-database-password>
```

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

## 2 API Endpoints
API Lists postman:
https://documenter.getpostman.com/view/24049634/2sAYBPoFdA

## 3 Testing 
run this command for testing:
```bash
 .\vendor\bin\phpunit
```
or
```bash
 php artisan test 
```

## 4 Configure Weather API
set the WEATHER_APP_KEY= with your APP KEY from openweathermap.org
```ini
WEATHER_APP_KEY= <your-app-key>
```
run this command for run the schedule
```bash
php artisan queue:work
```
```bash
php artisan schedule:run
```
and the schedule will automatically run every 1 hour

## 4 Configure MAIL SMTP
set the env value

```ini
MAIL_MAILER=
MAIL_HOST=
MAIL_PORT=
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=
MAIL_FROM_ADDRESS=
MAIL_FROM_NAME=
```

try API register user with valid email for receive the email by the system (don't forget to run queue:work)

for send email manually you can use this command:
```bash
php artisan send:welcome-email <user_id>
```