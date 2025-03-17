<?php

declare(strict_types=1);

namespace Jaspur\CodingFlow\Services;

use Illuminate\Support\Facades\File;

class DTOGenerator
{
    /**
     * Genereer een DTO voor een model.
     *
     * @param  array<string, string>  $attributes
     */
    public function generate(string $model, array $attributes): void
    {
        $dtoPath = app_path("DTOs/{$model}DTO.php");

        if (File::exists($dtoPath)) {
            return;
        }

        $stub = $this->getStub($model, $attributes);
        File::put($dtoPath, $stub);
    }

    /**
     * Verkrijg de stub voor een model.
     *
     * @param  array<string, string>  $attributes
     */
    private function getStub(string $model, array $attributes): string
    {
        $properties = array_map(fn ($type, $name): string => "    public readonly {$type} \${$name};", $attributes, array_keys($attributes));
        $propertiesCode = implode("\n", $properties);

        return <<<PHP
        <?php

        namespace App\DTOs;

        final readonly class {$model}DTO
        {
            public function __construct(
                {$propertiesCode}
            ) {}
        }
        PHP;
    }
}
