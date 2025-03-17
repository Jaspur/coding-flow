<?php

declare(strict_types=1);

namespace Jaspur\CodingFlow\Services;

use Illuminate\Support\Facades\File;

class RepositoryGenerator
{
    public function generate(string $model): void
    {
        $repositoryPath = app_path("Repositories/{$model}Repository.php");

        File::ensureDirectoryExists(dirname($repositoryPath));

        if (File::exists($repositoryPath)) {
            return;
        }

        $stub = $this->getStub($model);
        File::put($repositoryPath, $stub);
    }

    private function getStub(string $model): string
    {
        return <<<PHP
        <?php

        namespace App\Repositories;

        use App\Models\\{$model};

        class {$model}Repository
        {
            public function all()
            {
                return {$model}::all();
            }

            public function find(int \$id): ?{$model}
            {
                return {$model}::findOrFail(\$id);
            }

            public function create(array \$data): {$model}
            {
                return {$model}::create(\$data);
            }

            public function update(int \$id, array \$data): bool
            {
                \$record = \$this->find(\$id);
                return \$record->update(\$data);
            }

            public function delete(int \$id): bool
            {
                \$record = \$this->find(\$id);
                return \$record->delete();
            }
        }
        PHP;
    }
}
