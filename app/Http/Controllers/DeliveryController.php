<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Http\Requests\StoreDeliveryRequest;
use App\Http\Requests\UpdateDeliveryRequest;
use App\Models\Payments;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $deliveries = Delivery::with(['contract', 'contract.quotation', 'contract.quotation.customer'])->where('date', date('Y-m-d'))->get();
        return response()->json($deliveries);
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
     * @param  \App\Http\Requests\StoreDeliveryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $delivery = Delivery::create([
            'contract_id' => $request->get('contract_id'),
            'date' => $request->get('date'),
            'advance' => $request->get('advance'),
            'type' => 1,
            'academic_date' => $request->get('dateAcad')
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Delivery  $delivery
     * @return \Illuminate\Http\Response
     */
    public function show(Delivery $delivery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Delivery  $delivery
     * @return \Illuminate\Http\Response
     */
    public function edit(Delivery $delivery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDeliveryRequest  $request
     * @param  \App\Models\Delivery  $delivery
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDeliveryRequest $request, Delivery $delivery)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Delivery  $delivery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Delivery $delivery)
    {
        //
    }

    public function getDeliveriesByDate($date)
    {
        $deliveries = Delivery::with(['contract', 'contract.quotation', 'contract.quotation.customer'])->where('date', $date)->get();
        $payments = Payments::with(['order', 'order.quotation', 'order.quotation.customer'])->where('date', $date)->get();

        return response()->json([
            'deliveries' => $deliveries,
            'payments' => $payments
        ]);
    }

    public function search($search)
    {
        $deliveries = Delivery::with(['contract', 'contract.quotation', 'contract.quotation.customer'])
            ->whereHas('contract.quotation.customer', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })->get();

        return response()->json($deliveries);
    }
}
