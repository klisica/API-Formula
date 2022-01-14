<?php

namespace KLisica\ApiFormula\Helpers;
use Illuminate\Support\Str;

class BuildReplacements
{
    /**
     * Stub build replacements.
     *
     * @param   string $model_name
     * @return  array
     */
    public function replaceStrings(string $model_name): array
    {
        return [
            '{{ namespacedModel }}' => "App\\Models\\$model_name",
            '{{ model }}' => $model_name,
            '{{ model_var }}' => Str::snake($model_name),
            '{{ model_lc }}' => lcfirst($model_name)
        ];
    }
}
