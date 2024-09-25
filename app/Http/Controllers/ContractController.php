<?php

namespace App\Http\Controllers;

use App\Events\NewDocument;
use App\Models\Contract;
use App\Http\Requests\StoreContractRequest;
use App\Http\Requests\UpdateContractRequest;
use App\Models\Comission;
use App\Models\Customer;
use App\Models\Delivery;
use App\Models\Detail;
use App\Models\Fee;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Project;
use App\Models\Quotation;
use App\Models\Seen;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contracts = Contract::with(['quotation', 'quotation.customers'])->orderBy('id', 'desc')->paginate(20);
        return response()->json($contracts);
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
     * @param  \App\Http\Requests\StoreContractRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Verify if exist a quotation and create
        if ($request->get('quotation_id') == 'undefined') {
            $quotation = Quotation::create([
                'customer_id' => $request->get('customer_id'),
                'date' => $request->get('date'),
                'amount' => $request->get('amount'),
                'expiration_date' => $request->get('expirationDay'),
                'discount' => 0,
                'term' => '-',
                'note' => '-'
            ]);

            $products = $request->get('products');

            $arrProds = json_decode($products, true);

            foreach ($arrProds as $prod) {
                $detail = Detail::create([
                    'quotation_id' => $quotation->id,
                    'product_id' => $prod['product_id'],
                    'type' => $prod['type'],
                    'description' => '-',
                    'price' => $prod['price'],
                    'level' => $prod['level']
                ]);
            }

            $contract = Contract::create([
                'quotation_id' => $quotation->id,
                'amount' => $request->get('amount'),
                'amount_text' => $request->get('amount_text'),
                'date' => $request->get('date'),
                'third_article' => $request->get('third_article'),
                'fifth_article' => $request->get('fifth_article')
            ]);
        } else {
            $quotation = Quotation::with('contract')->find($request->get('quotation_id'));

            $products = $request->get('products');

            Detail::where('quotation_id', $quotation->id)->delete();

            $arrProds = json_decode($products, true);

            foreach ($arrProds as $prod) {
                $detail = Detail::create([
                    'quotation_id' => $quotation->id,
                    'product_id' => $prod['product_id'],
                    'type' => $prod['type'],
                    'description' => '-',
                    'price' => $prod['price'],
                    'level' => $prod['level'],
                    'mode' => $prod['mode']
                ]);
            }
            if ($quotation->contract != null) {
                $quotation->contract->update([
                    'amount' => $request->get('amount'),
                    'amount_text' => $request->get('amount_text'),
                    'date' => $request->get('date'),
                ]);
                $contract = $quotation->contract;
            } else {
                $contract = Contract::create($request->all());
            }
        }

        //Crear el proyecto
        $project = Project::create([
            'projectable_id' => $contract->id,
            'projectable_type' => 'App\Models\Project',
            'title' => 'Proyecto #' . $contract->id
        ]);

        $fees = json_decode($request->get('fees'), true);

        foreach ($fees as $fee) {
            Payment::create([
                'paymentable_id' => $contract->id,
                'paymentable_type' => 'App\Models\Contract',
                'date' => $fee['date'],
                'amount' => $fee['amount'],
                'advance' => $fee['advance'],
                'percentage' => $fee['percentage']
            ]);
        }

        $deliveries = json_decode($request->get('deliveries'), true);

        foreach ($deliveries as $delivery) {
            Delivery::create([
                'advance' => $delivery['advance'],
                'project_id' => $project->id,
                'date' => $delivery['date']
            ]);
        }

        $customer = Customer::find($request->get('customer_id'));

        $customer->update([
            'status' => 9
        ]);

        $user = User::find($request->get('user_id'));

        $comission = Comission::create([
            'customer_id' => $customer->id,
            'concept' => 'Cotización',
            'percent' => 5,
            'referal' => $user->name,
            'user_id' => $request->get('user_id')
        ]);

        $notification = Notification::create([
            'emisor_id' => $request->get('emisor_id'),
            'content' => 'generó el contrato de ' . $customer->name,
            'type' => 1
        ]);

        $usersToNotify = User::role('Seller')->get();

        foreach ($usersToNotify as $user) {
            Seen::create([
                'user_id' => $user->id,
                'notification_id' => $notification->id,
                'seen' => 0
            ]);
        }

        broadcast(new NewDocument($contract));

        return response()->json($contract->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function show(Contract $contract)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function edit(Contract $contract)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateContractRequest  $request
     * @param  \App\Models\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateContractRequest $request, Contract $contract)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contract = Contract::with(['payments', 'projects.deliveries', 'projects.posts'])->find($id);

        // Eliminar pagos asociados
        if ($contract->payments->isNotEmpty()) {
            $contract->payments->each->delete();
        }

        // Iterar sobre cada proyecto
        $contract->projects->each(function ($project) {

            // Eliminar las entregas del proyecto
            if ($project->deliveries->isNotEmpty()) {
                $project->deliveries->each->delete();
            }

            // Eliminar los posts del proyecto
            if ($project->posts->isNotEmpty()) {
                $project->posts->each->delete();
            }

            // Eliminar el proyecto
            $project->delete();
        });

        // Finalmente, eliminar el contrato
        $contract->delete();

        return response()->json([
            'msg' => 'success'
        ]);
    }

      /**
     * Update the contract with new details.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateContract(Request $request)
    {

        $contract = Contract::with(['quotation', 'quotation.details', 'quotation.customers'])->find($request->get('contractId'));

        $contract->update([
            'amount' => $request->get('amount'),
            'amount_text' => $request->get('amount_text'),
            'date' => $request->get('date'),
            'third_article' => $request->get('third_article'),
            'fifth_article' => $request->get('fifth_article')
        ]);

        $quotation = $contract->quotation;

        $quotation->details->each(function ($detail) {
            $detail->delete();
        });



        $quotation->customers->each->update([
            'status' => 9
        ]);

        $details = $request->get('products');

        $arrProds = json_decode($details, true);

        foreach ($arrProds as $prod) {
            $detail = Detail::create([
                'quotation_id' => $quotation->id,
                'product_id' => $prod['product_id'],
                'type' => $prod['type'],
                'description' => '-',
                'price' => $prod['price'],
                'level' => intval($prod['level']) - 1,
                'mode' => $prod['mode']
            ]);
        }

        //Payments

        $contract->payments->each->delete();

        $fees = json_decode($request->get('fees'), true);

        foreach ($fees as $fee) {
            Payment::create([
                'paymentable_id' => $contract->id,
                'paymentable_type' => 'App\Models\Contract',
                'date' => $fee['date'],
                'amount' => $fee['amount'],
                'advance' => $fee['advance'],
                'percentage' => $fee['percentage']
            ]);
        }

        $contract->deliveries->each->delete();

        $deliveries = json_decode($request->get('deliveries'), true);

        foreach ($deliveries as $delivery) {
            Delivery::create([
                'deliverable_id' => $contract->id,
                'deliverable_type' => 'App\Models\Contract',
                'date' => $delivery['date'],
                'advance' => $delivery['advance'],
                'type' => 0
            ]);
        }

        return $contract;
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $search
     * @return \Illuminate\Http\Response
     */
    public function search($search)
    {
        $contracts = Contract::with(['quotation', 'quotation.customers'])
            ->whereHas('quotation.customers', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')->orWhere('cell', 'like', '%' . $search . '%');
            })
            ->orderBy('updated_at', 'desc')
            ->get();

        return response()->json($contracts);
    }
    /**
     * Update the contract with new details.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function insertContract(Request $request)
    {
        // Validación de datos de clientes
        $customers = json_decode($request->get('customers'), true);
        if ($customers !== null) {
            foreach ($customers as $customer) {
                $rules_customer = [
                    'dni' => 'required',
                    'address' => 'required',
                    'name' => 'required',
                    // Otras reglas de validación para el elemento del array
                ];

                $validator_customers = Validator::make($customer, $rules_customer);

                if ($validator_customers->fails()) {
                    return response()->json([
                        'message' => 'Asegurate que los datos de los usuarios estén completos'
                    ], 405);
                }
            }
        }

        // Validación de datos de pagos
        $payments = json_decode($request->get('payments'), true);
        if ($payments !== null) {
            foreach ($payments as $payment) {
                $rules = [
                    'date' => 'required',
                    // Otras reglas de validación para el elemento del array
                ];

                $validator = Validator::make($payment, $rules);

                if ($validator->fails()) {
                    return response()->json([
                        'message' => 'Asegurate de que todas las fechas de pagos están completadas'
                    ], 405);
                }
            }
        }

        // Validación de datos del request
        $request->validate([
            'date' => 'required',
            'payments' => 'required',
            'deliveries' => 'required',
            'payments.*.date' => 'required',
            'bank_account_type' => 'required|numeric|min:0|not_in:0'
            /*  'deliveries.date' => 'required', */
            /* 'deliveries.advance' => 'required' */
        ]);

        // Eliminar contratos antiguos
        Contract::where('quotation_id', $request->get('quotation_id'))->delete();

        // Crear nuevo contrato
        $contract = Contract::create([
            'quotation_id' => $request->get('quotation_id'),
            'amount' => $request->get('amount'),
            'amount_text' => $request->get('amount_text'),
            'cent_text' => $request->get('cent_text'),
            'date' => $request->get('date'),
            'third_article' => $request->get('third_article'),
            'fifth_article' => $request->get('fifth_article'),
            'third_article_place' => $request->get('third_article_place'),
            'third_article_ppts' => $request->get('third_article_ppts'),
            'fragment' => $request->get('fragment'),
            'user_id' => $request->get('user_id'),
            'bank_account_type' => $request->get('bank_account_type'),
            'degree_modality_id' => $request->get('degree_modality_id')
        ]);

        $customers = json_decode($request->get('customers'), true);

        // Asociar clientes con la cotización
        $quotation = Quotation::with(['details'])->find($request->get('quotation_id'));
        $quotation->customers()->sync(array_column($customers, 'id'));

        // Actualizar estado de la cotización
        $contract->quotation->update([
            'status' => 9
        ]);

        // Actualizar details de cotización
        $quotation->details->each(function ($detail) {
            $detail->delete();
        });

        $products =  json_decode($request->get('products'), true);

        foreach ($products as $product) {
            $detail = Detail::create([
                'quotation_id' => $quotation->id,
                'product_id' => $product['product_id'],
                'type' => $product['type'],
                'description' => '-',
                'price' => $product['price'],
                'level' => intval($product['level']) - 1,
                'mode' => $product['mode'],
                'extra_price' => $product['extra_price'],
                'name' => $product['product']['name']
            ]);
        }

        //Create project

        $project = Project::create([
            'projectable_id' => $contract->id,
            'projectable_type' => 'App\Models\Contract',
            'title' => 'Proyecto #' . $contract->id,
            'user_id' => $request->get('user_id'),
            'status' => 0
        ]);

        $deliveries = json_decode($request->get('deliveries'), true);

        foreach ($deliveries as $delivery) {
            Delivery::create([
                'advance' => $delivery['advance'],
                'status' => 0,
                'project_id' => $project->id,
                'date' => $delivery['date'] ?: null,
                'type' => 1
            ]);
        }

        $payments = json_decode($request->get('payments'), true);

        foreach ($payments as $payment) {
            Payment::create([
                'paymentable_id' => $contract->id,
                'paymentable_type' => 'App\Models\Contract',
                'date' => $payment['date'] ?: null,
                'amount' => $payment['amount'],
                'advance' => null,
                'percentage' => $payment['percentage']
            ]);
        }

        $customers = json_decode($request->get('customers'), true);

        foreach ($customers as $customer) {
            Customer::find($customer['id'])->update([
                'status' => 9
            ]);
        }

        $user = User::find($request->get('user_id'));

        /* $comission = Comission::create([
            'quotation_id' => $request->get('quotation_id'),
            'concept' => 'Cotización',
            'percent' => 5,
            'referal' => $user->name,
            'user_id' => $request->get('user_id')
        ]); */
        /* 
        $notification = Notification::create([
            'emisor_id' => $request->get('emisor_id'),
            'content' => 'generó el contrato de ' . $customer->name,
            'type' => 1
        ]);

        $usersToNotify = User::role('Seller')->get();

        foreach ($usersToNotify as $user) {
            Seen::create([
                'user_id' => $user->id,
                'notification_id' => $notification->id,
                'seen' => 0
            ]);
        } */

        //broadcast(new NewDocument($contract));

        return response()->json($contract->id);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $quotationId
     * @return \Illuminate\Http\Response
     */
    private function verifyQuotation($quotationId)
    {
        $quotation = Quotation::find($quotationId);

        return $quotation;
        /* if ($request->get('quotation_id') == 'undefined') {
            $quotation = Quotation::create([
                'customer_id' => $request->get('customer_id'),
                'date' => $request->get('date'),
                'amount' => $request->get('amount'),
                'expiration_date' => $request->get('expirationDay'),
                'discount' => 0,
                'term' => '-',
                'note' => '-'
            ]);

            $products = $request->get('products');

            $arrProds = json_decode($products, true);

            foreach ($arrProds as $prod) {
                $detail = Detail::create([
                    'quotation_id' => $quotation->id,
                    'product_id' => 1,
                    'type' => $prod['type'],
                    'description' => '-',
                    'price' => $prod['price'],
                    'new_product_id' => $prod['new_product_id'],
                    'level' => $prod['level']
                ]);
            }

            
        } else {
            $quotation = Quotation::with('contract')->where('id', $request->get('quotation_id'))->first();

            $products = $request->get('products');

            Detail::where('quotation_id', $quotation->id)->delete();

            $arrProds = json_decode($products, true);

            foreach ($arrProds as $prod) {
                $detail = Detail::create([
                    'quotation_id' => $quotation->id,
                    'product_id' => $prod['product_id'],
                    'type' => $prod['type'],
                    'description' => '-',
                    'price' => $prod['price'],
                    'level' => $prod['level'],
                    'mode' => $prod['mode']
                ]);
            }
            if ($quotation->contract != null) {
                $quotation->contract->update([
                    'amount' => $request->get('amount'),
                    'amount_text' => $request->get('amount_text'),
                    'date' => $request->get('date'),
                ]);
                $contract = $quotation->contract;
            } else {
                $contract = Contract::create($request->all());
            }
        } */
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $search
     * @return \Illuminate\Http\Response
     */
    public function searchContract($search)
    {
        $contracts = Contract::with(['quotation', 'quotation.customers'])->whereHas('quotation.customers', function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        })->get();

        $orders = Order::with(['quotation', 'quotation.customers'])->whereHas('quotation.customers', function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        })->get();


        return response()->json([
            'contracts' => $contracts,
            'orders' => $orders
        ]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $customerId,$quotationId
     * @return \Illuminate\Http\Response
     */
    public function deleteCustomer($customerId, $quotationId)
    {
        $relationship = DB::table('customer_quotation')->where('customer_id', $customerId)->where('quotation_id', $quotationId)->delete();
        return response()->json([
            'msg' => 'success'
        ]);
    }
}
