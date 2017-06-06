<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'prefix'        => 'v1',
    'middleware'    => ['header']
], function () {

    // Customer routes
    Route::group(['prefix' => 'customers'], function () {
        // Get Customer.
        Route::get('/{id?}', 'CustomerController@get')->where('id', '[0-9]+');
    });

    // Cab routes
    Route::group(['prefix' => 'cabs'], function () {
        // Search near by available cab
        Route::get('/nearby', 'CabController@search');

        // Get all the cab types.
        Route::get('/types', 'CabController@types');

        // Search cab list
        Route::get('/{id?}', 'CabController@get')->where('id', '[0-9]+');

        // Book cab
        Route::post('/book', 'CabController@book');

        // Cab Transits routes.
        Route::group(['prefix' => 'transits'], function () {
            // Get list of transits
            Route::get('{transitId?}', 'TransitController@get')->where('transitId', '[0-9]+');

            // Start journey
            Route::patch('{transitId}/start', 'TransitController@start')->where('transitId', '[0-9]+');

            // End journey
            Route::patch('{transitId}/end', 'TransitController@end')->where('transitId', '[0-9]+');
        });
    });
});
