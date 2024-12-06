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
// Ruta para obtener el usuario autenticado
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    $user = User::where('id', $request->user()->id)->with(['roles', 'memoir'])->get();
    return $user;
});
// Ruta para ejecutar migraciones
Route::get('/migrate', function () {
    \Artisan::call('migrate');
    dd('migrated!');
});
// Rutas de autenticación
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
// Rutas de chat
Route::get('/getAllMessages', [ChatController::class, 'index']);
Route::get('/getAllMessagesById/{id}', [ChatController::class, 'getAllMessagesById'])->middleware('auth:sanctum');

Route::post('/messages', [ChatController::class, 'store'])->middleware('auth:sanctum');
// Rutas de administración de productos
Route::get('/getAllProducts', [ProductController::class, 'index']);
Route::delete('/products/{id}', [ProductController::class, 'destroy']);
Route::post('/insertProduct', [ProductController::class, 'store']);
Route::post('/assignProduct', [ProductController::class, 'assignProduct']);
Route::get('/getAllProductsWithPrices', [ProductController::class, 'getAllProductsWithPrices']);
// Rutas de productos nuevos
Route::get('/getAllNewProducts', [NewProductController::class, 'getAllNewProducts']);
Route::post('/insertNewProduct', [ProductController::class, 'insertNewProduct']);
Route::get('/getNewProductsById/{id}', [NewProductController::class, 'getNewProductsById']);
// Rutas de actividades fijas
Route::post('/insertFixedActivity', [FixedActivityController::class, 'store']);
Route::post('/insertFixedTask', [FixedTaskController::class, 'store']);

//Sales Department

//Customers
// Rutas de clientes
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
// Rutas para cotizaciones
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
Route::get('/quotation-customer/{customerId}/{quotationId}',  [QuotationController::class, 'quotationCustomer']);
Route::delete('/quotation-customer/{customerId}/{quotationId}',  [QuotationController::class, 'deleteQuotationCustomer']);
// Rutas para owners
Route::get('/getAllOwners', [OwnerController::class, 'index']);
Route::get('/verifyOwner/{id}', [OwnerController::class, 'verifyOwner']);
Route::post('/updateOwner', [OwnerController::class, 'updateOwner']);

// Rutas para gestión de leads
Route::get('/getCustomer/{id}', [CustomerController::class, 'show']);

/**
 * Actualizar el estado de una cotización.
 *
 * @return \Illuminate\Http\Response
 */
Route::post('/update-quotation-status', [QuotationController::class, 'updateCustomerGrade']);

/**
 * Actualizar el estado de un cliente.
 *
 * @return \Illuminate\Http\Response
 */
Route::post('/update-customer-status', [QuotationController::class, 'updateCustomerStatus']);

/**
 * Poner un cliente en estado de espera por ID.
 *
 * @param int $id ID del cliente.
 * @return \Illuminate\Http\Response
 */
Route::get('/standByCustomer/{id}', [CustomerController::class, 'standByCustomer']);

/**
 * Obtener todos los clientes en estado de espera.
 *
 * @return \Illuminate\Http\Response
 */
Route::get('/getAllStandByCustomers', [CustomerController::class, 'getAllStandByCustomers']);

/**
 * Reactivar un standby cliente por ID.
 *
 * @param int $id ID del cliente.
 * @return \Illuminate\Http\Response
 */
Route::get('/reactivateCustomer/{id}', [CustomerController::class, 'reactivateCustomer']);

/**
 * Actualizar el DNI de un cliente.
 *
 * @return \Illuminate\Http\Response
 */
Route::post('/updateDniCustomer', [CustomerController::class, 'updateDniCustomer']);

/**
 * Obtener todos los leads de un cliente por ID.
 *
 * @param int $id ID del cliente.
 * @return \Illuminate\Http\Response
 */
Route::get('/leads/{id}', [CustomerController::class, 'getAllLeads']);

/**
 * Asignar un propietario a un lead.
 *
 * @return \Illuminate\Http\Response
 */
Route::post('/assign-owner', [CustomerController::class, 'assignOwner'])->middleware('auth:sanctum');

/**
 * Obtener leads por fecha.
 *
 * @param string $date Fecha para filtrar leads.
 * @return \Illuminate\Http\Response
 */
Route::get('/getLeadsByDate/{date}', [CustomerController::class, 'getLeadsByDate']);

/**
 * Obtener todos los leads de un usuario por ID.
 *
 * @param int $id ID del usuario.
 * @return \Illuminate\Http\Response
 */
Route::get('/my-leads/{id}', [CustomerController::class, 'getAllMyLeads']);

/**
 * Cambiar el interés de un cliente por ID.
 *
 * @param int $id ID del cliente.
 * @param string $interest Nuevo interés.
 * @return \Illuminate\Http\Response
 */
Route::get('/changeInterest/{id}/{interest}', [CustomerController::class, 'changeInterest']);

