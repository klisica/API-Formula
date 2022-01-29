<?php

namespace KLisica\ApiFormula\Commands;

use Illuminate\Console\Command;
use KLisica\ApiFormula\Extended\GeneratorCommand;

class CreateRepositoryInterface extends GeneratorCommand
{
    protected $signature    = 'api-make:repository-interface {name} {--model=}';
    protected $description  = 'Create and publish Repository Interface instance.';
    protected $type         = 'RepositoryInterface';

    protected function getStub()
    {
        return __DIR__ . '/Stubs/RepositoryInterface.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        $versioning_enabled
            = (bool) config('api._version') &&
            !in_array('repositories', config('api-formula.versioning_disabled_for'));

        return $versioning_enabled
            ? "$rootNamespace\\Repositories\\" . config('api._version')
            : "$rootNamespace\\Repositories";
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->_FILE_NAME = "Interfaces\\" . $this->getNameInput();
        $this->_MODEL_NAME = $this->option('model') ?? null;

        // Check whether the model parameter is provided.
        if (!$this->_MODEL_NAME) {
            $this->error('Model parameter is missing!');
            return false;
        }

        $sts = $this->_startFileBuilder();
        return $sts ? Command::SUCCESS : Command::FAILURE;
    }
}
