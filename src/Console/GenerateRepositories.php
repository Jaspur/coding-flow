<?php

declare(strict_types=1);

namespace Jaspur\CodingFlow\Console;

use Illuminate\Console\Command;
use Jaspur\CodingFlow\Services\ModelFinderService;
use Jaspur\CodingFlow\Services\RepositoryGenerator;

class GenerateRepositories extends Command
{
    protected $signature = 'codingflow:generate-repositories';

    protected $description = 'Genereert automatisch repositories voor alle modellen.';

    public function handle(): void
    {
        $models = (new ModelFinderService)->getModels();

        foreach ($models as $model) {
            (new RepositoryGenerator)->generate($model);
            $this->info("Repository gegenereerd: {$model}Repository.php");
        }
    }
}