/**
 * Insertar una nueva orden.
 *
 * @return \Illuminate\Http\Response
 */
Route::post('/orders', [OrderController::class, 'insertOrder']);

/**
 * Almacenar una nueva orden.
 *
 * @return \Illuminate\Http\Response
 */
Route::post('/order', [OrderController::class, 'store']);

/**
 * Actualizar una orden existente.
 *
 * @return \Illuminate\Http\Response
 */
Route::post('/updateOrder', [OrderController::class, 'update']);

/**
 * Actualizar la comunicación.
 *
 * @return \Illuminate\Http\Response
 */
Route::post('/updateComunication', [ComunicationController::class, 'update']);

/**
 * Insertar nueva comunicación.
 *
 * @return \Illuminate\Http\Response
 */
Route::post('/insertComunication', [ComunicationController::class, 'insertComunication']);

/**
 * Obtener comunicaciones del día por ID.
 *
 * @param int $id ID del cliente.
 * @return \Illuminate\Http\Response
 */
Route::get('/getComunicationsByToday/{id}', [ComunicationController::class, 'getComunicationsByToday']);

/**
 * Obtener comunicación por ID.
 *
 * @param int $id ID de la comunicación.
 * @return \Illuminate\Http\Response
 */
Route::get('/updateComunication/{id}', [ComunicationController::class, 'updateComunication']);

/**
 * Obtener todas las comunicaciones de un cliente.
 *
 * @return \Illuminate\Http\Response
 */
Route::get('/comunications', [ComunicationController::class, 'comunicationsClient']);

/**
 * Insertar un nuevo contrato.
 *
 * @return \Illuminate\Http\Response
 */
Route::post('/contracts', [ContractController::class, 'insertContract']);

/**
 * Eliminar un contrato por ID.
 *
 * @param int $id ID del contrato.
 * @return \Illuminate\Http\Response
 */
Route::delete('/contracts/{id}', [ContractController::class, 'destroy']);

/**
 * Obtener todos los contratos.
 *
 * @return \Illuminate\Http\Response
 */
Route::get('/contracts', [ContractController::class, 'index']);

/**
 * Generar un archivo de contrato por ID.
 *
 * @param int $id ID del pedido.
 * @return \Illuminate\Http\Response
 */
Route::get('/contract-file/{id}', [OrderController::class, 'generateContract']);

/**
 * Generar un PDF de contrato por ID.
 *
 * @param int $id ID del pedido.
 * @return \Illuminate\Http\Response
 */
Route::get('/generateContract/{id}', [OrderController::class, 'generateContractPDF']);

/**
 * Actualizar un contrato existente.
 *
 * @return \Illuminate\Http\Response
 */
Route::post('/updateContract', [ContractController::class, 'updateContract']);

/**
 * Buscar contratos por palabra clave.
 *
 * @param string $word Palabra clave para la búsqueda.
 * @return \Illuminate\Http\Response
 */
Route::get('/searchContracts/{word}', [ContractController::class, 'search']);

/**
 * Obtener una promoción por código.
 *
 * @param string $code Código de promoción.
 * @return \Illuminate\Http\Response
 */
Route::get('/promotions/{code}', [PromotionController::class, 'discount']);

/**
 * Insertar un nuevo código de precio.
 *
 * @return \Illuminate\Http\Response
 */
Route::post('/insertCode', [PriceController::class, 'insertCode']);

/**
 * Obtener el código de promoción.
 *
 * @return \Illuminate\Http\Response
 */
Route::get('/getPromotionCode', [PriceController::class, 'getPromotionCode']);

/**
 * Obtener todos los códigos de promoción.
 *
 * @return \Illuminate\Http\Response
 */
Route::get('/getAllPromotionsCode', [PriceController::class, 'getAllPromotionsCode']);


/**
 * Eliminar una promoción por ID.
 *
 * @param int $id ID de la promoción.
 * @return \Illuminate\Http\Response
 */
Route::delete('/promotions/{id}', [PromotionController::class, 'destroy']);

/**
 * Agregar una notificación a la comunicación.
 *
 * @return \Illuminate\Http\Response
 */
Route::post('/addNotificationComunication', [NotificationController::class, 'addNotificationComunication']);

//Academic Department
/**
 * Obtener actividades por ID.
 *
 * @param int $id ID del cliente.
 * @return \Illuminate\Http\Response
 */
Route::get('/getActivitiesPerId/{id}', [ActivityController::class, 'getActivitiesPerId']);

/**
 * Eliminar una actividad por ID.
 *
 * @param int $id ID de la actividad.
 * @return \Illuminate\Http\Response
 */
Route::get('/deleteActivity/{id}', [ActivityController::class, 'destroy']);

/**
 * Cambiar el estado de una actividad por ID.
 *
 * @param int $id ID de la actividad.
 * @return \Illuminate\Http\Response
 */
