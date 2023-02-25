<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\AuthorsController;
use App\Http\Controllers\PublicationsController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\StatisticController;
use App\Http\Controllers\SetupController;
use App\Http\Controllers\PlanController;
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

Route::get('/setup', [SetupController::class, 'GetGlobalSetup']);

Route::get('/plans/years', [PlanController::class, 'GetYearsList']);

Route::get('/authors', [AuthorsController::class, 'GetAuthors']);
Route::get('/positions', [PositionController::class, 'GetPositions']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/authors/setup', [AuthorsController::class, 'GetAuthorsSetup']);
    Route::post('/author/add', [AuthorsController::class, 'AddAuthor']);
    Route::post('/authors/json', [PublicationsController::class, 'JSONToPublications']);

    Route::get('/publications/setup', [PublicationsController::class, 'GetPublicationsSetup']);
    Route::post('/publications/add', [PublicationsController::class, 'AddPublication']);

    Route::get('/statistic/auth', [StatisticController::class, 'GetBasicStatistic']);

    Route::post('/plans/create', [PlanController::class, 'CreatePlanByForYear']);
    Route::put('/plans/create', [PlanController::class, 'SavePlan']);
    Route::get('/plans/calculate', [PlanController::class, 'CalculatePlans']);

    Route::put('/setup/authors',[SetupController::class, 'SetAuthorsNumber']);
    Route::put('/setup/checker',[SetupController::class, 'SetAutoCheck']);

});
