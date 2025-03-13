<?php

declare(strict_types=1);

namespace Jaspur\CodingFlow\Console;

use Illuminate\Console\Command;
use Jaspur\CodingFlow\Services\FeatureTestGenerator;
use Jaspur\CodingFlow\Services\ModelFinderService;

class GenerateFeatureTests extends Command
{
    protected $signature = 'codingflow:generate-feature-tests';

    protected $description = 'Genereert feature tests voor alle API endpoints.';

    public function handle(): void
    {
        $models = (new ModelFinderService)->getModels();
        foreach ($models as $model) {
            (new FeatureTestGenerator)->generate($model);
            $this->info("Feature Test gegenereerd: {$model}Test.php");
        }
    }
}
