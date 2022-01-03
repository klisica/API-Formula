<?php

namespace KLisica\ApiFormula\Providers;

use Illuminate\Support\ServiceProvider;

class ApiFormulaServiceProvider extends ServiceProvider
{
    public function boot()
    {
        info('Package works!');
    }

    public function register()
    {

    }
}