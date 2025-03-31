<?php

declare(strict_types=1);

namespace Jaspur\CodingFlow\Services;

use Illuminate\Support\Facades\File;

class APIResourceGenerator
{
    public function generate(string $model): bool|int
    {
        $resourcePath = app_path("Http/Resources/{$model}Resource.php");

        File::ensureDirectoryExists(dirname($resourcePath));

        if (File::exists($resourcePath)) {
            return false;
        }

        $stub = $this->getStub($model);

        return File::put($resourcePath, $stub);
    }

    private function getStub(string $model): string
    {
        return <<<PHP
        <?php

        namespace App\Http\Resources;

        use Illuminate\Http\Request;
        use Illuminate\Http\Resources\Json\JsonResource;
        use Illuminate\Contracts\Support\Arrayable;
        use JsonSerializable;

        class {$model}Resource extends JsonResource
        {
            public function toArray(Request \$request): array
            {
                return [
                    'id' => \$this->id,
                    'todo' => '{$model}Resource'
                ];
            }
        }
        PHP;
    }
}
