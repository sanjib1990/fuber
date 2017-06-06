## Requirement

> PHP 7

> Mysql >= 5.6

> Composer

## Steps

> Clone the code base

> run `composer install` in terminal

> copy `env.example` as `.env` and change the database configuration

> run `php artisan migrate --seed`

## Folder Structure
- `app/Contracts` Contains all the interfaces used in various classes
- `app/Exceptions` Contains the custom exception classes
- `app/Http/Controllers` Contains the Controllers
- `app/Http/Middeware` Contains the middleware for the HTTP request
- `app/Http/Requests` Contains the Request validation classes
- `app/Models` Contains all the Models
- `app/Providers/AppServiceProvider.php` has the code for bootstraping various classes and objects, 
binding between interface and models.
- `app/Transformers` contains all the transformers used to transform data before sending response.
- `app/Utils` contains additional classes used to support the app.
- `config/location.php` has the dummy locations
- `resources/lang/en/api.php` has the code for translation..
- `routes/api.php` has the code for api routing
- `tests` has the classes for unit test and functional test

## Postman Collection Link
    https://www.getpostman.com/collections/3537e70283e07a84464c

## API

All apis are prefixed with `/api/v1`

All Api should have the following request headers

    Content-Type : application/json
    Accept: application/json

- GET `/customers`:
    
    List the cutomers

- GET `/customers/{customer id}`:
    
    Get a specific customer details

- GET `/cabs`:
    
    Get list of cabs. Optional parameter
        
        includes: This param is used for lazy loading. The possible values for this API are 
            
            - type : refers to the type of cab
        
        available: This params is used to filter cabs which are current available. Value is only 'true'
        
- GET `/cabs/{cab id}`:

    Get Details of a specific cab. Optional parameter
    
        includes: This param is used for lazy loading. The possible values for this API are 
            
            - type : refers to the type of cab
         
- GET `/cabs/nearby`:

    Get nearby available cabs. Params:
        
        includes: Optional. This param is used for lazy loading. The possible values for this API are 
        
            - type : refers to the type of cab
        
        lat: required. Lattitude of the customer.
        lng: required. Longitude of the customer.
        radius: optional.Radius in which the cabs needs to be searched.
        cab_type_id: optional. Type of cab. can be checked in cab type API
        
- GET `/cabs/transits`:

    Get list of transits.
        
        includes: Optional. comma separated values (without any space in between). This param is used for lazy loading. The possible values for this API are 
        
            - cab : refers to the cab which was in the transit
            - customer: refers to the customer who was in the transit.
            
- GET `/cabs/transits/{transit id}`:

    Get the specific transit details.
        
        includes: Optional. comma separated values (without any space in between). This param is used for lazy loading. The possible values for this API are 
                
            - cab : refers to the cab which was in the transit
            - customer: refers to the customer who was in the transit.

- POST `/cabs/book`:
    
    Book a cab. Params:
        
        - customer_id
        - cab_id
        - from_lat
        - from_lng
        - to_lat
        - to_lng
        - includes: Optional. comma separated values (without any space in between). This param is used for lazy loading. The possible values for this API are       
            
            - cab : refers to the cab which was in the transit
            - customer: refers to the customer who was in the transit.

- PATCH `/cabs/transits/{transit id}/start`:
    
    Start the transit/journey

- PATCH `/cabs/transits/{transit id}/end`:

    End the transit/journey
