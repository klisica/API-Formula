<?php

namespace KLisica\ApiFormula\Providers;

use Illuminate\Support\ServiceProvider;

// Commands.
use KLisica\ApiFormula\Commands\CreateRepository;

class ApiFormulaServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //
    }

    public function register()
    {
        // Registering commands.
        $this->commands([
            CreateRepository::class
        ]);
    }
}