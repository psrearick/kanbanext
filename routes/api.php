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

Route::middleware('auth:api')->get('user', function (Request $request) {
    return $request->user();
});

Route::get('columns', 'ColumnController@index');
Route::group(['prefix' => 'columns'], function () {
    Route::post('add', 'ColumnController@add');
    Route::get('edit/{id}', 'ColumnController@edit');
    Route::post('update/{id}', 'ColumnController@update');
    Route::delete('delete/{id}', 'ColumnController@delete');
});

Route::get('cards', 'CardController@index');
Route::group(['prefix' => 'cards'], function () {
    Route::post('add', 'CardController@add');
    Route::get('edit/{id}', 'CardController@edit');
    Route::post('update/{id}', 'CardController@update');
    Route::delete('delete/{id}', 'CardController@delete');
});
