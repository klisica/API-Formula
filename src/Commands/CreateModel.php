<?php

namespace KLisica\ApiFormula\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\GeneratorCommand;

class CreateModel extends GeneratorCommand
{
    public      $_FILE_NAME     = '';
    protected   $signature      = 'api-make:model {name}';
    protected   $description    = 'Create model instance.';
    protected   $type           = 'Model';

    protected function getStub()
    {
        return __DIR__ . '/Stubs/Model.stub';
    }

    /**
     * The root location where file should be written to.
     *
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return "$rootNamespace\\Models";
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->_FILE_NAME = $this->getNameInput();

        // Check whether the name is allready reserved.
        if ($this->isReservedName($this->_FILE_NAME)) {
            $this->error('The name ' . $this->_FILE_NAME . ' is already reserved!');
            return false;
        }

        // Check whether the class name already exists.
        if ($this->alreadyExists($this->_FILE_NAME)) {
            $this->error('The class name ' . $this->_FILE_NAME . ' already exists!');
            return false;
        }

        // Parse and format the class name and path parameters.
        $name = $this->qualifyClass($this->_FILE_NAME);
        $path = $this->getPath($name);

        // Create the repository instance.
        $this->makeDirectory($path);
        $this->files->put(
            $path,
            $this->sortImports($this->buildClass($name))
        );

        $this->info($this->_FILE_NAME . ' created successfully!');
        return Command::SUCCESS;
    }

    /**
     * Build replaceable class names string.
     *
     * @return string
     */
    public function buildClass($name): string
    {
        $replace = [];

        return str_replace(
            array_keys($replace),
            array_values($replace),
            parent::buildClass($name)
        );
    }
}