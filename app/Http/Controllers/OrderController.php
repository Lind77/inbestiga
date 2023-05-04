<?php

namespace App\Http\Controllers;

use App\Events\NewDocument;
use App\Models\Order;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Comission;
use App\Models\Contract;
use App\Models\Customer;
use App\Models\Detail;
use App\Models\Fee;
use App\Models\Notification;
use App\Models\Payments;
use App\Models\Quotation;
use App\Models\Seen;
use App\Models\User;
use Illuminate\Http\Request;
use Mockery\Undefined;
use PDF;
use Symfony\Component\CssSelector\Node\FunctionNode;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::with(['quotation','quotation.customer'])->get();

        return response()->json($orders);
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
     * @param  \App\Http\Requests\StoreOrderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Verificar si hay una orden con el id de cotización
        $order = Order::where('quotation_id',$request->get('quotation_id'))->first();

        if($order){

            $order->update([
                'final_delivery' => $request->get('final_delivery'),
                'observations' => $request->get('observations'),
                'suggested' => $request->get('suggested')
            ]);

        }else{

            $order = Order::create([
                'quotation_id' => $request->get('quotation_id'),
                'final_delivery' => $request->get('final_delivery'),
                'observations' => $request->get('observations'),
                'suggested' => $request->get('suggested')
            ]);
    
            $payments = json_decode($request->get('payments'), true);
    
            foreach ($payments as $payment) {
                $payment_registered = Payments::create([
                    'order_id' => $order->id,
                    'date' => $payment['date'],
                    'amount' => $payment['amount']
                ]);
            }
        }

        $quotation = Quotation::find($request->get('quotation_id'));

        $quotation->update([
            'discount' => $request->get('discount')
        ]);

        $customer = Customer::find($quotation->customer_id);

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

        return response()->json($order->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateOrderRequest  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }

    public function generateContract($id){
        $customer = Customer::with(['quotations'=> function($query){
            $query->orderBy('id', 'desc')->with(['contracts'=> function($query2){
                $query2->orderBy('id', 'desc')->with('fees')->first();
            }])->first();
        }])->find($id);
		$pdf = PDF::loadView('contract', compact('customer'));
		return $pdf->stream('prueba.pdf');
    }

    public function insertContract(Request $request){

        if($request->get('quotation_id') == 'undefined'){
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

            foreach($arrProds as $prod){
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

            $contract = Contract::create([
                'quotation_id' => $quotation->id,
                'amount' => $request->get('amount'),
                'amount_text' => $request->get('amount_text'),
                'date' => $request->get('date'),
            ]);
        }else{
            $quotation = Quotation::with('contract')->where('id', $request->get('quotation_id'))->get();
            if($quotation[0]->contract != null){
                $quotation->contract->update([
                    'amount' => $request->get('amount'),
                    'amount_text' => $request->get('amount_text'),
                    'date' => $request->get('date'),
                ]);
            }else{
                $contract = Contract::create($request->all());
            }
        }
        

       
        $fees = json_decode($request->get('fees'), true);

        foreach ($fees as $fee) {
           Fee::create([
                'contract_id' => $contract->id,
                'date' => $fee['date'],
                'amount' => $fee['amount'],
                'advance' => $fee['advance'],
                'percentage' => $fee['percentage']
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
            'content' => 'generó el contrato de '.$customer->name,
            'type' => 1
        ]);

        $usersToNotify = User::role('Seller')->get();

        foreach($usersToNotify as $user){
            Seen::create([
                'user_id' => $user->id,
                'notification_id' => $notification->id,
                'seen' => 0
            ]);
        }

        broadcast(new NewDocument($contract));

        return response()->json($contract->id);
    }
}