Route::get('/changeStatusActivity/{id}', [ActivityController::class, 'changeStatus']);

/**
 * Cambiar el estado de una tarea.
 *
 * @return \Illuminate\Http\Response
 */
Route::post('/changeTaskStatus', [TaskController::class, 'changeStatus']);

/**
 * Insertar tiempo en una tarea.
 *
 * @return \Illuminate\Http\Response
 */
Route::post('/insertTimeTask', [TaskController::class, 'insertTimeTask']);

/**
 * Insertar tiempo de finalización en una tarea.
 *
 * @return \Illuminate\Http\Response
 */
Route::post('/insertEndTimeTask', [TaskController::class, 'insertEndTimeTask']);

/**
 * Insertar tiempos.
 *
 * @return \Illuminate\Http\Response
 */
Route::post('/insertTimes', [TimeController::class, 'insertTimes']);

/**
 * Insertar detalles de la primera reunión.
 *
 * @return \Illuminate\Http\Response
 */
Route::post('/insertDetailsFirstMeeting', [ProgressController::class, 'insertDetailsFirstMeeting']);

/**
 * Actualizar el progreso.
 *
 * @return \Illuminate\Http\Response
 */
Route::post('/updateProgress', [ProgressController::class, 'update']);

/**
 * Eliminar el progreso de una actividad.
 *
 * @return \Illuminate\Http\Response
 */
Route::post('/deleteActivityProgress', [ProgressController::class, 'deleteActivityProgress']);

/**
 * Actualizar el progreso de una actividad por ID.
 *
 * @param int $id ID del progreso.
 * @return \Illuminate\Http\Response
 */
Route::get('/updateActivityProgress/{id}', [ProgressController::class, 'updateActivityProgress']);
/**
 * Rutas para manejar el progreso de actividades.
 */
Route::get('/removeActivityProgress/{id}', [ProgressController::class, 'removeActivityProgress']);

/**
 * Actualiza la calidad de una actividad especificada por su ID.
 * 
 * @param int $id ID de la actividad.
 */
Route::get('/updateQualityActivity/{id}', [ProgressController::class, 'updateQualityActivity']);


/**
 * Elimina la calidad de una actividad especificada por su ID.
 * 
 * @param int $id ID de la actividad.
 */
Route::get('/removeQualityActivity/{id}', [ProgressController::class, 'removeQualityActivity']);
/**
 * Rutas para manejar equipos.
 */
Route::get('/getAllTeams', [TeamController::class, 'index']);
/**
 * Obtiene todos los equipos disponibles.
 */
Route::post('/assignTeam', [TeamController::class, 'assignTeam']);
/**
 * Asigna un equipo a un usuario.
 */
Route::post('/user-team', [TeamController::class, 'updateUserTeam']);

/**
 * Actualiza el equipo asignado a un usuario.
 */
Route::post('/teams', [TeamController::class, 'create']);
/**
 * Crea un nuevo equipo.
 */
Route::delete('/teams/{id}', [TeamController::class, 'destroy']);
/**
 * Elimina un equipo especificado por su ID.
 * 
 * @param int $id ID del equipo.
 */

/**
 * Rutas para manejar notificaciones.
 */
/**
 * Obtiene todas las notificaciones.
 */
Route::get('/notifications/{id}', [NotificationController::class, 'index']);

/**
 * Obtiene todas las notificaciones asociadas a un ID de usuario.
 * 
 * @param int $id ID del usuario.
 */
Route::get('/getAllNotifications/{id}', [NotificationController::class, 'getAllNotifications']);

/**
 * Inserta una notificación de rechazo.
 */
Route::post('/insertReject', [NotificationController::class, 'insertReject']);

/**
 * Obtiene las notificaciones no vistas de un usuario especificado por su ID.
 * 
 * @param int $id ID del usuario.
 */
Route::get('/noseen-notifications/{id}', [NotificationController::class, 'getNoSeenNotifications']);

/**
 * Registra una notificación como vista para un usuario.
 * 
 * @param int $id ID de la notificación.
 */
Route::get('/registerSeen/{id}', [SeenController::class, 'registerSeen']);

/**
 * Rutas para manejar precios.
 */
/**
 * Actualiza los precios de los productos o servicios.
 */
Route::post('/updatePrices', [PriceController::class, 'updatePrices']);

/**
 * Obtiene todas las comisiones registradas.
 */
Route::get('/getAllComissions', [ComissionController::class, 'getAllComissions']);

/**
 * Obtiene todos los perfiles de clientes.
 */
Route::get('/profiles', [CustomerController::class, 'getProfiles']);

/**
 * Busca perfiles de clientes según un término de búsqueda.
 * 
 * @param string $search Término de búsqueda.
 */
Route::get('/profiles-search/{search}', [CustomerController::class, 'searchProfiles']);

/**
 * Rutas para manejar entregas.
 */
/**
 * Obtiene todas las entregas registradas.
 */
