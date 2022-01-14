# 🧑‍🔬 API-Formula

### Laravel API architecture builder based on artisan commands.

This package provides a nice and fluent way to generate combined **controllers**, **models**, **migrations**, **requests**, **resources**, **repositories** and **services**, thus keeping the code well structured and organized.

<br />

## Installation

Install the package with composer, execute the setup command and register the `RepositoryServiceProvider.php` file in `config > app.php` under the `providers` array.

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

<br />


To manually create specific file you can use one of these commands:

``` shell
php artisan api-make:model ModelName
php artisan api-make:migration create_example_table
php artisan api-make:repository RepositoryName --model=ModelName
php artisan api-make:service ServiceName
php artisan api-make:request RequestName
php artisan api-make:controller ControllerName --model=ModelName
```
<br />

Other external packages used with this package:

-  [Laravel Eloquent UUID](https://github.com/goldspecdigital/laravel-eloquent-uuid)
-  [Laracasts Generators](https://packagist.org/packages/laracasts/generators)
