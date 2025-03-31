<?php

declare(strict_types=1);

namespace Jaspur\CodingFlow\Services;

use Illuminate\Support\Facades\File;

class RepositoryGenerator
{
    public function generate(string $model): void
    {
        $repositoryPath = app_path("Repositories/{$model}Repository.php");

        if (! config('codingflow.generators.repositories', true)) {
            return;
        }

        if (File::exists($repositoryPath) && ! config('codingflow.overwrite_existing_files', false)) {
            return;
        }

        File::ensureDirectoryExists(dirname($repositoryPath));
        File::put($repositoryPath, $this->getStub($model));
    }

    private function getStub(string $model): string
    {
        return <<<PHP
        <?php

        declare(strict_types=1);

        namespace App\Repositories;

        use App\Models\{$model};
        use Illuminate\Database\Eloquent\Collection;

        class {$model}Repository
        {
            /**
             * Retrieve all {$model} records.
             *
             * @return Collection<array-key, {$model}>
             */
            public function all(): Collection
            {
                return {$model}::all();
            }

            /**
             * Create a new {$model} record.
             *
             * @param array \$data
             * @return {$model}
             */
            public function create(array \$data): {$model}
            {
                return {$model}::create(\$data);
            }

            /**
             * Update the given {$model} record.
             *
             * @param {$model} \$model
             * @param array \$data
             * @return {$model}
             */
            public function update({$model} \$model, array \$data): {$model}
            {
                \$model->update(\$data);
                return \$model;
            }

            /**
             * Delete the given {$model} record.
             *
             * @param {$model} \$model
             * @return bool|int|null
             */
            public function delete({$model} \$model): bool|int|null
            {
                return \$model->delete();
            }
        }
        PHP;
    }
}
