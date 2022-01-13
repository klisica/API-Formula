# 🧑‍🔬 API-Formula

### Laravel API architecture builder based on artisan commands.

<br />

## Installation

Install library with composer, execute the setup command and register the `RepositoryServiceProvider.php` file in `config > app.php` under the `providers` array.

``` shell
composer require klisica/api-formula
```

``` shell
php artisan api-formula:setup
```

``` php
'providers' => [
    ...
    App\Providers\RepositoryServiceProvider::class,
    ...
 ],
```

<br />

## Usage

⭐ To start the API builder run the following command:

``` shell
php artisan api-make:formula
```

In this shell we'll run multiple commands under the hood, in order to create the API structure. All these commands are generating specified set of files like **Models**, **Repositories**, **Controllers** and **Migrations**.

To manually create specific file you can use one of these commands:

``` shell
php artisan api-make:model ModelName
php artisan api-make:migration create_example_table
php artisan api-make:repository RepositoryName --model=ModelName
```
