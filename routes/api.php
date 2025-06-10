<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BreedController;
use App\Http\Controllers\UserParkController;
use App\Http\Controllers\UserBreedController;
use App\Http\Controllers\ParkBreedController;

Route::prefix('breeds')->group(function () {
    Route::get('/',               [BreedController::class, 'index']);   
    Route::get('/random',               [BreedController::class, 'random']);   
    Route::get('/{breed}',               [BreedController::class, 'show']);        
    Route::get('/{breed}/image', [BreedController::class, 'getBreedImage']); 
});

Route::prefix('users')->group(function () {
    // NOTE: YOU COULD ALSO IMPLEMENT A GENERIC USERASSOCIATIONCONTROLLER 
    // THAT ACCEPTS A TYPE AND ID IN THE REQUEST AND HANDLES MULTIPLE ASSOCIATION TYPES. GOOD IDEA FOR SMALL APPLICATION OF TESTS ;)
    // THE BELOW HOWEVER IS USEFUL WHEN RELATIONSHIPS GROW OR ARE DYNAMIC OR REQUIRE OTHER LOGIC. 
    // FOR THIS EXERCISE, I’VE USED SEPARATE CONTROLLERS TO FOLLOW REST BEST PRACTICES. :D
    Route::post('/{user}/parks',               [UserParkController::class, 'store']);   
    Route::post('/{user}/breeds',              [UserBreedController::class, 'store']);   
});

Route::prefix('parks')->group(function () {
    Route::post('/{park}/breeds',              [ParkBreedController::class, 'store']);   
});



