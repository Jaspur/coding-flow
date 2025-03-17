<?php

declare(strict_types=1);

namespace Jaspur\CodingFlow\Services;

use Illuminate\Support\Facades\File;

class ObserverGenerator
{
    public function generate(string $model): void
    {
        $observerPath = app_path("Observers/{$model}Observer.php");

        File::ensureDirectoryExists(dirname($observerPath));

        if (File::exists($observerPath)) {
            return;
        }

        $stub = $this->getStub($model);
        File::put($observerPath, $stub);
    }

    private function getStub(string $model): string
    {
        return <<<PHP
        <?php

        namespace App\Observers;

        use App\Models\\{$model};

        class {$model}Observer
        {
            public function created({$model} \$model): void
            {
                // Logic for when a {$model} is created
            }

            public function updated({$model} \$model): void
            {
                // Logic for when a {$model} is updated
            }

            public function deleted({$model} \$model): void
            {
                // Logic for when a {$model} is deleted
            }
        }
        PHP;
    }
}
