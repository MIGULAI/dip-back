<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\AuthorsController;
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



Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::get('/autors', [AuthorsController::class, 'GetAutors']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/autor/add', [AuthorsController::class, 'AddAutors']);

});