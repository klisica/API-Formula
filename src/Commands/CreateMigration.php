<?php

namespace KLisica\ApiFormula\Commands;

use KLisica\ApiFormula\Extended\SyntaxBuilder;
use Laracasts\Generators\Commands\MigrationMakeCommand;
use Laracasts\Generators\Migrations\SchemaParser;

class CreateMigration extends MigrationMakeCommand
{
    protected $name = 'api-make:migration';
    protected $description  = 'Create migration file.';

    /**
     * Replace the schema for the stub.
     *
     * @param  string $stub
     * @return $this
     */
    protected function replaceSchema(&$stub)
    {
        if ($schema = $this->option('schema')) {
            $schema = (new SchemaParser)->parse($schema);
        }

        $schema = (new SyntaxBuilder)->create($schema, $this->meta);

        $stub = str_replace(['{{schema_up}}', '{{schema_down}}'], $schema, $stub);

        return $this;
    }

    /**
     * Compile the migration stub.
     *
     * @return string
     */
    protected function compileMigrationStub()
    {
        $stub = $this->files->get(__DIR__ . '/Stubs/Migration.stub');

        $this->replaceClassName($stub)
            ->replaceSchema($stub)
            ->replaceTableName($stub);

        return $stub;
    }
}
