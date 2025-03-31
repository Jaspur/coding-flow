<?php

declare(strict_types=1);

namespace Jaspur\CodingFlow\Console;

use Illuminate\Console\Command;
use Jaspur\CodingFlow\Services\ModelFinderService;
use Jaspur\CodingFlow\Services\ServiceLayerGenerator;

class GenerateServices extends Command
{
    protected $signature = 'codingflow:generate-services';

    protected $description = 'Genereert automatisch service layers voor alle modellen.';

    public function handle(): void
    {
        $models = (new ModelFinderService)->getModels();
        foreach ($models as $model) {
            if ((new ServiceLayerGenerator)->generate($model)) {
                $this->info("Service gegenereerd: {$model}Service.php");
            }
        }
    }
}
