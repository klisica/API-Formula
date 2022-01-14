<?php

namespace KLisica\ApiFormula\Helpers;
use Illuminate\Support\Str;

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
            '{{ model }}' => $model_name,
            '{{ model_var }}' => Str::snake($model_name)
        ];
    }
}