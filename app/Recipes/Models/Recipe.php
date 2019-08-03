<?php

namespace App\Recipes\Models;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $guarded = [];

    protected $table = 'recipes';

    public static function getRecipes(int $perPage = 10, ?string $cuisine = null): LengthAwarePaginator
    {
        return Recipe::query()
            ->when($cuisine, function ($query) use ($cuisine) {
                return $query->where('recipe_cuisine', $cuisine);
            })
            ->paginate($perPage, [
                'id',
                'title',
                'marketing_description'
            ]);
    }
}
