<?php

declare(strict_types=1);

namespace Jaspur\CodingFlow\Console;

use Illuminate\Console\Command;
use Jaspur\CodingFlow\Services\ModelFinderService;
use Jaspur\CodingFlow\Services\ObserverGenerator;

class GenerateObservers extends Command
{
    protected $signature = 'codingflow:generate-observers';

    protected $description = 'Genereert observers voor alle modellen.';

    public function handle(): void
    {
        $models = (new ModelFinderService)->getModels();
        foreach ($models as $model) {
            if ((new ObserverGenerator)->generate($model)) {
                $this->info("Observer gegenereerd: {$model}Observer.php");
            }
        }
    }
}
