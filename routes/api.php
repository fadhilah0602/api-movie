<?php

use App\Http\Controllers\API\MovieController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/movie', [MovieController::class, 'index']);
Route::post('/movie', [MovieController::class, 'store']);
Route::get('/movie/{id}', [MovieController::class, 'show']);
Route::put('/movie/{id}', [MovieController::class, 'update']);
Route::delete('/movie/{id}', [MovieController::class, 'destroy']);
