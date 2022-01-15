<?php

namespace KLisica\ApiFormula\Commands;

use Illuminate\Console\Command;

class CreateFormula extends Command
{
    protected $signature    = 'api-make:formula';
    protected $description  = 'API Formula root command for scaffolding complete flow.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info("📝 Setting up recipe for API-Formula...");

        $modelChoices = ['Create new', 'Use existing'];
        $modelChoice = $this->choice(
            'Create new model or use existing?',
            $modelChoices,
            0
        );

        if ($modelChoices[0] == $modelChoice) {
            $migrationChoices = ['Yes', 'No'];
            $migrationChoice = $this->choice(
                'Create migration for this model?',
                $migrationChoices,
                0
            );

            // Create new model.
            $modelName = $this->ask('Write new model name:');
            $this->call('api-make:model', [
                'name' => $modelName,
                '--migration' => $migrationChoice == $migrationChoices[0]
            ]);
        } else {
            // Use existing model.
            $modelName = $this->ask('Write existing model name:');
        }

        $buildChoices = ["Yes", "No, I'll do it manually"];
        $buildChoice = $this->choice(
            'Create the complete API architecture automatically?',
            $buildChoices,
            0
        );

        // Ru automatic builds.
        if ($buildChoice == $buildChoices[0]) {
            $this->buildArchitecture($modelName);
            $this->info('🤘  All done!');
            return Command::SUCCESS;
        }

        // Go through each build manually.
        $answers = ['Yes', 'No'];

        $resourceChoice = $this->choice('Create a resource for this model?', $answers, 0);
        $serviceChoice = $this->choice('Create a service for this model?', $answers, 0);
        $requestsChoice = $this->choice('Create requests for this model?', $answers, 0);
        $repositoryChoice = $this->choice('Create a repository for this model?', $answers, 0);
        $controllerChoice = $this->choice('Create a controller for this model?', $answers, 0);
        $factoryChoice = $this->choice('Create a factory for this model?', $answers, 0);
        $testChoice = $this->choice('Create a test for this model?', $answers, 0);

        if ($resourceChoice == $answers[0]) {
            // Create model resource.
            $this->call('make:resource', ['name' => $modelName . 'Resource']);
        }

        if ($serviceChoice == $answers[0]) {
            // Create model service.
            $this->call('api-make:service', ['name' => $modelName . 'Service']);
        }

        if ($requestsChoice == $answers[0]) {
            // Create requests for create and update methods.
            $this->call('api-make:request', ['name' => $modelName . '/Create' . $modelName]);
            $this->call('api-make:request', ['name' => $modelName . '/Update' . $modelName]);
        }

        if ($repositoryChoice == $answers[0]) {
            // Create repository and related interface.
            $this->call('api-make:repository', [
                'name' => $modelName . 'Repository',
                '--model' => $modelName
            ]);
        }

        if ($controllerChoice == $answers[0]) {
            // Create controller.
            $this->call('api-make:controller', [
                'name' => $modelName . 'Controller',
                '--model' => $modelName
            ]);
        }

        if ($factoryChoice == $answers[0]) {
            $this->call('make:factory', ['name' => $modelName . 'Factory']);
        }

        if ($testChoice == $answers[0]) {
            $this->call('make:test', ['name' => $modelName . 'Test']);
        }

        $this->info('🤘  All done!');
        return Command::SUCCESS;
    }

    /**
     * Build the complete architecture automatically.
     *
     */
    public function buildArchitecture(string $modelName)
    {
        // Create model resource.
        if (config('api-formula.create_resource')) {
            $this->call('make:resource', ['name' => $modelName . 'Resource']);
        }

        // Create model service.
        if (config('api-formula.create_service')) {
            $this->call('api-make:service', ['name' => $modelName . 'Service']);
        }

        // Create requests for create and update methods.
        if (config('api-formula.create_requests')) {
            $this->call('api-make:request', ['name' => $modelName . '/Create' . $modelName]);
            $this->call('api-make:request', ['name' => $modelName . '/Update' . $modelName]);
        }

        // Create repository and related interface.
        if (config('api-formula.create_repository')) {
            $this->call('api-make:repository', [
                'name' => $modelName . 'Repository',
                '--model' => $modelName
            ]);
        }

        // Create controller.
        if (config('api-formula.create_controller')) {
            $this->call('api-make:controller', [
                'name' => $modelName . 'Controller',
                '--model' => $modelName
            ]);
        }

        if (config('api-formula.create_test')) {
            $this->call('make:factory', ['name' => $modelName . 'Factory']);
            $this->call('make:test', ['name' => $modelName . 'Test']);
        }
    }
}
