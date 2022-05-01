<?php

use System\Router\Api\Route;

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

// Home Api routes ...
Route::get('', 'HomeController@index', 'api.index');
Route::get('create', 'HomeController@create', 'api.create');
Route::post('store', 'HomeController@store', 'api.store');
Route::get('edit/{id}', 'HomeController@edit', 'api.edit');
