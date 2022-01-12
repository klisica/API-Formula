<?php

namespace KLisica\ApiFormula\Helpers;

class BuildReplacements
{
    /**
     * Stub build replacements for Repository file.
     *
     * @return array
     */
    public function repository(string $model_name)
    {
        return [
            '{{ namespacedModel }}' => "App\\Models\\$model_name",
            '{{ model }}' => $model_name
        ];
    }
}