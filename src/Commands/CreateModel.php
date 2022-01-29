<?php

namespace KLisica\ApiFormula\Commands;

use KLisica\ApiFormula\Extended\GeneratorCommand;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class CreateModel extends GeneratorCommand
{
    protected $signature    = 'api-make:model {name} {--M|migration}';
    protected $description  = 'Create model instance.';
    protected $type         = 'Model';

    protected function getStub()
    {
        return __DIR__ . '/Stubs/Model.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        $versioning_enabled
            = (bool) config('api._version') &&
            !in_array('models', config('api-formula.versioning_disabled_for'));

        return $versioning_enabled
            ? "$rootNamespace\\Models\\" . config('api._version')
            : "$rootNamespace\\Models";
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->_FILE_NAME = $this->getNameInput();
        $sts = $this->_startFileBuilder();

        if ($this->option('migration')) {
            // Create the migration.
            $migration = 'create_' . Str::snake(Str::plural($this->_FILE_NAME)) . '_table';
            $this->call("api-make:migration", ['name' => $migration]);
        }

        return $sts ? Command::SUCCESS : Command::FAILURE;
    }
}