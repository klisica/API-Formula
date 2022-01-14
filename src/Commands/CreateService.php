<?php

namespace KLisica\ApiFormula\Commands;

use Illuminate\Console\Command;
use KLisica\ApiFormula\Extended\GeneratorCommand;

class CreateService extends GeneratorCommand
{
    protected $signature    = 'api-make:service {name}';
    protected $description  = 'Create service instance.';
    protected $type         = 'Service';

    protected function getStub()
    {
        return __DIR__ . '/Stubs/Service.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return "$rootNamespace\\Http\\Services";
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
        return $sts ? Command::SUCCESS : Command::FAILURE;
    }
}
