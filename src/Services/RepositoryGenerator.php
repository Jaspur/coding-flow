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

        use App\Models\\{$model};
        use Illuminate\Database\Eloquent\Collection;

        class {$model}Repository
        {
            /**
             * @return Collection<int, {$model}>
             */
            public function all(): array
            {
                return {$model}::all();
            }

            /**
             * @param non-empty-string \$id
             * @return {$model}
             */
            public function find(string \$id): {$model}
            {
                return {$model}::findOrFail(\$id);
            }

            /**
             * @param array \$data
             * @return {$model}
             */
            public function create(array \$data): {$model}
            {
                return {$model}::create(\$data);
            }

            /**
             * @param non-empty-string \$id
             * @param array \$data
             * @return {$model}
             */
            public function update(string \$id, array \$data): {$model}
            {
                \$record = \$this->find(\$id);
                \$record->update(\$data);
                return \$record;
            }

            /**
             * @param non-empty-string \$id
             * @return bool|int
             */
            public function delete(string \$id): bool|int
            {
                return \$this->find(\$id)->delete();
            }
        }
        PHP;
    }
}
