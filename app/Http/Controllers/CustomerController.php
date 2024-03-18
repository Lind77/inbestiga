<?php

namespace App\Http\Controllers;

use App\Events\NewLead;
use App\Models\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Comission;
use App\Models\Comunication;
use App\Models\Detail;
use App\Models\NewProduct;
use App\Models\Notification;
use App\Models\Origin;
use App\Models\Quotation;
use App\Models\Seen;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::with(['comunications', 'quotations', 'quotations.order'])->orderBy('updated_at', 'desc')->take(10)->get();
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
        if ($verification[0]) {
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
                'userregister_id' => $request->get('userregister_id')
            ]);
            return response()->json([
                'msg' => 'success'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = Customer::with(['quotations', 'quotations.contract', 'quotations.contract.payments', 'quotations.contract.projects', 'quotations.contract.projects.deliveries', 'quotations.order', 'quotations.order.payments', 'quotations.details', 'quotations.details.product', 'quotations.customers'])->find($id);
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
     * @param  \App\Models\Customer  $customer
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
            'address' => $request->get('address')
        ]);

        return response()->json([
            'msg' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
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

    public function getAllStandByCustomers()
    {
        $customers = Customer::where('status', '=', null)->with(['project', 'project.product'])->get();
        return response()->json($customers);
    }

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

    public function updateDniCustomer(Request $request)
    {

        $customer = Customer::find($request->get('id_customer'));
        $customer->update([
            'dni' => $request->get('dni'),
            'address' => $request->get('address')
        ]);

        return response()->json($customer);
    }

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

    public function getAllLeads()
    {

        $totalCustomers = collect();

        for ($i = 5; $i <= 11; $i++) {
            $customers = Customer::with(['origin', 'user', 'comunications' => function ($query) {
                $query->latest('id');
            }, 'quotations' => function ($secondQuery) {
                $secondQuery->latest('id');
            }, 'quotations.order', 'quotations.contract', 'quotations.details', 'quotations.details.product'])->where('status', $i)->orderBy('updated_at', 'desc')->take(10)->get();

            $totalCustomers = $totalCustomers->merge($customers);
        }

        return response()->json($totalCustomers);
    }

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

        $notification = Notification::create([
            'emisor_id' => $request->get('user_id'),
            'content' => 'te asignó un nuevo lead ' . $customer->name,
            'type' => 1
        ]);

        $seen = Seen::create([
            'user_id' => $request->get('seller_selected'),
            'notification_id' => $notification->id,
            'seen' => 0
        ]);

        broadcast(new NewLead($customer));


        return response()->json([
            'msg' => 'success'
        ]);
    }

    public function searchCustomers($search)
    {
        $customers = Customer::with(['user', 'comunications', 'quotations'])->where('name', 'like', '%' . $search . '%')->orWhere('cell', 'like', '%' . $search . '%')->orWhere('career', 'like', '%' . $search . '%')->orWhere('university', 'like', '%' . $search . '%')->get();
        return response()->json([
            'customers' => $customers,
            'quotations' => $customers->map->only(['quotations'])
        ]);
    }

    public function searchPreleads($search)
    {
        $customers = Customer::with('comunications')->where(function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('cell', 'like', '%' . $search . '%');
        })->where('status', '<=', 4)->get();
        return response()->json($customers);
    }

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

    public function getLeadsByDate($date)
    {
        $customers = Customer::with(['comunications', 'quotations', 'user'])->whereHas('comunications', function ($query) use ($date) {
            $query->where('next_management', $date);
        })->get();
        return response()->json($customers);
    }

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

    public function changeInterest($quotationId, $interest)
    {
        $quotation = Quotation::find($quotationId);

        $quotation->update([
            'interest' => $interest
        ]);

        return response()->json($quotation);
    }

    public function searchCustomersComunications($search)
    {
        $customers = Customer::with(['user', 'comunications'])->where('name', 'like', '%' . $search . '%')->orWhere('cell', 'like', '%' . $search . '%')->get();
        return response()->json($customers);
    }

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

    public function getProfiles()
    {
        /* $customers = Customer::where('status', 11)->with(['comunications', 'quotations' => function ($query) {
            $query->latest('id');
        }, 'quotations.order', 'quotations.contract', 'quotations.order.properties', 'quotations.contract.properties', 'quotations.details', 'quotations.details.product'])->orderBy('id', 'desc')->take(8)->get(); */
        $quotations =  Quotation::where('status', 11)->whereHas('contract')->with(['customers', 'contract', 'contract.properties', 'contract.projects'])->orderBy('id', 'desc')->paginate(8);

        return response()->json($quotations);
    }

    public function searchProfiles($search)
    {
        $quotations = Quotation::where('status', 11)
            ->where(function ($query) {
                $query->whereHas('contract')
                    ->orWhereHas('order');
            })
            ->whereHas('customers', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->with(['contract', 'customers', 'contract.projects', 'contract.properties'])
            ->orderBy('id', 'desc')
            ->paginate(8);

        return response()->json($quotations);
    }

    public function searchCustomersByDate($date)
    {
        $customers = Customer::with(['user', 'comunications'])->where('status', '>', 0)->where('status', '<=', 3)->where('created_at', 'like', '%' . $date . '%')->get();
        return response()->json($customers);
    }

    public function searchCustomersById($id)
    {
        $customer = Customer::with(['user', 'comunications', 'quotations.order.project', 'quotations.contract.projects'])->find($id);
        return response()->json($customer);
    }

    public function clients()
    {
        $customers = Customer::with(['quotations', 'quotations.details', 'quotations.details.product', 'quotations.order', 'quotations.order.payments', 'quotations.contract.payments'])->where('status', 11)->get();
        return response()->json($customers);
    }
}
