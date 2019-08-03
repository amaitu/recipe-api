<?php


namespace App\Api\v1\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatchRecipesRequest extends FormRequest
{
    public function wantsJson(): bool
    {
        return true;
    }

    public function getRecipeId(): ?int
    {
        return $this->route('recipeId');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // todo - valdiate that each item is a valid recipe attribute
        return [];
    }
}
