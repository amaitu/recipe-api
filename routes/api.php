<?php

use App\Api\v1\Controllers\Recipes\RecipeController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('/recipes/{recipeId}', [RecipeController::class, 'show']);
    Route::get('/recipes/', [RecipeController::class, 'show']);
    Route::patch('/recipes/{recipeId}', [RecipeController::class, 'update']);
});
