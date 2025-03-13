<?php

declare(strict_types=1);

namespace Jaspur\CodingFlow\Console;

use Illuminate\Console\Command;
use Jaspur\CodingFlow\Services\DTOGenerator;
use Jaspur\CodingFlow\Services\ModelFinderService;

class GenerateDTOs extends Command
{
    protected $signature = 'codingflow:generate-dtos';

    protected $description = 'Genereert DTO’s voor alle modellen.';

    public function handle(): void
    {
        $models = (new ModelFinderService)->getModels();

        foreach ($models as $model) {
            $attributes = [
                'id' => 'int',
                'title' => 'string',
                'content' => 'string',
            ];

            (new DTOGenerator)->generate($model, $attributes);
            $this->info("DTO gegenereerd: {$model}DTO.php");
        }
    }
}
