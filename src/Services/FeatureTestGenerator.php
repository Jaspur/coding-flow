<?php

declare(strict_types=1);

namespace Jaspur\CodingFlow\Services;

use Illuminate\Support\Facades\File;

class FeatureTestGenerator
{
    public function generate(string $model): void
    {
        $testPath = base_path("tests/Feature/{$model}Test.php");

        File::ensureDirectoryExists(dirname($testPath));

        if (File::exists($testPath)) {
            return;
        }

        $stub = $this->getStub($model);
        File::put($testPath, $stub);
    }

    private function getStub(string $model): string
    {
        return <<<PHP
        <?php

        use App\Models\\{$model};
        use function Pest\Laravel\getJson;
        use function Pest\Laravel\postJson;

        test('POST /api/{$model}s creates a new {$model}', function () {
            \$response = postJson('/api/{$model}s', [
                'title' => 'Test Title',
                'content' => 'Test content',
            ]);

            \$response->assertStatus(201)
                ->assertJsonStructure([
                    'id', 'title', 'content', 'created_at',
                ]);
        });

        test('GET /api/{$model}s/{id} returns {$model} data', function () {
            \$record = {$model}::factory()->create();

            \$response = getJson("/api/{$model}s/{\$record->id}");

            \$response->assertStatus(200)
                ->assertJson([
                    'id' => \$record->id,
                    'title' => \$record->title,
                ]);
        });
        PHP;
    }
}
