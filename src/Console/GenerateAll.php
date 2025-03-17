<?php

declare(strict_types=1);

namespace Jaspur\CodingFlow\Console;

use Blueprint\Contracts\Generator;
use Illuminate\Support\Facades\Artisan;

class GenerateAll implements Generator
{
    public function output(array $tree): array
    {
        $commands = [
            'codingflow:generate-repositories',
            'codingflow:generate-services',
            'codingflow:generate-dtos',
            'codingflow:generate-api-resources',
            'codingflow:generate-feature-tests',
            'codingflow:generate-observers',
            'codingflow:generate-structure',
        ];

        foreach ($commands as $command) {
            Artisan::call($command);
        }

        return [];
    }
}
