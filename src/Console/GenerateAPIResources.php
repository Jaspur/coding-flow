<?php

declare(strict_types=1);

namespace Jaspur\CodingFlow\Console;

use Illuminate\Console\Command;
use Jaspur\CodingFlow\Services\APIResourceGenerator;
use Jaspur\CodingFlow\Services\ModelFinderService;

class GenerateAPIResources extends Command
{
    protected $signature = 'codingflow:generate-api-resources';

    protected $description = 'Genereert API resources voor alle modellen.';

    public function handle(): void
    {
        $models = (new ModelFinderService)->getModels();

        foreach ($models as $model) {
            (new APIResourceGenerator)->generate($model);
            $this->info("API Resource gegenereerd: {$model}Resource.php");
        }
    }
}
