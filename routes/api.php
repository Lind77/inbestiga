<?php

use App\Http\Controllers\AcademicProductController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AichatController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\AssignedActivityController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\BankAccountController;
use App\Http\Controllers\ComissionController;
use App\Http\Controllers\ComunicationController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\ExternalVoucherController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\FixedActivityController;
use App\Http\Controllers\FixedTaskController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\JustificationController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\NewProductController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ObservationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\PropertiesController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SeenController;
use App\Http\Controllers\SubareaController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TimeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VoucherController;
use App\Models\Assigned_activity;
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
Route::post('login-user', [AuthController::class, 'loginUser']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('logout-customer', [AuthController::class, 'logoutCustomer'])->middleware('auth:sanctum');

//Administrative Departement

Route::get('/roles', [RoleController::class, 'index']);
Route::get('/roles-hierarchy', [RoleController::class, 'hierarchy']);
Route::get('/roles-all', [RoleController::class, 'getAllRoles']);
Route::post('/roles', [RoleController::class, 'store']);
Route::put('/roles/{id}', [RoleController::class, 'update']);

// administracion de area y subarea
Route::get('/areas', [AreaController::class, 'index']);
Route::get('/areas/{id}', [AreaController::class, 'show']);
Route::post('/areas', [AreaController::class, 'store']);
Route::post('/areas-hierarchy', [AreaController::class, 'hierarchy']);
Route::delete('/areas/{id}', [AreaController::class, 'destroy']);

Route::get('/subareas', [SubareaController::class, 'index']);
Route::post('/subareas', [SubareaController::class, 'store']);
Route::delete('/subareas/{id}', [SubareaController::class, 'destroy']);

//Administración de horarios de atención de los usuarios
//Route::get('/schedules', [ScheduleController::class, 'index']);
/* Route::get('/schedules/{id}', [ScheduleController::class, 'show']);
Route::post('/schedules', [ScheduleController::class, 'store']);
Route::delete('/schedule/{id}', [ScheduleController::class, 'destroy']); */
//Administración de asistencias
Route::get('/attendances', [AttendanceController::class, 'index']);
Route::get('/attendancess/{id}', [AttendanceController::class, 'show']);
Route::post('/attendances', [AttendanceController::class, 'store']);
Route::delete('/attendances/{id}', [AttendanceController::class, 'destroy']);

//Administración de usuarios
Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{id}', [UserController::class, 'show']);
Route::post('/users', [UserController::class, 'store']);
Route::delete('/users/{id}', [UserController::class, 'destroy']);
Route::post('/users/assign-team', [UserController::class, 'assignTeam']);
Route::get('/sellers', [UserController::class, 'getSellers']);

Route::get('/getAllMessages', [ChatController::class, 'index']);
Route::get('/getAllMessagesById/{id}', [ChatController::class, 'getAllMessagesById'])->middleware('auth:sanctum');

Route::post('/messages', [ChatController::class, 'store'])->middleware('auth:sanctum');

Route::get('/getAllProducts', [ProductController::class, 'index']);
Route::delete('/products/{id}', [ProductController::class, 'destroy']);
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
Route::get('/customers-filter/{id}', [CustomerController::class, 'filterCustomer']);
Route::post('/customers', [CustomerController::class, 'store']);
Route::put('/customers/{id}', [CustomerController::class, 'update']);
Route::post('/customers/verify', [CustomerController::class, 'verifyCustomer']);
Route::get('/customers/search/{search}', [CustomerController::class, 'searchCustomers']);
Route::get('/customers/comunications/{search}', [CustomerController::class, 'searchCustomersComunications']);
Route::delete('/customers/{id}', [CustomerController::class, 'destroy']);
Route::put('/customers/next-comunication/{id}', [CustomerController::class, 'updateNextComunication']);
Route::get('/customers/search-by-date/{date}', [CustomerController::class, 'searchCustomersByDate']);
Route::get('/customer-by-id/{id}', [CustomerController::class, 'searchCustomersById']);
//Preleads
Route::get('/preleads', [CustomerController::class, 'getAllPreleads']);
Route::get('/searchPreleads/{search}', [CustomerController::class, 'searchPreleads']);

Route::get('/quotations', [QuotationController::class, 'index']);
Route::post('/quotations', [QuotationController::class, 'store']);
Route::get('/quotations/{id}', [QuotationController::class, 'show']);
Route::delete('/quotations/{id}', [QuotationController::class, 'destroy']);
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
Route::post('/update-customer-status', [QuotationController::class, 'updateCustomerStatus']);

Route::get('/standByCustomer/{id}', [CustomerController::class, 'standByCustomer']);
Route::get('/getAllStandByCustomers', [CustomerController::class, 'getAllStandByCustomers']);
Route::get('/reactivateCustomer/{id}', [CustomerController::class, 'reactivateCustomer']);
Route::post('/updateDniCustomer', [CustomerController::class, 'updateDniCustomer']);


Route::get('/leads/{id}', [CustomerController::class, 'getAllLeads']);
Route::post('/assignOwner', [CustomerController::class, 'assignOwner'])->middleware('auth:sanctum');


Route::get('/getLeadsByDate/{date}', [CustomerController::class, 'getLeadsByDate']);
Route::get('/my-leads/{id}', [CustomerController::class, 'getAllMyLeads']);
Route::get('/changeInterest/{id}/{interest}', [CustomerController::class, 'changeInterest']);


Route::post('/orders', [OrderController::class, 'insertOrder']);
Route::post('/order', [OrderController::class, 'store']);
Route::post('/updateOrder', [OrderController::class, 'update']);

Route::post('/updateComunication', [ComunicationController::class, 'update']);
Route::post('/insertComunication', [ComunicationController::class, 'insertComunication']);
Route::get('/getComunicationsByToday/{id}', [ComunicationController::class, 'getComunicationsByToday']);
Route::get('/updateComunication/{id}', [ComunicationController::class, 'updateComunication']);
Route::get('/comunications', [ComunicationController::class, 'comunicationsClient']);

Route::post('/contracts', [ContractController::class, 'insertContract']);
Route::delete('/contracts/{id}', [ContractController::class, 'destroy']);
Route::get('/contracts', [ContractController::class, 'index']);
Route::get('/contract-file/{id}', [OrderController::class, 'generateContract']);
Route::get('/generateContract/{id}', [OrderController::class, 'generateContractPDF']);


Route::post('/updateContract', [ContractController::class, 'updateContract']);
Route::get('/searchContracts/{word}', [ContractController::class, 'search']);

Route::get('/promotions/{code}', [PromotionController::class, 'discount']);
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

Route::post('/insertDetailsFirstMeeting', [ProgressController::class, 'insertDetailsFirstMeeting']);

Route::post('/updateProgress', [ProgressController::class, 'update']);
Route::post('/deleteActivityProgress', [ProgressController::class, 'deleteActivityProgress']);
Route::get('/updateActivityProgress/{id}', [ProgressController::class, 'updateActivityProgress']);
Route::get('/removeActivityProgress/{id}', [ProgressController::class, 'removeActivityProgress']);
Route::get('/updateQualityActivity/{id}', [ProgressController::class, 'updateQualityActivity']);
Route::get('/removeQualityActivity/{id}', [ProgressController::class, 'removeQualityActivity']);

Route::get('/getAllTeams', [TeamController::class, 'index']);
Route::post('/assignTeam', [TeamController::class, 'assignTeam']);
Route::post('/user-team', [TeamController::class, 'updateUserTeam']);
Route::post('/teams', [TeamController::class, 'create']);
Route::delete('/teams/{id}', [TeamController::class, 'destroy']);

Route::get('/getNotifications', [NotificationController::class, 'index']);
Route::get('/getAllNotifications/{id}', [NotificationController::class, 'getAllNotifications']);
Route::post('/insertReject', [NotificationController::class, 'insertReject']);
Route::get('/notifications/{id}', [NotificationController::class, 'getNoSeenNotifications']);
Route::get('/registerSeen/{id}', [SeenController::class, 'registerSeen']);

Route::post('/updatePrices', [PriceController::class, 'updatePrices']);

Route::get('/getAllComissions', [ComissionController::class, 'getAllComissions']);

Route::get('/profiles', [CustomerController::class, 'getProfiles']);
Route::get('/profiles-search/{search}', [CustomerController::class, 'searchProfiles']);

Route::get('/deliveries', [DeliveryController::class, 'index']);
Route::get('/deliveries-month/{month}', [DeliveryController::class, 'deliveriesMonth']);
Route::post('/delivery', [DeliveryController::class, 'store']);
Route::get('/deliveries-date/{date}', [DeliveryController::class, 'getDeliveriesByDate']);
Route::get('/deliveries-search/{search}', [DeliveryController::class, 'search']);
Route::put('/delivery/{id}', [DeliveryController::class, 'update']);
Route::put('/delivery-info/{id}', [DeliveryController::class, 'updateInfo']);
Route::get('/check-delivery/{id}', [DeliveryController::class, 'checkDelivery']);
Route::delete('/deliveries/{id}', [DeliveryController::class, 'destroy']);


Route::post('/observation', [ObservationController::class, 'store']);

Route::get('/contract/{search}', [ContractController::class, 'searchContract']);

Route::post('/payment', [PaymentsController::class, 'store']);

Route::post('/permissions', [UserController::class, 'createPermission']);
Route::get('/permissions', [UserController::class, 'getPermissions']);
Route::put('/permissions/{id}', [UserController::class, 'updatePermission']);
Route::post('/permission-sync', [UserController::class, 'syncPermission']);
Route::post('/permission-sync-role', [UserController::class, 'syncRole']);
Route::post('/permission-sync-user', [UserController::class, 'syncPermissionUser']);
Route::get('/academic-users', [UserController::class, 'academicUsers']);
Route::get('/color-academic-users', [UserController::class, 'academicColors']);

Route::get('/meetings', [MeetingController::class, 'index']);
Route::post('/meetings', [MeetingController::class, 'store']);
Route::put('/meetings/{id}', [MeetingController::class, 'update']);
Route::delete('/meetings/{id}', [MeetingController::class, 'destroy']);
Route::get('/meetings-complete/{id}', [MeetingController::class, 'complete']);

Route::get('/projects', [ProjectController::class, 'index']);
Route::get('/projects-sprints/{id}', [ProjectController::class, 'sprints']);
Route::get('/projects-acad', [ProjectController::class, 'getAllProjectsAcad']);
Route::get('/projects/{id}', [ProjectController::class, 'show']);
Route::post('/projects', [ProjectController::class, 'store']);
Route::get('/projects-search/{search}', [ProjectController::class, 'search']);
Route::get('/projects-user/{id}', [ProjectController::class, 'getMyProjects']);
Route::get('/projects-pending', [ProjectController::class, 'projectPendings']);

Route::post('/changeStatusProject', [ProjectController::class, 'changeStatus']);
Route::get('/updateQuality/{id}', [ProjectController::class, 'updateQuality']);
Route::post('/setProject', [ProjectController::class, 'setProject']);
Route::get('/deleteProject/{id}', [ProjectController::class, 'destroy']);


Route::get('/quotations-funnel/{id}', [QuotationController::class, 'getQuotationsFunnel']);
Route::get('/quotations/search/{search}', [QuotationController::class, 'searchQuotations']);

Route::post('/attendance', [AttendanceController::class, 'store']);
Route::get('/attendance-permits', [AttendanceController::class, 'getPermissionsRequest']);
Route::get('/attendance-permits/{id}', [AttendanceController::class, 'show']);
Route::post('/attendance-permits', [AttendanceController::class, 'attendancePermits']);
Route::get('/accept-permit/{id}/{status}', [AttendanceController::class, 'acceptPermit']);
Route::get('/reject-permit/{id}', [AttendanceController::class, 'rejectPermit']);

Route::post('/json-file', [AttendanceController::class, 'jsonFile']);
Route::post('/excel-file', [AttendanceController::class, 'excelFile']);
Route::post('/files', [FileController::class, 'store']);
Route::post('/files-project', [FileController::class, 'filesProject']);
Route::get('/files/{id}', [FileController::class, 'show']);
Route::delete('/files/{id}', [FileController::class, 'destroy']);

Route::get('/schedules/{id}', [ScheduleController::class, 'show']);
Route::post('/schedules', [ScheduleController::class, 'store']);
Route::put('/schedules/{id}', [ScheduleController::class, 'update']);
Route::put('/schedules-type/{id}', [ScheduleController::class, 'updateType']);
Route::post('/schedules-day', [ScheduleController::class, 'schedulesByDay']);
Route::delete('/schedules-all/{id}', [ScheduleController::class, 'destroyAll']);

Route::get('/clients', [CustomerController::class, 'clients']);

Route::get('/payment-proof/{id}', [VoucherController::class, 'show']);

Route::put('/access/{id}', [UserController::class, 'access']);

Route::post('/properties', [PropertiesController::class, 'store']);
Route::put('/properties', [PropertiesController::class, 'update']);

/* //Rutas para CHatbot
 
Route::get('/webhook',[AichatController::class,'webhook']);
Route::post('/webhook',[AichatController::class,'recibe']);
 */

Route::get('/properties/{id}', [PropertiesController::class, 'show']);
Route::get('/projects-properties', [PropertiesController::class, 'properties']);

Route::get('/vouchers', [VoucherController::class, 'index']);
Route::post('/voucher', [VoucherController::class, 'store']);

Route::get('/external-voucher', [ExternalVoucherController::class, 'index']);
Route::post('/external-voucher', [ExternalVoucherController::class, 'store']);

Route::get('/chats/{id}', [ChatController::class, 'show']);
Route::get('/contacts/{id}', [ChatController::class, 'contacts']);
Route::get('/new-chat/{id}', [ChatController::class, 'newMessage']);

Route::get('/academic-products', [AcademicProductController::class, 'index']);

Route::post('/assigned-activity', [AssignedActivityController::class, 'store']);
Route::put('/assigned-activity/{id}', [AssignedActivityController::class, 'update']);

Route::get('/enable-project/{id}', [ProjectController::class, 'enable']);
Route::get('/search-projects/{search}', [ProjectController::class, 'searchProject']);

Route::put('/update-hour/{id}', [ScheduleController::class, 'updateHour']);
Route::post('/update-times', [ScheduleController::class, 'updateTimes']);
Route::post('/update-times-next', [ScheduleController::class, 'updateNextTimes']);

Route::post('/justification', [JustificationController::class, 'store']);

Route::post('/profile-photo', [UserController::class, 'updatePhoto']);

Route::get('/orders', [OrderController::class, 'index']);

Route::get('/customer-contract/{customerId}/{quotationId}', [ContractController::class, 'deleteCustomer']);

Route::get('/chart-attendance-values', [AttendanceController::class, 'chartValues']);

//Email
Route::post('/send-welcome-email', [EmailController::class, 'sendWelcomeEmail']);

Route::post('/assigned-activity', [AssignedActivityController::class, 'store']);
Route::get('/assigned-activities-revision/{id}', [AssignedActivityController::class, 'revision']);
Route::get('/assigned-activity-points/{id}/{points}', [AssignedActivityController::class, 'points']);
Route::get('/assigned-activity-priority/{id}/{priority}', [AssignedActivityController::class, 'priority']);
Route::get('/assigned-activity-kanban/{id}', [AssignedActivityController::class, 'kanban']);
Route::get('/assigned-activity-name/{id}/{name}', [AssignedActivityController::class, 'updateName']);
Route::get('/assigned-activity-user/{id}/{uid}', [AssignedActivityController::class, 'updateUser']);
Route::put('/assigned-activity-limit-date', [AssignedActivityController::class, 'updEndDate']);
Route::delete('/assigned-activity/{id}', [AssignedActivityController::class, 'destroy']);

Route::get('/approve-activities/{id}', [AssignedActivityController::class, 'approve']);
Route::get('/approved-activities/{id}', [AssignedActivityController::class, 'approved']);
Route::get('/points-by-team/{id}', [AssignedActivityController::class, 'pointsByTeam']);

Route::get('/process-sprint/{pid}/{id}', [DeliveryController::class, 'processSprint']);
Route::get('/search-task/{name}', [TaskController::class, 'searchTask']);

Route::get('/update-project-title/{id}/{name}', [ProjectController::class, 'updateProjectTitle']);
Route::get('/update-project-status/{id}/{status}', [ProjectController::class, 'updateProjectStatus']);

Route::post('/forms', [FormController::class, 'store']);
Route::put('/forms/{id}', [FormController::class, 'update']);
Route::get('/forms', [FormController::class, 'index']);

Route::post('/reject-assigned-activity', [AssignedActivityController::class, 'reject']);

Route::post('/file-archive', [FileController::class, 'fileArchive']);
Route::post('/file-post', [FileController::class, 'filePost']);
Route::get('/enable-file/{id}', [FileController::class, 'enableFilePost']);
Route::delete('/post/{id}', [PostController::class, 'destroy']);

Route::get('/bank-accounts', [BankAccountController::class, 'index']);

Route::get('/filter-quotations', [QuotationController::class, 'filterQuotations']);
Route::post('/filter-dates', [QuotationController::class, 'filterDates']);
Route::get('/customers-lobo', [QuotationController::class, 'customersLobo']);

Route::get('/addressData', [DepartmentController::class, 'addressData']);

Route::get('/quotation-vouchers', [QuotationController::class, 'quotationVouchers']);
Route::get('/status-voucher/{voucherStatus}/{voucherId}', [QuotationController::class, 'statusVoucher']);
Route::get('/change-color-event/{deliveryId}/{userId}', [DeliveryController::class, 'changeColorEvent']);