Route::get('/deliveries', [DeliveryController::class, 'index']);

/**
 * Obtiene las entregas del mes especificado.
 * 
 * @param string $month Mes en formato YYYY-MM.
 */
Route::get('/deliveries-month/{month}', [DeliveryController::class, 'deliveriesMonth']);

/**
 * Almacena una nueva entrega.
 */
Route::post('/delivery', [DeliveryController::class, 'store']);

/**
 * Obtiene las entregas para una fecha específica.
 * 
 * @param string $date Fecha en formato YYYY-MM-DD.
 */
Route::get('/deliveries-date/{date}', [DeliveryController::class, 'getDeliveriesByDate']);

/**
 * Busca entregas según un término de búsqueda.
 * 
 * @param string $search Término de búsqueda.
 */
Route::get('/deliveries-search/{search}', [DeliveryController::class, 'search']);

/**
 * Actualiza una entrega especificada por su ID.
 * 
 * @param int $id ID de la entrega.
 */
Route::put('/delivery/{id}', [DeliveryController::class, 'update']);

/**
 * Actualiza la información de una entrega especificada por su ID.
 * 
 * @param int $id ID de la entrega.
 */
Route::put('/delivery-info/{id}', [DeliveryController::class, 'updateInfo']);

/**
 * Verifica el estado de una entrega especificada por su ID.
 * 
 * @param int $id ID de la entrega.
 */
Route::get('/check-delivery/{id}', [DeliveryController::class, 'checkDelivery']);

/**
 * Elimina una entrega especificada por su ID.
 * 
 * @param int $id ID de la entrega.
 */
Route::delete('/deliveries/{id}', [DeliveryController::class, 'destroy']);

/**
 * Rutas para manejar observaciones.
 */
/**
 * Almacena una nueva observación.
 */
Route::post('/observation', [ObservationController::class, 'store']);

/**
 * Rutas para manejar contratos.
 */
/**
 * Busca un contrato según un término de búsqueda.
 * 
 * @param string $search Término de búsqueda.
 */
Route::get('/contract/{search}', [ContractController::class, 'searchContract']);
/**
 * Rutas para manejar pagos.
 */
/**
 * Almacena un nuevo pago.
 */
Route::post('/payment', [PaymentsController::class, 'store']);

/**
 * Rutas para manejar permisos de usuario.
 */
/**
 * Crea un nuevo permiso para un usuario.
 */
Route::post('/permissions', [UserController::class, 'createPermission']);

/**
 * Obtiene todos los permisos registrados.
 */
Route::get('/permissions', [UserController::class, 'getPermissions']);

/**
 * Actualiza un permiso especificado por su ID.
 * 
 * @param int $id ID del permiso.
 */
Route::put('/permissions/{id}', [UserController::class, 'updatePermission']);

/**
 * Sincroniza permisos de usuario.
 */
Route::post('/permission-sync', [UserController::class, 'syncPermission']);

/**
 * Sincroniza permisos a un rol específico.
 */
Route::post('/permission-sync-role', [UserController::class, 'syncRole']);

/**
 * Sincroniza permisos a un usuario específico.
 */
Route::post('/permission-sync-user', [UserController::class, 'syncPermissionUser']);

/**
 * Obtiene todos los usuarios académicos.
 */
Route::get('/academic-users', [UserController::class, 'academicUsers']);

/**
 * Obtiene colores para usuarios académicos.
 */
Route::get('/color-academic-users', [UserController::class, 'academicColors']);

/**
 * Rutas para manejar reuniones.
 */
/**
 * Obtiene todas las reuniones registradas.
 */
Route::get('/meetings', [MeetingController::class, 'index']);

/**
 * Almacena una nueva reunión.
 */
Route::post('/meetings', [MeetingController::class, 'store']);

/**
 * Actualiza una reunión especificada por su ID.
 * 
 * @param int $id ID de la reunión.
 */
Route::put('/meetings/{id}', [MeetingController::class, 'update']);

/**
 * Elimina una reunión especificada por su ID.
 * 
 * @param int $id ID de la reunión.
 */
Route::delete('/meetings/{id}', [MeetingController::class, 'destroy']);

/**
 * Completa una reunión especificada por su ID.
 * 
 * @param int $id ID de la reunión.
 */
Route::get('/meetings-complete/{id}', [MeetingController::class, 'complete']);


/**
 * Rutas para manejar proyectos.
 */
/**
 * Obtiene todos los proyectos registrados.
 */
Route::get('/projects', [ProjectController::class, 'index']);

/**
 * Obtiene los sprints de un proyecto especificado por su ID.
 * 
 * @param int $id ID del proyecto.
 */
Route::get('/projects-sprints/{id}', [ProjectController::class, 'sprints']);

/**
 * Obtiene todos los proyectos académicos.
 */
Route::get('/projects-acad', [ProjectController::class, 'getAllProjectsAcad']);

