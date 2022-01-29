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
            '{{ repository_path }}' => $this->getFilePathString('repositories', $model_name),
            '{{ resource_path }}' => $this->getFilePathString('resources', $model_name),
            '{{ service_path }}' => $this->getFilePathString('services', $model_name),
            '{{ create_request_path }}' => $this->getFilePathString('requests', $model_name, 'Create' . $model_name),
            '{{ update_request_path }}' => $this->getFilePathString('requests', $model_name, 'Update' . $model_name),
            '{{ namespacedModel }}' => "App\\Models\\$model_name",
            '{{ model }}' => $model_name,
            '{{ model_var }}' => Str::snake($model_name),
            '{{ model_lc }}' => lcfirst($model_name)
        ];
    }

    /**
     * Set up file path string.
     *
     * @param   string $instance
     * @param   string $model_name
     * @param   string $fixed_model_name
     * @return  string $path
     */
    public function getFilePathString(string $instance, string $model_name, ?string $fixed_model_name = null): string
    {
        // Return service path.
        if ($instance == 'repositories') {
            return $this->versioningEnabled($instance)
                ? 'App\\Http\\Resources\\' . config('api._version') . '\\' . $model_name . 'Resource'
                : 'App\\Http\\Resources\\' . $model_name . 'Resource';
        }

        // Return service path.
        if ($instance == 'services') {
            return $this->versioningEnabled($instance)
                ? 'App\\Http\\Services\\' . config('api._version') . '\\' . $model_name . 'Service'
                : 'App\\Http\\Services\\' . $model_name . 'Service';
        }

        // Return request path.
        if ($instance == 'requests') {
            return $this->versioningEnabled($instance)
                ? 'App\\Http\\Requests\\' . config('api._version') . "\\$model_name\\$fixed_model_name"
                : "App\\Http\\Requests\\$model_name\\$fixed_model_name";
        }

        // By default returning repository interface path.
        return $this->versioningEnabled($instance)
            ? 'App\\Repositories\\' . config('api._version') . '\\Interfaces\\' . $model_name . 'RepositoryInterface'
            : 'App\\Repositories\\Interfaces\\' . $model_name . 'RepositoryInterface';
    }

    /**
     * Check if versioning is enabled for specific instance.
     *
     * @param   string $instance
     * @return  bool
     */
    public function versioningEnabled(string $instance): bool
    {
        return (bool) config('api._version') &&
            !in_array($instance, config('api-formula.versioning_disabled_for'));
    }
}
