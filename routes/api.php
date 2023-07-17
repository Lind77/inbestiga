<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\ComissionController;
use App\Http\Controllers\ComunicationController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\FixedActivityController;
use App\Http\Controllers\FixedTaskController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\NewProductController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ObservationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SeenController;
use App\Http\Controllers\SubareaController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TimeController;
use App\Http\Controllers\UserController;
use App\Models\Comission;
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
    $user = User::where('id', $request->user()->id)->with(['roles', 'memoir'])->get();
    return $user;
});

Route::get('/migrate', function () {
    \Artisan::call('migrate');
    dd('migrated!');
});

Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

//Administrative Departement

Route::get('/roles', [RoleController::class, 'index']);
Route::get('/roles-all', [RoleController::class, 'getAllRoles']);
Route::post('/roles', [RoleController::class, 'store']);

// administracion de area y subarea
Route::get('/areas', [AreaController::class, 'index']);
Route::get('/areas/{id}', [AreaController::class, 'show']);
Route::post('/areas', [AreaController::class, 'store']);
Route::delete('/areas/{id}', [AreaController::class, 'destroy']);

Route::get('/subareas', [SubareaController::class, 'index']);
Route::post('/subareas', [SubareaController::class, 'store']);
Route::delete('/subareas/{id}', [SubareaController::class, 'destroy']);

Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{id}', [UserController::class, 'show']);
Route::post('/users', [UserController::class, 'store']);
Route::delete('/users/{id}', [UserController::class, 'destroy']);
Route::post('/users/assign-team', [UserController::class, 'assignTeam']);
Route::get('/sellers', [UserController::class, 'getSellers']);

Route::get('/getAllMessages', [ChatController::class, 'index']);
Route::get('/getAllMessagesById/{id}', [ChatController::class, 'getAllMessagesById'])->middleware('auth:sanctum');
Route::post('/storeMessage', [ChatController::class, 'store'])->middleware('auth:sanctum');

Route::get('/getAllProducts', [ProductController::class, 'index']);
Route::post('/insertProduct', [ProductController::class, 'store']);
Route::post('/assignProduct', [ProductController::class, 'assignProduct']);
Route::get('/getAllProductsWithPrices', [ProductController::class, 'getAllProductsWithPrices']);

Route::get('/getAllNewProducts', [NewProductController::class, 'getAllNewProducts']);
Route::post('/insertNewProduct', [ProductController::class, 'insertNewProduct']);
Route::get('/getNewProductsById/{id}', [NewProductController::class, 'getNewProductsById']);

Route::post('/insertFixedActivity', [FixedActivityController::class, 'store']);
Route::post('/insertFixedTask', [FixedTaskController::class, 'store']);

//Sales Department

//Customers

Route::get('/customers', [CustomerController::class, 'index']);
Route::post('/customers', [CustomerController::class, 'store']);
Route::put('/customers/{id}', [CustomerController::class, 'update']);
Route::post('/customers/verify', [CustomerController::class, 'verifyCustomer']);
Route::get('/customers/search/{search}', [CustomerController::class, 'searchCustomers']);
Route::get('/customers/comunications/{search}', [CustomerController::class, 'searchCustomersComunications']);
Route::put('/customers/next-comunication/{id}', [CustomerController::class, 'updateNextComunication']);
Route::get('/customers/search-by-date/{date}', [CustomerController::class, 'searchCustomersByDate']);
Route::get('/customer-by-id/{id}', [CustomerController::class, 'searchCustomersById']);
//Preleads
Route::get('/preleads', [CustomerController::class, 'getAllPreleads']);
Route::get('/searchPreleads/{search}', [CustomerController::class, 'searchPreleads']);

Route::get('/quotations', [QuotationController::class, 'index']);
Route::post('/quotations', [QuotationController::class, 'store']);
Route::get('/quotations/{id}', [QuotationController::class, 'show']);
Route::get('/quotations/{id}/pdf', [QuotationController::class, 'generatePDF']);
Route::get('/getQuotationByCustomerId/{id}', [QuotationController::class, 'getQuotationByCustomerId']);
Route::get('/quotationByOrder/{id}', [QuotationController::class, 'getQuotationByOrder']);
Route::post('/updateQuotation', [QuotationController::class, 'updateQuotation']);
Route::get('/searchQuotations/{search}', [QuotationController::class, 'search']);
Route::get('/searchQuotationsByDate/{date}', [QuotationController::class, 'searchQuotationsByDate']);


Route::get('/getAllOwners', [OwnerController::class, 'index']);
Route::get('/verifyOwner/{id}', [OwnerController::class, 'verifyOwner']);
Route::post('/updateOwner', [OwnerController::class, 'updateOwner']);


Route::get('/getCustomer/{id}', [CustomerController::class, 'show']);

Route::post('/update-quotation-status', [QuotationController::class, 'updateCustomerGrade']);

Route::get('/standByCustomer/{id}', [CustomerController::class, 'standByCustomer']);
Route::get('/getAllStandByCustomers', [CustomerController::class, 'getAllStandByCustomers']);
Route::get('/reactivateCustomer/{id}', [CustomerController::class, 'reactivateCustomer']);
Route::post('/updateDniCustomer', [CustomerController::class, 'updateDniCustomer']);


Route::get('/leads', [CustomerController::class, 'getAllLeads']);
Route::post('/assignOwner', [CustomerController::class, 'assignOwner']);


Route::get('/getLeadsByDate/{date}', [CustomerController::class, 'getLeadsByDate']);
Route::get('/getAllMyLeads/{id}', [CustomerController::class, 'getAllMyLeads']);
Route::get('/changeInterest/{id}/{interest}', [CustomerController::class, 'changeInterest']);


