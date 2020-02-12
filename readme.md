# Recipe API
A simple API that stores and returns recipe data in JSON

## How to set up

Download the repo.
 - Run `composer install` inside the repo directory.
 - Run `cp .env.example .env` to set up the correct environment variables.
 - Create the SQLite DB. `touch database/database.sqlite`
 - In your `.env` file, set the `DB_DATABASE` value to be a full path to the SQLite database you just created. The database can be found in `/database/database.sqlite`. For example: `/Users/steve/projects/recipes/database/database.sqlite`
 - Run `php artisan migrate:fresh` to initialise the DB.
 
 ## To import recipes
 - Run `php artisan recipes:import --path={your path to csv}` to import a CSV of recipes. You can find a sample csv in the `/tests/Fixtures` directory.
 
## To run tests

`vendor/bin/phpunit`

## To make requests
 - Run `php artisan serve` to run a local server.
 
 ### Endpoints
  Fetch recipe by ID:
 GET `api/v1/recipes/1`
  
  Fetch recipe by cuisine:
 GET `api/v1/recipes/?cuisine=asian`
 
 Update a recipe
  PATCH `api/v1/recipes/1`
 Include in the body of the request the attributes to update. Ensure the content type is 'application/json'.
 ```
{
   "marketing_description":"something",
   "title":"some title"
}
```

## TODOs

 - Create factories for test recipe data, as currently the database is seeded via CSV. All tests are therefore dependent on this logic.
 - Create a common resource/presenter class to define which fields should be returned by the API, rather than doing this in the controller each time. 
 - Improve API responses when resources are not found or invalid data is sent in the request.
 - Validate patch requests.
 - API authentication.
 - Containerise 
