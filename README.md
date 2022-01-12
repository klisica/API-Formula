# 🧑‍🔬 API-Formula

#### Laravel API architecture builder based on artisan commands.

## Instalation

``` shell
composer require klisica/api-formula
```

## Setup

``` shell
php artisan api-formula:setup
```

Once RepositoryServiceProvider.php is created you will need to register it in providers section in `config > app.php > providers`:

```
App\Providers\RepositoryServiceProvider::class,
```

## Building the API

``` shell
php artisan api-make:formula
```

## API Components

#### 1. Repositories
