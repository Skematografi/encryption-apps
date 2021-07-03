# Reject Retur Supplier App 
Specification :
1. PHP 7.*
2. Framework Laravel 7
3. MySQL

Required :
1. MySql
2. Composer (link download : https://getcomposer.org/download/)
3. Nodejs (link download : https://nodejs.org/en/)

Installation :
1. start mysql on xampp app
2. open git bash (link download software : https://git-scm.com/download/win) in c:\xampp\htdocs\here 
3. git clone https://github.com/Skematografi/reject-retur-supplier.git
4. create database, default config :
```
database : invoice
username : root
password : 
```
5. run script on git bash / terminal
```
cp .env.example .env
php artisan key:generate
composer update
php artisan migrate:fresh --seed
php artisan optimize:clear
php artisan config:clear
```
6. run `php artisan serve`
7. open browser with url `http://localhost:8000`