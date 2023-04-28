<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Contract;
use App\Models\Customer;
use App\Models\Fee;
use App\Models\Payments;
use App\Models\Quotation;
use App\Models\User;
use Illuminate\Http\Request;
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

        $quotation = Quotation::find($request->get('quotation_id'));

        $quotation->update([
            'discount' => $request->get('discount')
        ]);

        $customer = Customer::find($quotation->customer_id);

        $customer->update([
            'status' => 9
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
        $contract = Contract::create($request->all());
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

        return response()->json($contract->id);
    }
}
