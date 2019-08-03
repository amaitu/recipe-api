<?php

namespace App\Api\v1\Controllers\Recipes;

use App\Api\v1\Requests\GetRecipesRequest;
use App\Api\v1\Requests\PatchRecipesRequest;
use App\Http\Controllers\ApiController;
use App\Recipes\Models\Recipe;
use http\Env\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Response;

class RecipeController extends ApiController
{
    public function show(GetRecipesRequest $request)
    {
        if ($request->getRecipeId()) {
            return Response::json(['data' => Recipe::findOrFail($request->getRecipeId())]);
        }

        $data = Recipe::getRecipes($request->getPerPage(), $request->getCuisine());

        $result = [
            'data' => $data->items(),
            'metadata' => [
                'current_page' => $data->currentPage(),
                'per_page' => $data->perPage(),
                'total_pages' => $data->total(),
            ],
        ];

        return Response::json($result);
    }

    public function update(PatchRecipesRequest $request)
    {
        try {
            $result = Recipe::where('id', $request->getRecipeId())
                ->update($request->all());
        } catch (QueryException $exception) {
            return $this->error(500, 'Sorry, there was an error saving your recipe.');
        }

        if ($result) {
            return Response::json($request->all());
        }
    }

    private function error(int $httpStatusCode, string $message = 'Sorry, something went wrong.')
    {
        return Response::json($message, $httpStatusCode);
    }
}
