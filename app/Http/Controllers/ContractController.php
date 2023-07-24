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
use App\Models\Quotation;
use App\Models\Seen;
use App\Models\User;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contracts = Contract::with(['quotation', 'quotation.customers'])->get();
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
                'deliverable_id' => $contract->id,
                'deliverable_type' => 'App\Models\Contract',
                'date' => $delivery['date'],
                'advance' => $delivery['advance'],
                'type' => 0
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
    public function destroy(Contract $contract)
    {
        //
    }

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
                'level' => $prod['level'],
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

    public function insertContract(Request $request)
    {
        $contract = Contract::create([
            'quotation_id' => $request->get('quotation_id'),
            'amount' => $request->get('amount'),
            'amount_text' => $request->get('amount_text'),
            'date' => $request->get('date'),
            'third_article' => $request->get('third_article'),
            'fifth_article' => $request->get('fifth_article')
        ]);

        $contract->quotation->update([
            'status' => 9
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
                'deliverable_id' => $contract->id,
                'deliverable_type' => 'App\Models\Contract',
                'date' => $delivery['date'],
                'advance' => $delivery['advance'],
                'type' => 0
            ]);
        }

        $customers = json_decode($request->get('customers'), true);

        foreach ($customers as $customer) {
            $customer = Customer::find($customer['id']);
            $customer->update([
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
}
