<?php

declare(strict_types=1);

namespace Jaspur\CodingFlow\Services;

use Illuminate\Support\Facades\File;

class ServiceLayerGenerator
{
    public function generate(string $model): void
    {
        $servicePath = app_path("Services/{$model}Service.php");

        File::ensureDirectoryExists(dirname($servicePath));

        if (File::exists($servicePath)) {
            return;
        }

        $stub = $this->getStub($model);
        File::put($servicePath, $stub);
    }

    private function getStub(string $model): string
    {
        return <<<PHP
        <?php

        namespace App\Services;

        use App\Repositories\\{$model}Repository;

        class {$model}Service
        {
            public function __construct(
                private {$model}Repository \$repository
            ) {}

            public function getAll()
            {
                return \$this->repository->all();
            }

            public function getById(string \$id)
            {
                return \$this->repository->find(\$id);
            }

            public function create(array \$data)
            {
                return \$this->repository->create(\$data);
            }

            public function update(string \$id, array \$data)
            {
                return \$this->repository->update(\$id, \$data);
            }

            public function delete(string \$id)
            {
                return \$this->repository->delete(\$id);
            }
        }
        PHP;
    }
}
