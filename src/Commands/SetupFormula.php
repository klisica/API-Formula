<?php

namespace KLisica\ApiFormula\Commands;

use Illuminate\Console\Command;
use KLisica\ApiFormula\Extended\GeneratorCommand;

class SetupFormula extends GeneratorCommand
{
    protected $signature    = 'api-formula:setup';
    protected $description  = 'Setup API Formula providers.';
    protected $type         = 'Setup';

    protected function getStub()
    {
        return __DIR__ . '/Stubs/RepositoryServiceProvider.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return "$rootNamespace\\Providers";
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->_FILE_NAME = 'RepositoryServiceProvider';
        $sts = $this->_startFileBuilder();
        return $sts ? Command::SUCCESS : Command::FAILURE;
    }
}