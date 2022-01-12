<?php

namespace KLisica\ApiFormula\Commands;

use Illuminate\Console\Command;
use KLisica\ApiFormula\Extended\GeneratorCommand;

class CreateRepository extends GeneratorCommand
{
    protected $signature    = 'api-make:repository {name} {--model=}';
    protected $description  = 'Create and publish Repository instance.';
    protected $type         = 'Repository';

    protected function getStub()
    {
        return __DIR__ . '/Stubs/Repository.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return "$rootNamespace\\Repositories";
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->_FILE_NAME = $this->getNameInput();
        $this->_MODEL_NAME = $this->option('model') ?? null;

        // Check whether the model parameter is provided.
        if (!$this->_MODEL_NAME) {
            $this->error('Model parameter is missing!');
            return false;
        }

        $sts = $this->_startFileBuilder();

        // Create the repository interface instance.
        $this->call('api-make:repository-interface', [
            'name' => $this->_FILE_NAME . "Interface",
            '--model' => $this->_MODEL_NAME
        ]);

        return $sts ? Command::SUCCESS : Command::FAILURE;
    }
}
