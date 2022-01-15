<?php

namespace KLisica\ApiFormula\Providers;

use Illuminate\Support\ServiceProvider;
use KLisica\ApiFormula\Commands\CreateController;
// Commands.
use KLisica\ApiFormula\Commands\SetupFormula;
use KLisica\ApiFormula\Commands\CreateFormula;
use KLisica\ApiFormula\Commands\CreateMigration;
use KLisica\ApiFormula\Commands\CreateModel;
use KLisica\ApiFormula\Commands\CreateRepository;
use KLisica\ApiFormula\Commands\CreateRepositoryInterface;
use KLisica\ApiFormula\Commands\CreateRequest;
use KLisica\ApiFormula\Commands\CreateService;

class ApiFormulaServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            // Publish the configuration file.
            $this->publishes([
                dirname(__DIR__, 2) . '/config/config.php'
                    => config_path('api-formula.php'),
            ]);
          }
    }

    public function register()
    {
        // Registering configuration file.
        $this->mergeConfigFrom(
            dirname(__DIR__, 2) . '/config/config.php',
            'api-formula'
        );

        // Registering commands.
        $this->commands([
            SetupFormula::class,
            CreateFormula::class,

            // Sub-commands.
            CreateModel::class,
            CreateMigration::class,
            CreateRepositoryInterface::class,
            CreateRepository::class,
            CreateService::class,
            CreateRequest::class,
            CreateController::class,
        ]);
    }
}