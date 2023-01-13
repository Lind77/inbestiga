<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FixedActivityController;
use App\Http\Controllers\FixedTaskController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TimeController;
use App\Models\User;
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
    $user = User::where('id',$request->user()->id)->with('roles')->get();
    return $user;
});

Route::post('login', [AuthController::class,'login']);
Route::post('logout', [AuthController::class,'logout'])->middleware('auth:sanctum');


Route::get('/getAllQuotations',[QuotationController::class, 'index']);

Route::get('/getAllProducts',[ProductController::class, 'index']);
Route::post('/insertProduct',[ProductController::class, 'store']);

Route::post('/insertFixedActivity', [FixedActivityController::class, 'store']);
Route::post('/insertFixedTask',[FixedTaskController::class, 'store']);

Route::get('/getActivitiesPerId/{id}', [ActivityController::class, 'getActivitiesPerId']);
Route::get('/deleteActivity/{id}', [ActivityController::class, 'destroy']);
Route::get('/changeStatusActivity/{id}', [ActivityController::class, 'changeStatus']);

Route::post('/insertTimeTask', [TaskController::class, 'insertTimeTask']);
Route::post('/insertEndTimeTask', [TaskController::class, 'insertEndTimeTask']);

Route::post('/insertTimes', [TimeController::class, 'insertTimes']);


Route::post('/insertQuotation', [QuotationController::class, 'store']);
Route::get('/generatePDF/{id}', [QuotationController::class, 'generatePDF']);

Route::get('/getAllProjects',[ProjectController::class, 'index']);
Route::get('/getProjectById/{id}', [ProjectController::class, 'show']);
Route::post('/insertProject',[ProjectController::class, 'store']);
Route::post('/changeStatusProject',[ProjectController::class, 'changeStatus']);

Route::post('/updateProgress',[ProgressController::class, 'update']);

Route::get('/getAllOwners', [OwnerController::class, 'index']);

Route::get('/getAllTeams', [TeamController::class,'index']);

Route::get('/getAllCustomers', [CustomerController::class, 'index']);
Route::post('/insertCustomer', [CustomerController::class, 'insertCustomer']);

