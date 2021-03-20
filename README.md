# Choco Test Project

## Installing

Go to project directory and install defined dependencies for project by running the `install` command:

```
composer install
```

## Configure

To configure your environment, you need copy `.env.example` and rename it to `.env`:

```
cp .env.example .env
```

Open `.env` file with your favorite editor, and setup database connection:

```
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```

Generate your application encryption key using:

```
php artisan key:generate
```

Generate secret key

```
php artisan jwt:secret
```

## Local Run

First you need enter `migrate:fresh` command, to run all of migrations and seed your database:

```
php artisan migrate:fresh --seed
```

You can use the `serve` Artisan command to start the server. This command will start the development server at `http://localhost:8000`:

```
php artisan serve
```

## Login information

| E-mail | Password |
| --- | --- |
| admin@example.org | password |
| moderator@example.org | password |
| user@example.org | password |