/**
 * Muestra la información de un proyecto especificado por su ID.
 * 
 * @param int $id ID del proyecto.
 */
Route::get('/projects/{id}', [ProjectController::class, 'show']);

/**
 * Almacena un nuevo proyecto.
 */
Route::post('/projects', [ProjectController::class, 'store']);

/**
 * Busca proyectos según un término de búsqueda.
 * 
 * @param string $search Término de búsqueda.
 */
Route::get('/projects-search/{search}', [ProjectController::class, 'search']);

/**
 * Obtiene todos los proyectos de un usuario especificado por su ID.
 * 
 * @param int $id ID del usuario.
 */
Route::get('/projects-user/{id}', [ProjectController::class, 'getMyProjects']);

/**
 * Obtiene todos los proyectos pendientes.
 */
Route::get('/projects-pending', [ProjectController::class, 'projectPendings']);


Route::get('/update-user-project/{userId}/{projectId}', [ProjectController::class, 'updUserProject']);

/**
 * Cambia el estado de un proyecto.
 */
Route::post('/changeStatusProject', [ProjectController::class, 'changeStatus']);

/**
 * Actualiza la calidad de un proyecto especificado por su ID.
 * 
 * @param int $id ID del proyecto.
 */
Route::get('/updateQuality/{id}', [ProjectController::class, 'updateQuality']);

/**
 * Establece un proyecto con la información proporcionada.
 */
Route::post('/setProject', [ProjectController::class, 'setProject']);

/**
 * Elimina un proyecto especificado por su ID.
 * 
 * @param int $id ID del proyecto.
 */
Route::get('/deleteProject/{id}', [ProjectController::class, 'destroy']);

/**
 * Rutas para manejar cotizaciones.
 */
/**
 * Obtiene el embudo de cotizaciones para un cliente especificado por su ID.
 * 
 * @param int $id ID del cliente.
 */
Route::get('/quotations-funnel/{id}', [QuotationController::class, 'getQuotationsFunnel']);
/**
 * Busca cotizaciones según un término de búsqueda.
 * 
 * @param string $search Término de búsqueda.
 */
Route::get('/quotations/search/{search}', [QuotationController::class, 'searchQuotations']);

/**
 * Rutas para manejar asistencia.
 */
/**
 * Almacena una nueva asistencia.
 */
Route::post('/attendance', [AttendanceController::class, 'store']);
/**
 * Obtiene todas las solicitudes de permisos de asistencia.
 */
Route::get('/attendance-permits', [AttendanceController::class, 'getPermissionsRequest']);

/**
 * Muestra la información de una solicitud de permiso especificada por su ID.
 * 
 * @param int $id ID de la solicitud de permiso.
 */
Route::get('/attendance-permits/{id}', [AttendanceController::class, 'show']);

/**
 * Almacena una nueva solicitud de permiso de asistencia.
 */
Route::post('/attendance-permits', [AttendanceController::class, 'attendancePermits']);

/**
 * Acepta una solicitud de permiso especificada por su ID y estado.
 * 
 * @param int $id ID de la solicitud de permiso.
 * @param string $status Estado a establecer (aceptado/rechazado).
 */
Route::get('/accept-permit/{id}/{status}', [AttendanceController::class, 'acceptPermit']);

/**
 * Rechaza una solicitud de permiso especificada por su ID.
 * 
 * @param int $id ID de la solicitud de permiso.
 */
Route::get('/reject-permit/{id}', [AttendanceController::class, 'rejectPermit']);


/**
 * Obtiene las justificaciones del mes de todos los usuarios.
 */

Route::get('/justifications', [JustificationController::class, 'index']);


/**
 * Rutas para manejar archivos de asistencia.
 */
/**
 * Almacena un archivo JSON de asistencia.
 */

Route::post('/json-file', [AttendanceController::class, 'jsonFile']);

/**
 * Almacena un archivo Excel de asistencia.
 */
Route::post('/excel-file', [AttendanceController::class, 'excelFile']);

/**
 * Almacena un nuevo archivo.
 */
Route::post('/files', [FileController::class, 'store']);

/**
 * Almacena archivos asociados a un proyecto.
 */
Route::post('/files-project', [FileController::class, 'filesProject']);

/**
 * Muestra la información de un archivo especificado por su ID.
 * 
 * @param int $id ID del archivo.
 */
Route::get('/files/{id}', [FileController::class, 'show']);

/**
 * Elimina un archivo especificado por su ID.
 * 
 * @param int $id ID del archivo.
 */
Route::delete('/files/{id}', [FileController::class, 'destroy']);


/**
 * Rutas para manejar horarios.
 */
/**
 * Muestra la información de un horario especificado por su ID.
 * 
 * @param int $id ID del horario.
 */
Route::get('/schedules/{id}', [ScheduleController::class, 'show']);

/**
 * Almacena un nuevo horario.
 */
