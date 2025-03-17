<?php

declare(strict_types=1);

namespace Jaspur\CodingFlow\Services;

use Illuminate\Support\Facades\File;

class APIResourceGenerator
{
    public function generate(string $model): void
    {
        $resourcePath = app_path("Http/Resources/{$model}Resource.php");

        File::ensureDirectoryExists(dirname($resourcePath));

        if (File::exists($resourcePath)) {
            return;
        }

        $stub = $this->getStub($model);
        File::put($resourcePath, $stub);
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
            public function toArray(Request \$request): array|Arrayable|JsonSerializable
            {
                return parent::toArray(\$request);
            }
        }
        PHP;
    }
}
