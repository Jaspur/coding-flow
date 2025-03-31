<?php

declare(strict_types=1);

namespace Jaspur\CodingFlow\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class FeatureTestGenerator
{
    public function generate(string $model): bool|int
    {
        $testPath = base_path("tests/Feature/{$model}Test.php");

        File::ensureDirectoryExists(dirname($testPath));

        if (File::exists($testPath)) {
            return false;
        }

        $stub = $this->getStub($model);

        return File::put($testPath, $stub);
    }

    private function getStub(string $model): string
    {
        $_model = Str::lower($model);

        return <<<PHP
        <?php

        use App\Models\\{$model};
        use function Pest\Laravel\getJson;
        use function Pest\Laravel\postJson;

        test('POST /api/{$_model}s creates a new {$model}', function () {
            \$response = postJson('/api/{$_model}s', [
                'title' => 'Test Title',
                'content' => 'Test content',
            ]);

            \$response->assertStatus(201)
                ->assertJsonStructure([
                    'id', 'title', 'content', 'created_at',
                ]);
        });

        test('GET /api/{$_model}s/{id} returns {$model} data', function () {
            \$record = {$_model}::factory()->create();

            \$response = getJson("/api/{$_model}s/{\$record->id}");

            \$response->assertStatus(200)
                ->assertJson([
                    'id' => \$record->id,
                    'title' => \$record->title,
                ]);
        });
        PHP;
    }
}
