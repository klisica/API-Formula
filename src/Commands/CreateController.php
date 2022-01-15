<?php

namespace KLisica\ApiFormula\Commands;

use Illuminate\Console\Command;
use KLisica\ApiFormula\Extended\GeneratorCommand;
use KLisica\ApiFormula\Helpers\FileManager;

class CreateController extends GeneratorCommand
{
    protected $signature    = 'api-make:controller {name} {--model=}';
    protected $description  = 'Create controller instance.';
    protected $type         = 'Controller';

    protected function getStub()
    {
        return __DIR__ . '/Stubs/Controller.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return "$rootNamespace\\Http\\Controllers";
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

        (new FileManager)->importApiRoute($this->_FILE_NAME, $this->_MODEL_NAME);

        return $sts ? Command::SUCCESS : Command::FAILURE;
    }
}
