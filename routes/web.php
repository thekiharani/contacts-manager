<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes(['verify' => true]);
Route::get('web_contacts', 'ContactController@index');

Route::get('/{any}', 'AppController@index')->where('any', '.*');

