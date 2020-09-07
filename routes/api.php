<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('contacts/list', 'Api\ContactController@index')->name('my_contacts');

Route::namespace('Api')->middleware('auth:sanctum')->name('api.')->group(function () {
    Route::apiResource('contacts', 'ContactController');
    Route::apiResource('groups', 'GroupController');
});
