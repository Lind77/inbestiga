<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ComunicationController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FixedActivityController;
use App\Http\Controllers\FixedTaskController;
use App\Http\Controllers\NewProductController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\SeenController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TimeController;
use App\Http\Controllers\UserController;
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
    $user = User::where('id',$request->user()->id)->with(['roles','memoir'])->get();
    return $user;
});

Route::get('/migrate', function(){
    \Artisan::call('migrate');
    dd('migrated!');
});

Route::post('login', [AuthController::class,'login']);
Route::post('logout', [AuthController::class,'logout'])->middleware('auth:sanctum');

Route::get('/getRoles', [UserController::class, 'getRoles']);
Route::post('/createRol', [UserController::class, 'createRol']);

Route::post('/createUser', [UserController::class, 'createUser']);
Route::get('/getAllUsers', [UserController::class, 'getAllUsers']);
Route::get('/deleteUser/{id}', [UserController::class, 'deleteUser']);
Route::post('/assignTeamUser', [UserController::class, 'assignTeamUser']);
Route::get('/getUserData/{id}', [UserController::class, 'getUserData']);
Route::get('/getAllSellers', [UserController::class, 'getAllSellers']);


Route::get('/getAllProducts',[ProductController::class, 'index']);
Route::post('/insertProduct',[ProductController::class, 'store']);
Route::post('/assignProduct', [ProductController::class, 'assignProduct']);
Route::get('/getAllProductsWithPrices',[ProductController::class, 'getAllProductsWithPrices']);

Route::get('/getAllNewProducts',[NewProductController::class, 'getAllNewProducts']);
Route::post('/insertNewProduct',[ProductController::class, 'insertNewProduct']);

Route::post('/insertFixedActivity', [FixedActivityController::class, 'store']);
Route::post('/insertFixedTask',[FixedTaskController::class, 'store']);

Route::get('/getActivitiesPerId/{id}', [ActivityController::class, 'getActivitiesPerId']);
Route::get('/deleteActivity/{id}', [ActivityController::class, 'destroy']);
Route::get('/changeStatusActivity/{id}', [ActivityController::class, 'changeStatus']);


Route::post('/changeTaskStatus', [TaskController::class, 'changeStatus']);
Route::post('/insertTimeTask', [TaskController::class, 'insertTimeTask']);
Route::post('/insertEndTimeTask', [TaskController::class, 'insertEndTimeTask']);

Route::post('/insertTimes', [TimeController::class, 'insertTimes']);

Route::get('/getAllQuotations',[QuotationController::class, 'index']);
Route::post('/insertQuotation', [QuotationController::class, 'store']);
Route::get('/quotation/{id}', [QuotationController::class, 'show']);
Route::get('/generatePDF/{id}', [QuotationController::class, 'generatePDF']);
Route::post('/quotationPDF', [QuotationController::class, 'newPDF']);
Route::get('/getQuotationByCustomerId/{id}', [QuotationController::class, 'getQuotationByCustomerId']);
Route::get('/quotationByOrder/{id}', [QuotationController::class, 'getQuotationByOrder']);
Route::post('/updateQuotation',[QuotationController::class, 'updateQuotation']);
Route::get('/searchQuotations/{search}', [QuotationController::class, 'search']);
Route::get('/searchQuotationsByDate/{date}', [QuotationController::class, 'searchQuotationsByDate']);


Route::get('/getAllProjects',[ProjectController::class, 'index']);
Route::get('/getAllProjectsAcad',[ProjectController::class, 'getAllProjectsAcad']);
Route::get('/getProjectById/{id}', [ProjectController::class, 'show']);
Route::post('/insertProject',[ProjectController::class, 'store']);
Route::post('/changeStatusProject',[ProjectController::class, 'changeStatus']);
Route::get('/updateQuality/{id}', [ProjectController::class, 'updateQuality']);
Route::post('/setProject', [ProjectController::class, 'setProject']);
Route::get('/deleteProject/{id}',[ProjectController::class, 'destroy']);
Route::get('/getMyProjects/{id}', [ProjectController::class, 'getMyProjects']);

Route::post('/insertDetailsFirstMeeting', [ProgressController::class, 'insertDetailsFirstMeeting']);

Route::post('/updateProgress',[ProgressController::class, 'update']);
Route::post('/deleteActivityProgress',[ProgressController::class, 'deleteActivityProgress']);
Route::get('/updateActivityProgress/{id}', [ProgressController::class, 'updateActivityProgress']);
Route::get('/removeActivityProgress/{id}', [ProgressController::class, 'removeActivityProgress']);
Route::get('/updateQualityActivity/{id}', [ProgressController::class, 'updateQualityActivity']);
Route::get('/removeQualityActivity/{id}', [ProgressController::class, 'removeQualityActivity']);

Route::get('/getAllOwners', [OwnerController::class, 'index']);
Route::get('/verifyOwner/{id}', [OwnerController::class, 'verifyOwner']);

Route::get('/getAllTeams', [TeamController::class,'index']);
Route::post('/assignTeam', [TeamController::class, 'assignTeam']);

Route::get('/getAllCustomers', [CustomerController::class, 'index']);
Route::get('/getCustomer/{id}', [CustomerController::class, 'show']);
Route::post('/insertCustomer', [CustomerController::class, 'insertCustomer']);
Route::get('/updateCustomerGrade/{id}/{status}', [CustomerController::class,'updateCustomerGrade']);
Route::post('/updateCustomer', [CustomerController::class, 'updateCustomer']);
Route::get('/standByCustomer/{id}', [CustomerController::class,'standByCustomer']);
Route::get('/getAllStandByCustomers', [CustomerController::class, 'getAllStandByCustomers']);
Route::get('/reactivateCustomer/{id}', [CustomerController::class, 'reactivateCustomer']);
Route::post('/updateDniCustomer', [CustomerController::class, 'updateDniCustomer']);
Route::get('/getAllPreleads', [CustomerController::class, 'getAllPreleads']);
Route::get('/getAllLeads/{id}', [CustomerController::class, 'getAllLeads']);
Route::post('/assignOwner', [CustomerController::class, 'assignOwner']);

Route::get('/getAllMessages', [ChatController::class, 'index']);
Route::get('/getAllMessagesById/{id}', [ChatController::class, 'getAllMessagesById'])->middleware('auth:sanctum');
Route::post('/storeMessage',[ChatController::class, 'store'])->middleware('auth:sanctum');

Route::get('/getAllOrders', [OrderController::class, 'index']);
Route::post('/insertOrder',[OrderController::class, 'store']);

Route::get('/getNotifications', [NotificationController::class, 'index']);
Route::get('/getAllNotifications/{id}', [NotificationController::class, 'getAllNotifications']);
Route::post('/insertReject',[NotificationController::class, 'insertReject']);

Route::get('/getNoSeenNotifications/{id}', [NotificationController::class, 'getNoSeenNotifications']);
Route::get('/registerSeen/{id}', [SeenController::class, 'registerSeen']);

Route::post('/updateComunication', [ComunicationController::class, 'update']);

Route::get('/getAllContracts', [ContractController::class, 'index']);
Route::get('/generateContract/{id}', [OrderController::class, 'generateContract']);
Route::post('/insertContract',[OrderController::class, 'insertContract']);

Route::post('/updatePrices', [PriceController::class, 'updatePrices']);