Route::get('/getAllOrders', [OrderController::class, 'index']);
Route::post('/insertOrder', [OrderController::class, 'store']);
Route::post('/updateOrder', [OrderController::class, 'update']);


Route::post('/updateComunication', [ComunicationController::class, 'update']);
Route::post('/insertComunication', [ComunicationController::class, 'insertComunication']);
Route::get('/getComunicationsByToday/{id}', [ComunicationController::class, 'getComunicationsByToday']);
Route::get('/updateComunication/{id}', [ComunicationController::class, 'updateComunication']);
Route::get('/comunications', [ComunicationController::class, 'comunicationsClient']);

Route::get('/getAllContracts', [ContractController::class, 'index']);
Route::get('/generateContract/{id}', [OrderController::class, 'generateContract']);
Route::post('/insertOrder', [OrderController::class, 'insertOrder']);

Route::post('/insertContract', [ContractController::class, 'insertContract']);
Route::post('/updateContract', [ContractController::class, 'updateContract']);

Route::post('/insertCode', [PriceController::class, 'insertCode']);
Route::get('/getPromotionCode', [PriceController::class, 'getPromotionCode']);
Route::get('/getAllPromotionsCode', [PriceController::class, 'getAllPromotionsCode']);
Route::delete('/promotions/{id}', [PromotionController::class, 'destroy']);

Route::post('/addNotificationComunication', [NotificationController::class, 'addNotificationComunication']);
//Academic Department

Route::get('/getActivitiesPerId/{id}', [ActivityController::class, 'getActivitiesPerId']);
Route::get('/deleteActivity/{id}', [ActivityController::class, 'destroy']);
Route::get('/changeStatusActivity/{id}', [ActivityController::class, 'changeStatus']);


Route::post('/changeTaskStatus', [TaskController::class, 'changeStatus']);
Route::post('/insertTimeTask', [TaskController::class, 'insertTimeTask']);
Route::post('/insertEndTimeTask', [TaskController::class, 'insertEndTimeTask']);

Route::post('/insertTimes', [TimeController::class, 'insertTimes']);


Route::get('/getAllProjects', [ProjectController::class, 'index']);
Route::get('/getAllProjectsAcad', [ProjectController::class, 'getAllProjectsAcad']);
Route::get('/getProjectById/{id}', [ProjectController::class, 'show']);
Route::post('/insertProject', [ProjectController::class, 'store']);
Route::post('/changeStatusProject', [ProjectController::class, 'changeStatus']);
Route::get('/updateQuality/{id}', [ProjectController::class, 'updateQuality']);
Route::post('/setProject', [ProjectController::class, 'setProject']);
Route::get('/deleteProject/{id}', [ProjectController::class, 'destroy']);
Route::get('/getMyProjects/{id}', [ProjectController::class, 'getMyProjects']);

Route::post('/insertDetailsFirstMeeting', [ProgressController::class, 'insertDetailsFirstMeeting']);

Route::post('/updateProgress', [ProgressController::class, 'update']);
Route::post('/deleteActivityProgress', [ProgressController::class, 'deleteActivityProgress']);
Route::get('/updateActivityProgress/{id}', [ProgressController::class, 'updateActivityProgress']);
Route::get('/removeActivityProgress/{id}', [ProgressController::class, 'removeActivityProgress']);
Route::get('/updateQualityActivity/{id}', [ProgressController::class, 'updateQualityActivity']);
Route::get('/removeQualityActivity/{id}', [ProgressController::class, 'removeQualityActivity']);

Route::get('/getAllTeams', [TeamController::class, 'index']);
Route::post('/assignTeam', [TeamController::class, 'assignTeam']);

Route::get('/getNotifications', [NotificationController::class, 'index']);
Route::get('/getAllNotifications/{id}', [NotificationController::class, 'getAllNotifications']);
Route::post('/insertReject', [NotificationController::class, 'insertReject']);
Route::get('/getNoSeenNotifications/{id}', [NotificationController::class, 'getNoSeenNotifications']);
Route::get('/registerSeen/{id}', [SeenController::class, 'registerSeen']);

Route::post('/updatePrices', [PriceController::class, 'updatePrices']);

Route::get('/getAllComissions', [ComissionController::class, 'getAllComissions']);

Route::get('/profiles', [CustomerController::class, 'getProfiles']);

Route::get('/deliveries', [DeliveryController::class, 'index']);
Route::post('/delivery', [DeliveryController::class, 'store']);
Route::get('/deliveries-date/{date}', [DeliveryController::class, 'getDeliveriesByDate']);
Route::get('/deliveries-search/{search}', [DeliveryController::class, 'search']);
Route::put('/delivery/{id}', [DeliveryController::class, 'update']);
Route::get('/check-delivery/{id}', [DeliveryController::class, 'checkDelivery']);

Route::post('/observation', [ObservationController::class, 'store']);

Route::get('/contract/{search}', [ContractController::class, 'searchContract']);

Route::post('/payment', [PaymentsController::class, 'store']);

Route::post('/permissions', [UserController::class, 'createPermission']);
Route::get('/permissions', [UserController::class, 'getPermissions']);
Route::post('/permission-sync', [UserController::class, 'syncPermission']);
Route::post('/permission-sync-user', [UserController::class, 'syncPermissionUser']);

Route::get('/meetings', [MeetingController::class, 'index']);
Route::post('/meetings', [MeetingController::class, 'store']);

Route::get('/quotations-funnel', [QuotationController::class, 'getQuotationsFunnel']);
