<?php

namespace KLisica\ApiFormula\Helpers;

class FileManager
{
    /**
     * Import repository files in provider.
     *
     */
    public function importRepositoryFiles(string $repository, string $comment)
    {
        $file = base_path() . '/app/Providers/RepositoryServiceProvider.php';

        // Use statements.
        if ($comment == '// @API_FORMULA_USE_AUTOIMPORT') {
            $interface = $repository . 'Interface';

            $snippet
                = "use App\\Repositories\\Interfaces\\$interface;\n"
                . "use App\\Repositories\\$repository;\n"
                . "// @API_FORMULA_USE_AUTOIMPORT";
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
}