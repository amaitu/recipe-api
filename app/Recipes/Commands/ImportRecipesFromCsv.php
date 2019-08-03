<?php

namespace App\Recipes\Commands;

use App\Recipes\Models\Recipe;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;

class ImportRecipesFromCsv extends Command
{
    protected $signature = 'recipes:import
                              {--path=: CSV path}';

    protected $description = 'Import recipes using a CSV.';

    public function handle()
    {
        $csv = array_map('str_getcsv', file($this->option('path')));
        $headers = array_shift($csv);

        $recipes = collect($csv)->map(function ($row) use ($headers) {
            array_fill_keys(
                array_keys($row, 'NULL'),
                null
            );

            $recipe = $headers ? array_combine($headers, $row) : $row;

            // allows for dates in the CSV to be a non-standard format.
            $format = 'd/m/Y H:i:s';
            $recipe['created_at'] = Carbon::createFromFormat($format, Arr::get($recipe, 'created_at'));
            $recipe['updated_at'] = Carbon::createFromFormat($format, Arr::get($recipe, 'updated_at'));

            Recipe::create($recipe);
            return $recipe;
        });

        $this->info("{$recipes->count()} recipes imported.");
    }
}