Route::post('/schedules', [ScheduleController::class, 'store']);

/**
 * Actualiza un horario especificado por su ID.
 * 
 * @param int $id ID del horario.
 */
Route::put('/schedules/{id}', [ScheduleController::class, 'update']);

/**
 * Actualiza el tipo de un horario especificado por su ID.
 * 
 * @param int $id ID del horario.
 */
Route::put('/schedules-type/{id}', [ScheduleController::class, 'updateType']);

/**
 * Obtiene horarios según un día específico.
 */
Route::post('/schedules-day', [ScheduleController::class, 'schedulesByDay']);

/**
 * Elimina todos los horarios asociados a un ID específico.
 * 
 * @param int $id ID de los horarios a eliminar.
 */
Route::delete('/schedules-all/{id}', [ScheduleController::class, 'destroyAll']);

/**
 * Rutas para manejar clientes.
 */
/**
 * Obtiene todos los clientes registrados.
 */
Route::get('/clients', [CustomerController::class, 'clients']);


/**
 * Rutas para manejar comprobantes de pago.
 */
/**
 * Muestra la información de un comprobante de pago especificado por su ID.
 * 
 * @param int $id ID del comprobante de pago.
 */
Route::get('/payment-proof/{id}', [VoucherController::class, 'show']);

/**
 * Actualiza el acceso de un usuario especificado por su ID.
 * 
 * @param int $id ID del usuario.
 */
Route::put('/access/{id}', [UserController::class, 'access']);

/**
 * Rutas para manejar propiedades de proyectos.
 */
/**
 * Almacena una nueva propiedad.
 */
Route::post('/properties', [PropertiesController::class, 'store']);
/**
 * Actualiza una propiedad existente.
 */
Route::put('/properties', [PropertiesController::class, 'update']);

/* //Rutas para CHatbot
 
Route::get('/webhook',[AichatController::class,'webhook']);
Route::post('/webhook',[AichatController::class,'recibe']);
 */

/**
 * Rutas para manejar propiedades.
 */
/**
 * Muestra la información de una propiedad especificada por su ID.
 * 
 * @param int $id ID de la propiedad.
 */
Route::get('/properties/{id}', [PropertiesController::class, 'show']);

/**
 * Obtiene propiedades asociadas a proyectos.
 */
Route::get('/projects-properties', [PropertiesController::class, 'properties']);

/**
 * Rutas para manejar vouchers.
 */
/**
 * Obtiene todos los vouchers registrados.
 */
Route::get('/vouchers', [VoucherController::class, 'index']);
/**
 * Almacena un nuevo voucher.
 */
Route::post('/voucher', [VoucherController::class, 'store']);

/**
 * Rutas para manejar vouchers externos.
 */
/**
 * Obtiene todos los vouchers externos registrados.
 */

Route::get('/external-voucher', [ExternalVoucherController::class, 'index']);
/**
 * Almacena un nuevo voucher externo.
 */
Route::post('/external-voucher', [ExternalVoucherController::class, 'store']);

/**
 * Rutas para manejar chats.
 */
/**
 * Muestra el chat especificado por su ID.
 * 
 * @param int $id ID del chat.
 */
Route::get('/chats/{id}', [ChatController::class, 'show']);
/**
 * Obtiene los contactos de un chat especificado por su ID.
 * 
 * @param int $id ID del chat.
 */
Route::get('/contacts/{id}', [ChatController::class, 'contacts']);
/**
 * Inicia un nuevo mensaje en el chat especificado por su ID.
 * 
 * @param int $id ID del chat.
 */
Route::get('/new-chat/{id}', [ChatController::class, 'newMessage']);

/**
 * Rutas para manejar productos académicos.
 */
/**
 * Obtiene todos los productos académicos registrados.
 */
Route::get('/academic-products', [AcademicProductController::class, 'index']);

/**
 * Rutas para manejar actividades asignadas.
 */
/**
 * Almacena una nueva actividad asignada.
 */
Route::post('/assigned-activity', [AssignedActivityController::class, 'store']);
/**
 * Actualiza una actividad asignada especificada por su ID.
 * 
 * @param int $id ID de la actividad asignada.
 */
Route::put('/assigned-activity/{id}', [AssignedActivityController::class, 'update']);
/**
 * Habilita un proyecto especificado por su ID.
 * 
 * @param int $id ID del proyecto.
 */
Route::get('/enable-project/{id}', [ProjectController::class, 'enable']);
/**
 * Busca proyectos según un término de búsqueda.
 * 
 * @param string $search Término de búsqueda.
 */
Route::get('/search-projects/{search}', [ProjectController::class, 'searchProject']);

/**
 * Rutas para manejar actualización de horarios.
 */
/**
 * Actualiza la hora de un horario especificado por su ID.
 * 
 * @param int $id ID del horario.
 */
