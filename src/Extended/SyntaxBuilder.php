<?php

namespace KLisica\ApiFormula\Extended;

use Laracasts\Generators\GeneratorException;

class SyntaxBuilder
{
    /**
     * A template to be inserted.
     *
     * @var string
     */
    private $template;

    /**
     * Create the PHP syntax for the given schema.
     *
     * @param  array $schema
     * @param  array $meta
     * @return string
     * @throws GeneratorException
     */
    public function create($schema, $meta)
    {
        $up = $this->createSchemaForUpMethod($schema, $meta);
        $down = $this->createSchemaForDownMethod($schema, $meta);

        return compact('up', 'down');
    }

    /**
     * Create the schema for the "up" method.
     *
     * @param  string $schema
     * @param  array $meta
     * @return string
     * @throws GeneratorException
     */
    private function createSchemaForUpMethod($schema, $meta)
    {
        $fields = $this->constructSchema($schema);
        return $this->insert($fields)->into($this->getCreateSchemaWrapper());
    }

    /**
     * Construct the syntax for a down field.
     *
     * @param  array $schema
     * @param  array $meta
     * @return string
     * @throws GeneratorException
     */
    private function createSchemaForDownMethod($schema, $meta)
    {
        return sprintf("Schema::dropIfExists('%s');", $meta['table']);
    }

    /**
     * Store the given template, to be inserted somewhere.
     *
     * @param  string $template
     * @return $this
     */
    private function insert($template)
    {
        $this->template = $template;

        return $this;
    }

    /**
     * Get the stored template, and insert into the given wrapper.
     *
     * @param  string $wrapper
     * @param  string $placeholder
     * @return mixed
     */
    private function into($wrapper, $placeholder = 'schema_up')
    {
        return str_replace('{{' . $placeholder . '}}', $this->template, $wrapper);
    }

    /**
     * Get the wrapper template for a "create" action.
     *
     * @return string
     */
    private function getCreateSchemaWrapper()
    {
        return file_get_contents(dirname(__DIR__, 1) . '/Commands/Stubs/MigrationSchema.stub');
    }

    /**
     * Construct the schema fields.
     *
     * @param  array $schema
     * @param  string $direction
     * @return array
     */
    private function constructSchema($schema, $direction = 'Add')
    {
        if (!$schema) return '';

        $fields = array_map(function ($field) use ($direction) {
            $method = "{$direction}Column";

            return $this->$method($field);
        }, $schema);

        return implode("\n" . str_repeat(' ', 12), $fields);
    }
}
