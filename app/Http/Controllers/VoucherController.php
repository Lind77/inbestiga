<?php

namespace App\Http\Controllers;

use App\Models\Payment_proof;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $payment_proof = Payment_proof::create([
            'payment_proofable_id' => $request->get('payment_proofable_id'),
            'payment_proofable_type' => $request->get('payment_proofable_type'),
            'customer_id' => $request->get('customer_id'),
            'date' => $request->get('date'),
            'subtotal' => $request->get('subtotal'),
            'discount' => $request->get('discount'),
            'total_price' => $request->get('total_price'),
            'type' => 1
        ]);

        return response()->json($payment_proof->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $payment_proof = Payment_proof::with(['customer', 'payment_proofable', 'payment_proofable.quotation', 'payment_proofable.quotation.details', 'payment_proofable.quotation.details.product'])->find($id);
        return response()->json($payment_proof);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
