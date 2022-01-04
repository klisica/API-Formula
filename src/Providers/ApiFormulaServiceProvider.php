<?php

namespace KLisica\ApiFormula\Providers;

use Illuminate\Support\ServiceProvider;

// Commands.
use KLisica\ApiFormula\Commands\CreateRepository;
use KLisica\ApiFormula\Commands\CreateRepositoryInterface;

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
            CreateRepositoryInterface::class,
            CreateRepository::class,
        ]);
    }
}