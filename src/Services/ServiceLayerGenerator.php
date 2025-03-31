<?php

declare(strict_types=1);

namespace Jaspur\CodingFlow\Services;

use Illuminate\Support\Facades\File;

class ServiceLayerGenerator
{
    public function generate(string $model): void
    {
        $servicePath = app_path("Services/{$model}Service.php");

        if (! config('codingflow.generators.services', true)) {
            return;
        }

        if (File::exists($servicePath) && ! config('codingflow.overwrite_existing_files', false)) {
            return;
        }

        File::ensureDirectoryExists(dirname($servicePath));
        File::put($servicePath, $this->getStub($model));
    }

    private function getStub(string $model): string
    {
        return <<<PHP
        <?php

        declare(strict_types=1);

        namespace App\Services;

        use App\Repositories\\{$model}Repository;
        use App\Models\\{$model};
        use Illuminate\Database\Eloquent\Collection;

        class {$model}Service
        {
            public function __construct(
                private readonly {$model}Repository \$repository
            ) {}

            /**
             * Get all {$model} records.
             *
             * @return Collection<array-key, {$model}>
             */
            public function getAll(): Collection
            {
                return \$this->repository->all();
            }

            /**
             * Return the given model directly (already resolved).
             *
             * @param {$model} \$model
             * @return {$model}
             */
            public function getById({$model} \$model): {$model}
            {
                return \$model;
            }

            /**
             * Create a new {$model} record.
             *
             * @param array \$data
             * @return {$model}
             */
            public function create(array \$data): {$model}
            {
                return \$this->repository->create(\$data);
            }

            /**
             * Update the given {$model} with new data.
             *
             * @param {$model} \$model
             * @param array \$data
             * @return {$model}
             */
            public function update({$model} \$model, array \$data): {$model}
            {
                return \$this->repository->update(\$model, \$data);
            }

            /**
             * Delete the given {$model} record.
             *
             * @param {$model} \$model
             * @return bool|int|null
             */
            public function delete({$model} \$model): bool|int|null
            {
                return \$this->repository->delete(\$model);
            }
        }
        PHP;
    }
}
