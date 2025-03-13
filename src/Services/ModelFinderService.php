<?php

declare(strict_types=1);

namespace Jaspur\CodingFlow\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class ModelFinderService
{
    /**
     * Haalt alle Eloquent modellen op uit de `app/Models/` directory.
     *
     * @return array<int, string> Lijst met modelnamen (zonder namespace)
     */
    public function getModels(): array
    {
        $modelsPath = app_path('Models');

        if (! File::exists($modelsPath)) {
            return [];
        }

        return collect(File::files($modelsPath))
            ->map(fn ($file) => 'App\\Models\\'.pathinfo($file->getFilename(), PATHINFO_FILENAME))
            ->filter(fn ($class) => class_exists($class) && is_subclass_of($class, Model::class))
            ->map(fn ($class) => class_basename($class))
            ->values()
            ->all();
    }
}
