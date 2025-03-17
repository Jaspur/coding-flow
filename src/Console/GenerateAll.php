<?php

declare(strict_types=1);

namespace Jaspur\CodingFlow\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class GenerateAll extends Command
{
    protected $signature = 'codingflow:generate-all';

    protected $description = 'Voert alle CodingFlow generatie commands uit op basis van de configuratie.';

    public function handle(): void
    {
        $commands = [
            'repositories' => 'codingflow:generate-repositories',
            'services' => 'codingflow:generate-services',
            'dtos' => 'codingflow:generate-dtos',
            'api_resources' => 'codingflow:generate-api-resources',
            'feature_tests' => 'codingflow:generate-feature-tests',
            'observers' => 'codingflow:generate-observers',
            'controllers' => 'codingflow:generate-controllers',
        ];

        foreach ($commands as $key => $command) {
            if (config("codingflow.generators.$key", false)) {
                $this->info("🚀 Uitvoeren: $command");
                Artisan::call($command);
                $this->line(Artisan::output());
            } else {
                $this->warn("⏩ $command overgeslagen (uitgeschakeld in configuratie)");
            }
        }

        $this->info('✅ Alle actieve CodingFlow commands succesvol uitgevoerd!');
    }
}
