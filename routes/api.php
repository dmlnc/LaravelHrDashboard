<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\MediaController;

use App\Http\Controllers\Api\LeadApiController;
use App\Http\Controllers\Api\UsersApiController;
use App\Http\Controllers\Api\VacancyApiController;
use App\Http\Controllers\Api\RestaurantApiController;

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


Route::group(['prefix' => 'v1', 'as' => 'api.', 'middleware' => ['auth:sanctum']], function () {

    Route::resource('users', UsersApiController::class);
    Route::post('/users/media', [UsersApiController::class, 'storeMedia']);


    Route::apiResource('restaurant', RestaurantApiController::class);

    Route::resource('vacancy', VacancyApiController::class);
    Route::post('/vacancy/media', [VacancyApiController::class, 'storeMedia']);

    Route::apiResource('page', PageController::class);
    Route::post('/page/media/{collection_name}', [PageController::class, 'storeMedia']);

    Route::apiResource('lead', LeadApiController::class);

    Route::delete('/media/{media_id}', [MediaController::class, 'deleteMedia']);

    Route::post('/logout', 'AuthController@logout');
});

Route::post('v1/lead', [LeadApiController::class, 'store']);

Route::post('v1/login', [AuthController::class, 'login']);
