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

Next, in `routes > api.php` add `// @API_FORMULA_AUTOIMPORT` comment in order to enable auto importing of resource routes. For example, I like to bind the importing in middleware group:

``` php
...
Route::midleware('auth:sanctum')->group(function () {
    Route::resource('job_posts', 'JobPostController')->parameters(['' => 'job_post']);
    ...
    // @API_FORMULA_AUTOIMPORT
});
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

<br />

## Filtering and sorting on models

Each model is using a custom **Filterable** trait, which is handling simple query-based filtering and sorting functions on models.

- Filters are accepted in format `column[operator]=value`.
- To filter by **relations** the format is `relationName|column[operator]=value` (note the `|` separator in between).
- Free-text filter is by default `_text` query parameter.

**JSON example:**

```js
{
    page: 1,
    per_page: 10,
    sort_by: ['created_at', 'desc'],
    'name[equal]': 'Name example',
    'relation|name[equal]': 'Relation name example',
    '_text': 'Search for something'
74

}
```

**Raw URL-Query example:**

```html
http://api-formula.test/api/job_posts?per_page=10&page=1&sort_by[0]=created_at&sort_by[1]=desc&name[equal]=Name example&relation|name[equal]=Relation name example
```
