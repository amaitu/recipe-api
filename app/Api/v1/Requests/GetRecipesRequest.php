<?php


namespace App\Api\v1\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetRecipesRequest extends FormRequest
{
    public function wantsJson(): bool
    {
        return true;
    }

    public function getRecipeId(): ?int
    {
        return $this->route('recipeId');
    }

    public function getCuisine(): ?string
    {
        return $this->input('cuisine');
    }

    /**
     * Returns the number of pages the user requested, if valid, otherwise 10.
     *
     * @return int
     */
    public function getPerPage(): int
    {
        $maxPages = 10;

        $perPage = $this->input('per_page', $maxPages);

        if (($perPage < 0) || ($perPage > $maxPages)) {
            return $maxPages;
        }

        return $perPage;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'cuisine' => 'string'
        ];
    }
}
