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
             * @return Collection<array-key, {$model}>
             */
            public function getAll(): Collection
            {
                return \$this->repository->all();
            }

            /**
             * @param non-empty-string \$id
             * @return {$model}
             */
            public function getById(string \$id): {$model}
            {
                return \$this->repository->find(\$id);
            }

            /**
             * @param array \$data
             * @return {$model}
             */
            public function create(array \$data): {$model}
            {
                return \$this->repository->create(\$data);
            }

            /**
             * @param non-empty-string \$id
             * @param array \$data
             * @return {$model}
             */
            public function update(string \$id, array \$data): {$model}
            {
                return \$this->repository->update(\$id, \$data);
            }

            /**
             * @param non-empty-string \$id
             * @return bool|int|null
             */
            public function delete(string \$id): bool|int|null
            {
                return \$this->repository->delete(\$id);
            }
        }
        PHP;
    }
}
