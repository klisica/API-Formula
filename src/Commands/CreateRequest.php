<?php

namespace KLisica\ApiFormula\Commands;

use Illuminate\Console\Command;
use KLisica\ApiFormula\Extended\GeneratorCommand;

class CreateRequest extends GeneratorCommand
{
    protected $signature    = 'api-make:request {name}';
    protected $description  = 'Create request instance.';
    protected $type         = 'Request';

    protected function getStub()
    {
        return __DIR__ . '/Stubs/Request.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        $versioning_enabled
            = (bool) config('api._version') &&
            !in_array('requests', config('api-formula.versioning_disabled_for'));

        return $versioning_enabled
            ? "$rootNamespace\\Requests\\" . config('api._version')
            : "$rootNamespace\\Requests";
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
