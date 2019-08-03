<?php

namespace Tests\Feature;

use App\Recipes\Commands\ImportRecipesFromCsv;
use App\Recipes\Models\Recipe;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RecipeControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testItGetsRecipesById()
    {
        $this->withoutExceptionHandling();

        $this->seedRecipes();

        $recipeId = random_int(1, 10);

        /** @var Recipe $recipe */
        $recipe = Recipe::find($recipeId);

        $response = $this->get("api/v1/recipes/{$recipeId}");
        $data = json_decode($response->getContent(), true)['data'];

        // assert that all the attributes return match those of the recipe in our database:
        $this->assertEquals($data, $recipe->getAttributes());
    }

    public function testItGetsRecipesByCuisine()
    {
        $this->seedRecipes();

        $response = $this->get('api/v1/recipes/?cuisine=asian');

        $data = json_decode($response->getContent(), true)['data'];

        // assert both Asian recipes are returned.
        $this->assertCount(2, $data);

        $expectedIds = [1, 6];

        foreach ($data as $recipe) {
            $this->assertTrue(in_array($recipe['id'], $expectedIds));
            $this->assertCount(3, $recipe);
            $this->assertNotNull($recipe['id']);
            $this->assertNotNull($recipe['title']);
            $this->assertNotNull($recipe['marketing_description']);
        }
    }

    public function testItUpdatesRecipes()
    {
        $this->withoutExceptionHandling();

        $this->seedRecipes();

        $data = [
            'marketing_description' => $this->faker->sentence,
            'recipe_cuisine' => $this->faker->word,
            'preparation_time_minutes' => random_int(10, 60),
            'bulletpoint1' => $this->faker->sentence,
        ];

        $response = $this->patch('api/v1/recipes/1', $data);

        $responseData = json_decode($response->getContent(), true);

        // assert that the response contains all the updated fields
        $this->assertEquals($data, $responseData);

        // assert that the updated fields have been persisted under the correct ID
        $this->assertDatabaseHas('recipes', array_merge($data, ['id' => 1]));
    }

    private function seedRecipes()
    {
        // todo - seed recipes using a factory.
        $csvPath = base_path('tests/fixtures/recipes.csv');
        $this->artisan(ImportRecipesFromCsv::class, ['--path' => $csvPath]);
    }
}
