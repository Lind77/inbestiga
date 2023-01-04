<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\QuotationController;
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

Route::get('/getAllQuotations',[QuotationController::class, 'index']);

Route::get('/getAllProducts',[ProductController::class, 'index']);
Route::post('/insertProduct',[ProductController::class, 'store']);

Route::post('/insertActivity', [ActivityController::class, 'store']);
Route::get('/deleteActivity/{id}', [ActivityController::class, 'destroy']);
Route::get('/changeStatusActivity/{id}', [ActivityController::class, 'changeStatus']);

Route::post('/insertQuotation', [QuotationController::class, 'store']);
Route::get('/generatePDF/{id}', [QuotationController::class, 'generatePDF']);

Route::get('/getAllProjects',[ProjectController::class, 'index']);
Route::post('/insertProject',[ProjectController::class, 'store']);
Route::post('/changeStatusProject',[ProjectController::class, 'changeStatus']);

Route::post('/updateProgress',[ProgressController::class, 'update']);

Route::get('/getAllOwners', [OwnerController::class, 'index']);

Route::get('/getAllCustomers', [CustomerController::class, 'index']);