<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/**
 * API Routes
 */

Route::namespace('App\Http\Controllers')->group(function() {
    // DogController route resource
    Route::resource('dogs', 'DogController')->except([
        'index', 'create', 'store', 'show', 'edit', 'update', 'destroy'
    ]);

    // DogCeoController route resource
    Route::resource('dogs_ceo', 'DogCeoController')->except([
        'index', 'create', 'store', 'show', 'edit', 'update', 'destroy'
    ]);

    // DogController routes
    Route::get('dogs', 'DogController@fetchDog')->name('dogs.index');
    Route::post('dogs', 'DogController@storeDog')->name('dogs.store');
    Route::get('dogs/{id}/edit', 'DogController@fetchDogById')->name('dogs.edit');
    Route::put('dogs/{id}', 'DogController@updateDog')->name('dogs.update');
    Route::delete('dogs/{id}', 'DogController@deleteDog')->name('dogs.destroy');

    // DogCeoController route
    Route::get('dogs/ceo/image', 'DogCeoController@fetchImage')->name('dogs_ceo.show');
});