Route::put('/update-hour/{id}', [ScheduleController::class, 'updateHour']);
/**
 * Actualiza los tiempos de los horarios.
 */
Route::post('/update-times', [ScheduleController::class, 'updateTimes']);
/**
 * Actualiza los tiempos de los horarios para la siguiente semana.
 */
Route::post('/update-times-next', [ScheduleController::class, 'updateNextTimes']);

/**
 * Rutas para manejar justificaciones.
 */
/**
 * Almacena una nueva justificación.
 */

Route::post('/justification', [JustificationController::class, 'store']);

/**
 * Obtiene justificaciones del mes actual.
 */
Route::get('/justifications', [JustificationController::class, 'justificationsPerMonth']);

/**
 * Rutas para manejar fotos de perfil.
 */
/**
 * Actualiza la foto de perfil de un usuario.
 */
Route::post('/profile-photo', [UserController::class, 'updatePhoto']);

/**
 * Rutas para manejar órdenes.
 */
/**
 * Obtiene todas las órdenes registradas.
 */
Route::get('/orders', [OrderController::class, 'index']);

/**
 * Rutas para manejar contratos de clientes.
 */
/**
 * Elimina un contrato de cliente especificado por su ID de cliente y cotización.
 * 
 * @param int $customerId ID del cliente.
 * @param int $quotationId ID de la cotización.
 */
Route::get('/customer-contract/{customerId}/{quotationId}', [ContractController::class, 'deleteCustomer']);

/**
 * Rutas para manejar valores de asistencia en gráficos.
 */
/**
 * Obtiene los valores de asistencia para gráficos.
 */
Route::get('/chart-attendance-values', [AttendanceController::class, 'chartValues']);

//Email
/**
 * Rutas para manejar emails.
 */
/**
 * Envía un email de bienvenida.
 */
Route::post('/send-welcome-email', [EmailController::class, 'sendWelcomeEmail']);

/**
 * Rutas para manejar actividades asignadas.
 */
/**
 * Almacena una nueva actividad asignada.
 */
Route::post('/assigned-activity', [AssignedActivityController::class, 'store']);
/**
 * Muestra las actividades asignadas para revisión especificadas por su ID.
 * 
 * @param int $id ID de la actividad asignada.
 */
Route::get('/assigned-activities-revision/{id}', [AssignedActivityController::class, 'revision']);
/**
 * Actualiza los puntos de una actividad asignada especificada por su ID.
 * 
 * @param int $id ID de la actividad asignada.
 * @param int $points Puntos a asignar.
 */
Route::get('/assigned-activity-points/{id}/{points}', [AssignedActivityController::class, 'points']);
/**
 * Actualiza la prioridad de una actividad asignada especificada por su ID.
 * 
 * @param int $id ID de la actividad asignada.
 * @param int $priority Prioridad a asignar.
 */
Route::get('/assigned-activity-priority/{id}/{priority}', [AssignedActivityController::class, 'priority']);
/**
 * Obtiene la información de una actividad asignada en formato kanban especificada por su ID.
 * 
 * @param int $id ID de la actividad asignada.
 */
Route::get('/assigned-activity-kanban/{id}', [AssignedActivityController::class, 'kanban']);
/**
 * Actualiza el nombre de una actividad asignada especificada por su ID.
 * 
 * @param int $id ID de la actividad asignada.
 * @param string $name Nuevo nombre de la actividad.
 */
Route::get('/assigned-activity-name/{id}/{name}', [AssignedActivityController::class, 'updateName']);
/**
 * Actualiza el usuario asignado a una actividad especificada por su ID.
 * 
 * @param int $id ID de la actividad asignada.
 * @param int $uid ID del nuevo usuario.
 */
Route::get('/assigned-activity-user/{id}/{uid}', [AssignedActivityController::class, 'updateUser']);
/**
 * Actualiza la fecha límite de una actividad asignada.
 */
Route::put('/assigned-activity-limit-date', [AssignedActivityController::class, 'updEndDate']);
/**
 * Elimina una actividad asignada especificada por su ID.
 * 
 * @param int $id ID de la actividad asignada.
 */
Route::delete('/assigned-activity/{id}', [AssignedActivityController::class, 'destroy']);

/**
 * Rutas para manejar actividades aprobadas.
 */
/**
 * Aprueba actividades especificadas por su ID.
 * 
 * @param int $id ID de la actividad asignada.
 */
Route::get('/approve-activities/{id}', [AssignedActivityController::class, 'approve']);
/**
 * Obtiene las actividades aprobadas especificadas por su ID.
 * 
 * @param int $id ID de la actividad asignada.
 */
Route::get('/approved-activities/{id}', [AssignedActivityController::class, 'approved']);
/**
 * Obtiene los puntos acumulados por un equipo especificado por su ID.
 * 
 * @param int $id ID del equipo.
 */
Route::get('/points-by-team/{id}', [AssignedActivityController::class, 'pointsByTeam']);

