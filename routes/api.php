<?php

use App\Http\Controllers\AnalyzeController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\AuthorsController;
use App\Http\Controllers\CafedraController;
use App\Http\Controllers\DegreeController;
use App\Http\Controllers\InitController;
use App\Http\Controllers\LangConroller;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\PublicationsController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\StatisticController;
use App\Http\Controllers\SetupController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\RankController;
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

Route::get('/init', [InitController::class, 'Init']);
Route::get('/userinit', [SetupController::class, 'ClientSetup']);

Route::get('/setup', [SetupController::class, 'GetGlobalSetup']);
Route::post('/publication/byAutorId', [PublicationsController::class, 'PublByAuthorID']);
Route::post('/publication/byplan', [PublicationsController::class, 'PublByPlan']);
Route::get('/publications', [PublicationsController::class, 'GetAllPublications']);
Route::post('/publication', [PublicationsController::class, 'GetPublicationById']);

Route::get('/plans/years', [PlanController::class, 'GetYearsList']);
Route::get('/plans/yearsbyauthor', [PlanController::class, 'GetYearsListByAuthor']);
Route::post('/plans/year', [PlanController::class, 'GetPlansByYear']);
Route::get('/plan/byyearsndbyauthor', [PlanController::class, 'GetYearsAndByAuthor']);
Route::post('/plan/about', [PlanController::class, 'GetPlanById']);

Route::get('/authors', [AuthorsController::class, 'GetAuthors']);
Route::get('/planinauthors', [AuthorsController::class, 'GetPlaningAuthors']);
Route::get('/authors/full', [AuthorsController::class, 'GetAuthorsFull']);
Route::get('/author', [AuthorsController::class, 'GetAuthor']);
Route::get('/positions', [PositionController::class, 'GetPositions']);

Route::get('/publication/authors', [PublicationsController::class, 'GetAuthors']);

Route::get('/depanalyze/authors/count', [AnalyzeController::class, 'GetAuthorsOfDepartmentCount']);
Route::get('/depanalyze/basestat', [AnalyzeController::class, 'GetBasicDepStats']);
Route::get('/depanalyze/studentcount', [AnalyzeController::class, 'GetStudentCount']);
Route::get('/depanalyze/publcountbytypes', [AnalyzeController::class, 'GetCountByYearsAndTypes']);

Route::get('/authoranalyze/publcountbytypesbyauthor', [AnalyzeController::class, 'GetCountByYearsAndTypesByAuthor']);

Route::get('/monitoring/byplan', [MonitoringController::class, 'getPlanId']);



Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/authors/setup', [AuthorsController::class, 'GetAuthorsSetup']);
    Route::post('/author/add', [AuthorsController::class, 'AddAuthor']);
    Route::post('/authors/json', [PublicationsController::class, 'JSONToPublications']);
    Route::put('/author', [AuthorsController::class, 'PutAuthor'])->middleware();

    Route::get('/publications/setup', [PublicationsController::class, 'GetPublicationsSetup']);
    Route::post('/publications/add', [PublicationsController::class, 'AddPublication']);
    Route::put('/publication', [PublicationsController::class, 'PutPublication']);

    Route::get('/statistic/auth', [StatisticController::class, 'GetBasicStatistic']);

    Route::post('/plans/create', [PlanController::class, 'CreatePlanByForYear']);
    Route::put('/plans/create', [PlanController::class, 'SavePlan']);
    Route::get('/plans/calculate', [PlanController::class, 'CalculatePlans']);

    Route::put('/setup/authors', [SetupController::class, 'SetAuthorsNumber']);
    Route::put('/setup/checker', [SetupController::class, 'SetAutoCheck']);

    Route::post('/publisher/add', [PublisherController::class, 'CreatePublisher']);
    Route::post('/lang/add', [LangConroller::class, 'CreateLang']);
    Route::post('/posision/add', [PositionController::class, 'CreatePosision']);
    Route::post('/rank/add', [RankController::class, 'CreateRank']);
    Route::post('/degree/add', [DegreeController::class, 'CreateDegree']);
    Route::post('/cafedra/add', [CafedraController::class, 'CreateCafedra']);
    Route::get('/logout', [AuthController::class, 'logout']);

});

Route::get('/{any}', function () {
    return response()->json(['success' => false, 'message' => 'Route didnt found' ], 404);
})->where('any', '.*');