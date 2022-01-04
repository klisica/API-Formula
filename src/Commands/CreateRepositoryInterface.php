<?php

namespace KLisica\ApiFormula\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\GeneratorCommand;
use KLisica\ApiFormula\Helpers\BuildReplacements;

class CreateRepositoryInterface extends GeneratorCommand
{
    public      $_FILE_NAME     = '';
    public      $_MODEL_NAME    = '';
    protected   $signature      = 'api-make:repository-interface {name} {--model=}';
    protected   $description    = 'Create and publish Repository Interface instance.';
    protected   $type           = 'RepositoryInterface';

    protected function getStub()
    {
        return __DIR__ . '/Stubs/RepositoryInterface.stub';
    }

    /**
     * The root location where file should be written to.
     *
     * @return string
     */
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
        $this->_FILE_NAME = "Interfaces\\" . $this->getNameInput();
        $this->_MODEL_NAME = $this->option('model') ?? null;

        // Check whether the model parameter is provided.
        if (!$this->_MODEL_NAME) {
            $this->error('Model parameter is missing!');
            return false;
        }

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
        $replace = (new BuildReplacements)->repository($this->_MODEL_NAME);

        return str_replace(
            array_keys($replace),
            array_values($replace),
            parent::buildClass($name)
        );
    }
}
