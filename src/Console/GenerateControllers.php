<?php

declare(strict_types=1);

namespace Jaspur\CodingFlow\Console;

use Illuminate\Console\Command;
use Jaspur\CodingFlow\Services\ControllerGenerator;
use Jaspur\CodingFlow\Services\ModelFinderService;

class GenerateControllers extends Command
{
    protected $signature = 'codingflow:generate-controllers';

    protected $description = 'Genereert automatisch API Resource Controllers voor alle modellen.';

    public function handle(): void
    {
        $models = (new ModelFinderService)->getModels();

        foreach ($models as $model) {
            if ((new ControllerGenerator)->generate($model)) {
                $this->info("✅ Controller gegenereerd: {$model}Controller.php");
            }
        }
    }
}
