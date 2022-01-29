<?php

namespace KLisica\ApiFormula\Helpers;

use Illuminate\Support\Str;

class FileManager
{
    /**
     * Import repository files in provider.
     *
     * @param string $repository
     * @param string $comment
     * @param string $comment
     * @return void
     */
    public function importRepositoryFiles(string $repository, string $comment): void
    {
        $file = base_path() . '/app/Providers/RepositoryServiceProvider.php';
        $api_version = config('api._version');

        // Use statements.
        if ($comment == '// @API_FORMULA_USE_AUTOIMPORT') {
            $interface = $repository . 'Interface';

            if ($api_version) {
                // Set versioned snippet.
                $snippet
                = "use App\\Repositories\\$api_version\\Interfaces\\$interface;\n"
                . "use App\\Repositories\\$api_version\\$repository;\n"
                . "// @API_FORMULA_USE_AUTOIMPORT";
            } else {
                // Set regular snippet.
                $snippet
                    = "use App\\Repositories\\Interfaces\\$interface;\n"
                    . "use App\\Repositories\\$repository;\n"
                    . "// @API_FORMULA_USE_AUTOIMPORT";
            }
        }

        // Bind function.
        if ($comment == '// @API_FORMULA_BIND_AUTOIMPORT') {
            $snippet
                = '$this->app->bind(' . $repository . 'Interface::class, ' . $repository . '::class);'
                . "\n\x20\x20\x20\x20\x20\x20\x20\x20// @API_FORMULA_BIND_AUTOIMPORT";
        }

        // Insert data.
        file_put_contents(
            $file,
            str_replace(
                $comment,
                $snippet,
                file_get_contents($file)
            )
        );
    }

    /**
     * Import resource route in api file.
     *
     * @param string $controller
     * @param string $model
     */
    public function importApiRoute(string $controller, string $model)
    {
        $comment = '// @API_FORMULA_AUTOIMPORT';
        $fileName = config('api-formula.api_file_path') ?? '/routes/api.php';
        $file = base_path() . $fileName;

        // Import function.
        $snippet
            = "Route::resource('" . Str::snake(Str::plural($model)) . "', '" . $controller . "')->parameters(['' => '" . Str::snake($model) ."']);"
            . "\n\x20\x20\x20\x20$comment";

        // Insert data.
        file_put_contents(
            $file,
            str_replace(
                $comment,
                $snippet,
                file_get_contents($file)
            )
        );
    }
}