/**
 * Rutas para manejar entregas.
 */
/**
 * Procesa un sprint especificado por su ID de entrega y proyecto.
 * 
 * @param int $pid ID del proyecto.
 * @param int $id ID de la entrega.
 */
Route::get('/process-sprint/{pid}/{id}', [DeliveryController::class, 'processSprint']);
/**
 * Busca tareas según un término de búsqueda.
 * 
 * @param string $name Término de búsqueda.
 */
Route::get('/search-task/{name}', [TaskController::class, 'searchTask']);

/**
 * Rutas para manejar títulos y estados de proyectos.
 */
/**
 * Actualiza el título de un proyecto especificado por su ID.
 * 
 * @param int $id ID del proyecto.
 * @param string $name Nuevo título del proyecto.
 */
Route::get('/update-project-title/{id}/{name}', [ProjectController::class, 'updateProjectTitle']);
/**
 * Actualiza el estado de un proyecto especificado por su ID.
 * 
 * @param int $id ID del proyecto.
 * @param string $status Nuevo estado del proyecto.
 */
Route::get('/update-project-status/{id}/{status}', [ProjectController::class, 'updateProjectStatus']);

/**
 * Rutas para manejar formularios.
 */
/**
 * Almacena un nuevo formulario.
 */
Route::post('/forms', [FormController::class, 'store']);
/**
 * Actualiza un formulario especificado por su ID.
 * 
 * @param int $id ID del formulario.
 */
Route::put('/forms/{id}', [FormController::class, 'update']);
/**
 * Obtiene todos los formularios registrados.
 */
Route::get('/forms', [FormController::class, 'index']);

/**
 * Rutas para manejar actividades asignadas.
 */
/**
 * Rechaza una actividad asignada.
 */
Route::post('/reject-assigned-activity', [AssignedActivityController::class, 'reject']);

/**
 * Rutas para manejar archivos.
 */
/**
 * Almacena un archivo de archivo.
 */
Route::post('/file-archive', [FileController::class, 'fileArchive']);
/**
 * Almacena un archivo de publicación.
 */
Route::post('/file-post', [FileController::class, 'filePost']);
/**
 * Habilita un archivo de publicación especificado por su ID.
 * 
 * @param int $id ID del archivo.
 */
Route::get('/enable-file/{id}', [FileController::class, 'enableFilePost']);
/**
 * Elimina un post especificado por su ID.
 * 
 * @param int $id ID del post.
 */
Route::delete('/post/{id}', [PostController::class, 'destroy']);

/**
 * Rutas para manejar cuentas bancarias.
 */
/**
 * Obtiene todas las cuentas bancarias registradas.
 */
Route::get('/bank-accounts', [BankAccountController::class, 'index']);

/**
 * Rutas para manejar cotizaciones.
 */
/**
 * Filtra cotizaciones.
 */
Route::get('/filter-quotations', [QuotationController::class, 'filterQuotations']);
/**
 * Filtra cotizaciones según fechas.
 */
Route::post('/filter-dates', [QuotationController::class, 'filterDates']);
/**
 * Obtiene clientes de Lobo.
 */
Route::get('/customers-lobo', [QuotationController::class, 'customersLobo']);

/**
 * Rutas para manejar datos de dirección.
 */
/**
 * Obtiene datos de dirección.
 */
Route::get('/addressData', [DepartmentController::class, 'addressData']);

/**
 * Rutas para manejar vouchers de cotización.
 */
/**
 * Obtiene vouchers de cotización.
 */
Route::get('/quotation-vouchers', [QuotationController::class, 'quotationVouchers']);
/**
 * Cambia el estado de un voucher de cotización especificado por su ID y estado.
 * 
 * @param string $voucherStatus Estado a establecer.
 * @param int $voucherId ID del voucher.
 */
Route::get('/status-voucher/{voucherStatus}/{voucherId}', [QuotationController::class, 'statusVoucher']);
/**
 * Cambia el color de un evento de entrega especificado por su ID de entrega y usuario.
 * 
 * @param int $deliveryId ID de la entrega.
 * @param int $userId ID del usuario.
 */
Route::get('/change-color-event/{deliveryId}/{userId}', [DeliveryController::class, 'changeColorEvent']);

/**
 * Rutas para manejar in formación de postventas.
 */
/**
 * Obtiene todos los clientes que son clientes.
 * 
 */
Route::get('/post-sales', [CustomerController::class, 'postSales']);

/**
 * Obtiene informacion para los selects del form de postventas.
 * 
 */
Route::get('/selects-info', [CustomerController::class, 'selectsInfo']);
/**
 * Almacena la información del form de postventas.
 * 
 */
Route::post('/form-sales-posts', [CustomerController::class, 'registerPostsales']);
/**
 * Exporta la informacion de postventas en un archivo XLSX.
 * 
 */

Route::get('/export-post-sales', [CustomerController::class, 'export']);
