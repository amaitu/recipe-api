<?php

namespace Tests\Feature;

use App\Recipes\Commands\ImportRecipesFromCsv;
use App\Recipes\Models\Recipe;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ImportRecipesTest extends TestCase
{
    use RefreshDatabase;

    public function testItImportsRecipes()
    {
        $csvPath = base_path('tests/fixtures/recipes.csv');
        $this->artisan(ImportRecipesFromCsv::class, ['--path' => $csvPath]);

        $recipes = Recipe::all();

        $this->assertCount(10, $recipes);

        $this->assertDatabaseHas('recipes', [
            'id' => 1,
            'created_at' => '2015-06-30 17:58:00',
            'updated_at' => '2015-06-30 17:58:00',
            'box_type' => 'vegetarian',
            'marketing_description' => 'Here we\'ve used onglet steak which is an extra flavoursome cut of beef that should never be cooked past medium rare. So if you\'re a fan of well done steak, this one may not be for you. However, if you love rare steak and fancy trying a new cut, please be',
            'calories_kcal' => 401,
        ]);

        $recipes->each(function (Recipe $recipe) {
            $this->assertNotNull($recipe->box_type);
            $this->assertNotNull($recipe->title);
            $this->assertNotNull($recipe->season);
        });
    }
}
