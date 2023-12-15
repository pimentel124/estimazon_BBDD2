
# Estimazon

## Prerequisits

- [PHP 8+](https://www.php.net/downloads.php)
- [Node.js](https://nodejs.org/en/download/)
- [MySQL](https://dev.mysql.com/downloads/installer/)
- [Composer](https://getcomposer.org/download/)

**Note:** If you are using Windows, you can use [XAMPP](https://www.apachefriends.org/download.html) to install PHP, MySQL and Composer.

### Clone the repository and enter the project folder

```bash
git clone https://github.com/pimentel124/estimazon_BBDD2
cd estimazon_BBDD2
```

### Install the dependencies

```bash
composer update

composer install

npm install

npm run build

php artisan storage:link

```

### Opiton 1 - Run create the database and run the migrations

The database must be called `BD2KMIKZS`

```bash
php artisan migrate
php artisan db:seed
```

#### Option 2 - Import the database manually

the database is located on the root of the project and is called `BD2KMIKZS.sql`

#### Run the project

```bash
php artisan serve
```
