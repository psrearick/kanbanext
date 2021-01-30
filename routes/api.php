<?php

use App\Http\Controllers\CardController;
use App\Http\Controllers\ColumnController;
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

Route::get('columns', [ColumnController::class, 'index']);
Route::get('download', [ColumnController::class, 'downloadDatabase']);
Route::group(['prefix' => 'column'], function () {
    Route::post('add', [ColumnController::class, 'add']);
    Route::get('edit/{id}', [ColumnController::class, 'edit']);
    Route::post('update/{id}', [ColumnController::class, 'update']);
    Route::delete('delete/{id}', [ColumnController::class, 'delete']);
});

Route::get('cards', [CardController::class, 'index']);
Route::group(['prefix' => 'card'], function () {
    Route::post('add', [CardController::class, 'add']);
    Route::get('edit/{id}', [CardController::class, 'edit']);
    Route::post('update/{id}', [CardController::class, 'update']);
    Route::delete('delete/{id}', [CardController::class, 'delete']);
});
