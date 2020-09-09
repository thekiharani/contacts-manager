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
Route::post('sms_callback', 'Api\AppController@smsCallback')->name('sms_callback');

Route::namespace('Api')->middleware('auth:sanctum')->name('api.')->group(function () {
    Route::apiResource('contacts', 'ContactController');
    Route::apiResource('groups', 'GroupController');
    Route::post('personal_sms', 'AppController@sendPersonalText')->name('personal_sms');
    Route::post('group_sms', 'AppController@sendGroupText')->name('group_sms');
    Route::post('group_contacts', 'AppController@attachGroupContacts')->name('group_contacts');
    Route::post('contacts_groups', 'AppController@attachContactsGroups')->name('contacts_groups');
    Route::post('delete_contacts', 'AppController@deleteContacts')->name('delete_contacts');
    Route::post('delete_groups', 'AppController@deleteGroups')->name('delete_groups');
});
