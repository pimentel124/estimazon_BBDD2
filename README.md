
## How to run the project?

#### Clone this repository

#### Have composer installed on your machine. [Download Composer](https://getcomposer.org/download/)

#### Install the dependencies

```bash
composer update
composer install

npm install
```

#### Create the database and add the credentials to the .env file

The database must be called `estimazon`

#### Run the migrations

```bash
php artisan migrate
```

#### Run the project

```bash
npm run build

php artisan storage:link
php artisan serve
```
