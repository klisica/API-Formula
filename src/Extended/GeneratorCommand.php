<?php

namespace KLisica\ApiFormula\Extended;

use Illuminate\Console\GeneratorCommand as OriginalGeneratorCommand;
use KLisica\ApiFormula\Helpers\BuildReplacements;

class GeneratorCommand extends OriginalGeneratorCommand
{
    public $_FILE_NAME  = '';
    public $_MODEL_NAME = '';

    // Required as initial.
    protected function getStub()
    {
        return __DIR__;
    }

    public function _startFileBuilder(): bool
    {
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

        // Create the instance.
        $this->makeDirectory($path);

        $this->files->put(
            $path,
            $this->sortImports($this->buildClass($name))
        );

        // Success.
        $this->info($this->_FILE_NAME . ' created successfully!');
        return  true;
    }

    /**
     * Build replaceable class names string.
     *
     * @return string
     */
    public function buildClass($name): string
    {
        // By default we aren't passing any additional params.
        $replace = [];

        if (
            $this->type == 'Repository' ||
            $this->type == 'RepositoryInterface'||
            $this->type == 'Controller'
        ) {
            $replace = (new BuildReplacements)->replaceStrings($this->_MODEL_NAME);
        }

        return str_replace(
            array_keys($replace),
            array_values($replace),
            parent::buildClass($name)
        );
    }
}