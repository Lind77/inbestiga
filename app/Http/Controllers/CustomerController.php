<?php

namespace App\Http\Controllers;

use App\Events\NewLead;
use App\Exports\CustomersExport;
use App\Models\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Academic_situation;
use App\Models\Comission;
use App\Models\Comunication;
use App\Models\Comunication_channel;
use App\Models\Contract;
use App\Models\Contract_mode;
use App\Models\Detail;
use App\Models\Hire_factor;
use App\Models\Marketing_source;
use App\Models\NewProduct;
use App\Models\Notification;
use App\Models\Origin;
use App\Models\Participation;
use App\Models\Post_form;
use App\Models\Professional_status;
use App\Models\Quotation;
use App\Models\Seen;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Class CustomerController
 *
 * Controlador para manejar las operaciones relacionadas con los clientes.
 * Este controlador incluye métodos para crear, leer, actualizar y eliminar
 * clientes, así como para gestionar su estado y comisiones.
 *
 * @package App\Http\Controllers
 */
class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::with(['comunications', 'quotations', 'quotations.order', 'user', 'province', 'province.department', 'province.department.provinces'])->orderBy('updated_at', 'desc')->take(10)->get();
        return response()->json($customers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCustomerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->get('cell') != null) {
            $request->validate([
                'cell' => 'unique:customers|max:11|min:11'
            ]);
        }

        $verification = $this->verifyCustomer($request->get('name'), $request->get('cell'));
        if (!is_bool($verification)) {
            return response()->json($verification, 400);
        } else {
            $time = strtotime($request->get('next_management'));
            $date = date('Y-m-d', $time);
            $hour = date('H:i:s', $time);

            $customer = Customer::create([
                'name' => $request->get('name'),
                'cell' => $request->get('cell'),
                'email' => $request->get('email'),
                'university' => $request->get('university'),
                'career' => $request->get('career'),
                'status' => $request->get('status'),
                'dni' => $request->get('dni'),
                'address' => $request->get('address'),
                'userregister_id' => $request->get('userregister_id'),
                /* 'birth_date' => $request->get('birth_date'), */
                'province_id' => $request->get('province_id')
            ]);
            return response()->json([
                'msg' => 'success'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = Customer::with(['quotations', 'quotations.contract', 'quotations.contract.payments', 'quotations.contract.projects', 'quotations.contract.projects.deliveries', 'quotations.order', 'quotations.order.payments', 'quotations.details', 'quotations.details.product', 'quotations.customers', 'province'])->find($id);
        return response()->json($customer);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCustomerRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $customer = Customer::find($id);

        $customer->update([
            'name' => $request->get('name'),
            'cell' => $request->get('cell'),
            'university' => $request->get('university'),
            'career' => $request->get('career'),
            'email' => $request->get('email'),
            'dni' => $request->get('dni'),
            'address' => $request->get('address'),
            'birth_date' => $request->get('birth_date') ?? null,
            'province_id' => $request->get('province_id'),
            'gender' => $request->get('gender'),
            'type' => $request->get('type')
        ]);

        return response()->json([
            'msg' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customer::find($id);
        $customer->delete();
        return response()->json([
            'msg' => 'deleted'
        ]);
    }
    /**
     * Update the customer's grade/status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateCustomerGrade(Request $request)
    {

        $status = $request->get('status');
        $customer = Customer::find($request->get('customer_id'));

        if ($status < 3) {
            $customer->update([
                'status' => $request->get('status')
            ]);
        } else if ($status >= 3) {
            $customer->update([
                'status' => $request->get('status')
            ]);

            $user = User::find($request->get('user_id'));

            $comissionData = [
                'customer_id' => $customer->id,
                'referal' => $user->name,
                'user_id' => $request->get('user_id')
            ];

            switch ($request->get('status')) {
                case 3:
                    $comissionData['concept'] = 'Obtención de datos';
                    $comissionData['percent'] = 2;
                    break;
                case 4:
                    $comissionData['concept'] = 'Obtención de necesidades específicas';
                    $comissionData['percent'] = 8;
                    break;
                case 5:
                    $comissionData['concept'] = 'Cotización';
                    $comissionData['percent'] = 5;
                    break;
                case 6:
                    $comissionData['concept'] = 'Explicación de la cotización';
                    $comissionData['percent'] = 5;
                    break;
                case 7:
                    $comissionData['concept'] = 'Explicación de la experiencia';
                    $comissionData['percent'] = 15;
                    break;
                case 8:
                    $comissionData['concept'] = 'Seguimientos';
                    $comissionData['percent'] = 15;
                    break;
                case 9:
                    $comissionData['concept'] = 'Cierre no pagado';
                    $comissionData['percent'] = 15;
                    break;
                case 10:
                    $comissionData['concept'] = 'Seguimiento de cierre';
                    $comissionData['percent'] = 10;
                    break;
                case 11:
                    $comissionData['concept'] = 'Gestión Documental';
                    $comissionData['percent'] = 2;
                    break;
            }

            $comission = Comission::where('customer_id', $request->get('customer_id'))->where('user_id', $request->get('user_id'))->where('concept', $comissionData['concept'])->first();

            if (!$comission) {
                $newComission = Comission::create($comissionData);
            }
        }

        $oldStatus = intval($request->get('status')) - 1;

        $eleventhCustomer = Customer::where('status', $oldStatus)->orderBy('updated_at', 'desc')->offset(10)->first();


        $customer->update([
            'status' => $request->get('status')
        ]);
        return response()->json([
            'msg' => 'success',
            'eleventhCustomer' => $eleventhCustomer
        ]);
    }
    /**
     * Set the customer status to standby.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function standByCustomer($id)
    {

        $customer = Customer::find($id);
        $customer->update([
            'status' => 0
        ]);

        return response()->json([
            'msg' => 'success'
        ]);
    }
    /**
     * Get all customers on standby.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllStandByCustomers()
    {
        $customers = Customer::where('status', '=', null)->with(['project', 'project.product'])->get();
        return response()->json($customers);
    }
    /**
     * Reactivate a customer by setting their status to reactive.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reactivateCustomer($id)
    {
        $customer = Customer::find($id);
        $customer->update([
            'status' => 1
        ]);
        return response()->json([
            'msg' => 'success'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateDniCustomer(Request $request)
    {

        $customer = Customer::find($request->get('id_customer'));
        $customer->update([
            'dni' => $request->get('dni'),
            'address' => $request->get('address')
        ]);

        return response()->json($customer);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllPreleads()
    {
        $totalCustomers = collect();

        for ($i = 1; $i <= 4; $i++) {
            $customers = Customer::with(['comunications' => function ($query) {
                $query->orderBy('id', 'desc')->first();
            }, 'quotations', 'quotations.order', 'user'])->where('status', $i)->orderBy('updated_at', 'desc')->take(10)->get();

            $totalCustomers = $totalCustomers->merge($customers);
        }

        return response()->json($totalCustomers);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllLeads($id)
    {
        $customers = Customer::with(['province', 'province.department', 'province.department.provinces'])->where('user_id', $id)->orderBy('updated_at', 'desc')->take(10)->get();

        $quotations = Quotation::with('customers')->whereHas('customers', function ($query) use ($id) {
            $query->where('user_id', $id);
        })
            ->orderBy('updated_at', 'desc')->take(10)->get();


        $contracts = Contract::with(['quotation', 'quotation.customers'])
            ->whereHas('quotation.customers', function ($query) use ($id) {
                $query->where('user_id', $id);
            })
            ->orderBy('updated_at', 'desc')
            ->take(10)
            ->get();

        return response()->json([
            'customers' => $customers,
            'quotations' => $quotations,
            'contracts' => $contracts
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function assignOwner(Request $request)
    {
        $customer = Customer::find($request->get('customer_id'));
        $customer->update([
            'user_id' => $request->get('seller_selected'),
            'status' => 4,
            'needs' => $request->get('needs')
        ]);

        $user = User::find($request->get('user_id'));
        $nameReferal = $user->name;

        $comission = Comission::create([
            'customer_id' => $customer->id,
            'concept' => 'Obtención de necesidades específicas',
            'percent' => 8,
            'referal' => $nameReferal,
            'user_id' => $request->get('user_id')
        ]);

        /* $notification = Notification::create([
            'emisor_id' => $request->get('user_id'),
            'content' => 'te asignó un nuevo lead ' . $customer->name,
            'type' => 1
        ]);

        $seen = Seen::create([
            'user_id' => $request->get('seller_selected'),
            'notification_id' => $notification->id,
            'seen' => 0
        ]);

        broadcast(new NewLead($customer)); */

        return response()->json([
            'msg' => 'success'
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function searchCustomers($search)
    {
        $customers = Customer::with(['user', 'comunications', 'quotations'])->where('name', 'like', '%' . $search . '%')->orWhere('cell', 'like', '%' . $search . '%')->orWhere('career', 'like', '%' . $search . '%')->orWhere('university', 'like', '%' . $search . '%')->take(10)->get();
        return response()->json([
            'customers' => $customers,
            'quotations' => $customers->map->only(['quotations'])
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function searchPreleads($search)
    {
        $customers = Customer::with('comunications')->where(function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('cell', 'like', '%' . $search . '%');
        })->where('status', '<=', 4)->get();
        return response()->json($customers);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request,$cell
     * @return \Illuminate\Http\Response
     */
    private function verifyCustomer($name, $cell)
    {
        if ($name != null) {
            $searchByName = Customer::where('name', 'like', '%' . $name . '%')->get();

            $cantResName = count($searchByName);

            if ($cantResName == 0) {
                $verifiedByName = true;
            } else {
                return $searchByName;
            }
        } else {
            $verifiedByName = true;
        }


        if ($cell != null) {
            $searchByCell = Customer::where('cell', 'like', '%' . $cell . '%')->get();

            $cantResCell = count($searchByCell);

            if ($cantResCell == 0) {
                $verifiedByCell = true;
            } else {
                return response()->json([
                    'msg' => 'Se han encontrado coincidencias con este celular'
                ]);
            }
        } else {
            $verifiedByCell = true;
        }

        if ($verifiedByCell && $verifiedByName) {
            $verifiedTotal = true;
        } else {
            $verifiedTotal = false;
        }


        return $verifiedTotal;
    }
    /**
     * Obtiene los leads (clientes) asociados a una fecha específica.
     *
     * @param  string  $date  La fecha para filtrar los leads.
     * @return \Illuminate\Http\Response
     */
    public function getLeadsByDate($date)
    {
        $customers = Customer::with(['comunications', 'quotations', 'user'])->whereHas('comunications', function ($query) use ($date) {
            $query->where('next_management', $date);
        })->get();
        return response()->json($customers);
    }
    /**
     * Obtiene todos los leads asociados a un usuario específico.
     *
     * @param  int  $id  El ID del usuario.
     * @return \Illuminate\Http\Response
     */
    public function getAllMyLeads($id)
    {
        $today = date('Y-m-d');
        $customersToday = Customer::where('user_id', $id)->where('created_at', 'like', '%' . $today . '%')->orderBy('id', 'desc')->get();

        $customers = Customer::where('user_id', $id)->orderBy('id', 'desc')->get();

        $clients = Customer::where('status', 11)->get();

        $leads = Customer::where('status', '>', 4)->where('status', '<', 11)->get();
        $countLeads = $leads->count();
        $leadsFirstTen = Customer::where('status', '>', 4)->take(10);

        $standBy = Customer::where('status', 0)->orderBy('name', 'asc')->get();

        return response()->json([
            'customers' => $customers,
            'customersToday' => $customersToday,
            'clients' => $clients,
            'standBy' => $standBy,
            'countLeads' => $countLeads,
            'leadsFirstTen' => $leadsFirstTen
        ]);
    }
    /**
     * Cambia el interés de una cotización específica.
     *
     * @param  int  $quotationId  El ID de la cotización.
     * @param  mixed  $interest  El nuevo interés a establecer.
     * @return \Illuminate\Http\Response
     */
    public function changeInterest($quotationId, $interest)
    {
        $quotation = Quotation::find($quotationId);

        $quotation->update([
            'interest' => $interest
        ]);

        return response()->json($quotation);
    }
    /**
     * Busca clientes y sus comunicaciones basándose en un término de búsqueda.
     *
     * @param  string  $search  El término de búsqueda.
     * @return \Illuminate\Http\Response
     */
    public function searchCustomersComunications($search)
    {
        $customers = Customer::with(['user', 'comunications'])->where('name', 'like', '%' . $search . '%')->orWhere('cell', 'like', '%' . $search . '%')->get();
        return response()->json($customers);
    }
    /**
     * Actualiza la próxima comunicación de un cliente.
     *
     * @param  int  $id  El ID de la comunicación.
     * @param  \Illuminate\Http\Request  $request  La solicitud que contiene los nuevos datos.
     * @return \Illuminate\Http\Response
     */
    public function updateNextComunication($id, Request $request)
    {
        $dateTime = date_create($request->get('newDateTime'));
        $comunication = Comunication::find($id);
        $comunication->update([
            'next_management' => date_format($dateTime, 'Y-m-d'),
            'time' => date_format($dateTime, 'H:i:s')
        ]);
        return response()->json([
            'msg' => 'Successfully updated',
            'newComunication' => $comunication
        ]);
    }
    /**
     * Obtiene todos los perfiles de clientes con un estatus específico.
     *
     * @return \Illuminate\Http\Response
     */
    public function getProfiles()
    {
        /* $customers = Customer::where('status', 11)->with(['comunications', 'quotations' => function ($query) {
            $query->latest('id');
        }, 'quotations.order', 'quotations.contract', 'quotations.order.properties', 'quotations.contract.properties', 'quotations.details', 'quotations.details.product'])->orderBy('id', 'desc')->take(8)->get(); */
        $quotations =  Quotation::where('status', 11)->whereHas('contract')->with(['customers', 'contract', 'contract.properties', 'contract.projects'])->orderBy('updated_at', 'desc')->paginate(8);

        return response()->json($quotations);
    }
    /**
     * Busca perfiles de clientes basándose en un término de búsqueda.
     *
     * @param  string  $search  El término de búsqueda.
     * @return \Illuminate\Http\Response
     */
    public function searchProfiles($search)
    {
        $quotations = Quotation::where('status', 11)
            ->where(function ($query) {
                $query->whereHas('contract')
                    ->orWhereHas('order');
            })
            ->whereHas('customers', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')->orWhere('cell', 'like', '%' . $search . '%');
            })
            ->with(['contract', 'customers', 'contract.projects', 'contract.properties'])
            ->orderBy('id', 'desc')
            ->paginate(8);

        return response()->json($quotations);
    }
    /**
     * Busca clientes creados en una fecha específica.
     *
     * @param  string  $date  La fecha para filtrar los clientes.
     * @return \Illuminate\Http\Response
     */
    public function searchCustomersByDate($date)
    {
        $customers = Customer::with(['user', 'comunications'])->where('status', '>', 0)->where('status', '<=', 3)->where('created_at', 'like', '%' . $date . '%')->get();
        return response()->json($customers);
    }
    /**
     * Busca un cliente por su ID específico.
     *
     * @param  int  $id  El ID del cliente.
     * @return \Illuminate\Http\Response
     */
    public function searchCustomersById($id)
    {
        $customer = Customer::with([
            'user:id,name,email', // Selecciona solo los campos necesarios
            'comunications',
            'quotations.customers:id,name',
            'quotations.contract.projects',
            'quotations.contract.payments',
            'quotations.contract.external_vouchers.images',
            'quotations.contract.projects.user:id,name,calendly_user'
        ])->find($id);

        if (!$customer) {
            return response()->json(['error' => 'Customer not found'], 404);
        }

        return response()->json($customer);
    }
    /**
     * Obtiene todos los clientes con un estatus de cliente.
     *
     * @return \Illuminate\Http\Response
     */
    public function clients()
    {
        $customers = Customer::with(['quotations', 'quotations.details', 'quotations.details.product', 'quotations.order', 'quotations.order.payments', 'quotations.contract.payments'])->where('status', 11)->get();
        return response()->json($customers);
    }
    /**
     * Filtra clientes por ID de usuario.
     *
     * @param  int  $user_id  El ID del usuario para filtrar clientes.
     * @return \Illuminate\Http\Response
     */
    public function filterCustomer($user_id)
    {
        $customers = Customer::where('user_id', $user_id)->with(['comunications', 'quotations', 'quotations.order', 'user'])->orderBy('updated_at', 'desc')->take(10)->get();
        return response()->json($customers);
    }

    public function postSales()
    {
        /* $contract = Contract::with(['quotation', 'quotation.customers' => function ($query) {
            $query->whereColumn('customers.id', 'quotation.customer_id');
        }])->where('registration_date', 'like', '%' . date('Y-m') . '%')->get(); */

        $customers = Customer::with(['quotations' => function ($query) {
            $query->orderBy('id', 'desc')->get();
        }, 'quotations.contract', 'province'])->where('password', '!=', null)->whereHas('quotations.contract', function ($q) {
            $q->where('registration_date', 'like', '%' . date('Y-m') . '%');
        })->orderBy('updated_at', 'desc')->get();

        return response()->json($customers);
    }

    public function selectsInfo()
    {
        $comunicationChanels = Comunication_channel::all();
        $mktSources = Marketing_source::all();
        $hireFactors = Hire_factor::all();
        $contractModes = Contract_mode::all();
        $academicSituations = Academic_situation::all();
        $professionalStatuses = Professional_status::all();
        $participations = Participation::all();

        return response()->json([
            'comunicationChanels' => $comunicationChanels,
            'mktSources' => $mktSources,
            'hireFactors' => $hireFactors,
            'contractModes' => $contractModes,
            'academicSituations' => $academicSituations,
            'professionalStatuses' => $professionalStatuses,
            'participations' => $participations
        ]);
    }

    public function registerPostsales(Request $request)
    {
        $post_form = Post_form::where('contract_id', $request->get('contract_id'))->first();

        if (!$post_form) {
            $post_form = Post_form::create([
                'contract_id' => $request->get('contract_id'),
                'comunication_channel_id' => $request->get('comunicationChanelId'),
                'marketing_source_id' => $request->get('mktSourceId'),
                'hire_factor_id' => $request->get('hireFactorId'),
                'contract_mode_id' => $request->get('contractModeId'),
                'academic_situation_id' => $request->get('academicSituationId'),
                'professional_status_id' => $request->get('professionalStatusId'),
                'participation_id' => $request->get('participationId'),
                'study_place_id' => $request->get('studyPlaceId'),
            ]);
        } else {
            $post_form->update([
                'comunication_channel_id' => $request->get('comunicationChanelId'),
                'marketing_source_id' => $request->get('mktSourceId'),
                'hire_factor_id' => $request->get('hireFactorId'),
                'contract_mode_id' => $request->get('contractModeId'),
                'academic_situation_id' => $request->get('academicSituationId'),
                'professional_status_id' => $request->get('professionalStatusId'),
                'participation_id' => $request->get('participationId'),
                'study_place_id' => $request->get('studyPlaceId'),
            ]);
        }

        return response()->json([
            'msg' => 'Successfully updated'
        ]);
    }

    public function export()
    {
        return Excel::download(new CustomersExport, 'customers.xlsx');
    }
}
