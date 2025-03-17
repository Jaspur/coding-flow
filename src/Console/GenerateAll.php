<?php

declare(strict_types=1);

namespace Jaspur\CodingFlow\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class GenerateAll extends Command
{
    protected $signature = 'codingflow:generate-all';

    protected $description = 'Genereert alles volledig.';

    public function handle(): void
    {
        foreach ([
            'codingflow:generate-repositories',
            'codingflow:generate-services',
            'codingflow:generate-dtos',
            'codingflow:generate-api-resources',
            'codingflow:generate-feature-tests',
            'codingflow:generate-observers',
            'codingflow:generate-structure',
        ] as $command) {
            Artisan::call($command);
        }
    }
}
