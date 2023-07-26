<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Http\Requests\StoreDeliveryRequest;
use App\Http\Requests\UpdateDeliveryRequest;
use App\Models\Payment;
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
        $deliveries = Delivery::with(['deliverable', 'deliverable.quotation', 'deliverable.quotation.customer'])->where('date', date('Y-m-d'))->get();
        return response()->json([
            'deliveries' => $deliveries
        ]);
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

        if ($request->get('type') == 1) {
            $delivery = Delivery::create([
                'deliverable_id' => $request->get('deliverable_id'),
                'deliverable_type' => 'App\Models\Contract',
                'date' => $request->get('date'),
                'advance' => $request->get('advance'),
                'type' => $request->get('type'),
                'academic_date' => $request->get('dateAcad'),
                'status' => $request->get('status'),
            ]);
        } else {
            $delivery = Delivery::create([
                'deliverable_id' => $request->get('deliverable_id'),
                'deliverable_type' => 'App\Models\Order',
                'date' => $request->get('date'),
                'advance' => $request->get('advance'),
                'type' => $request->get('type'),
                'academic_date' => $request->get('dateAcad'),
                'status' => $request->get('status'),
            ]);
        }

        return response()->json([
            'msg' => 'success'
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
    public function update(Request $request, $id)
    {
        $delivery = Delivery::with(['contract', 'contract.quotation', 'contract.quotation.customer'])->find($id);
        $delivery->update([
            'academic_date' => $request->get('academicDate')
        ]);
        return response()->json([
            'msg' => 'success',
            'delivery' => $delivery
        ]);
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
        $deliveries = Delivery::with(['deliverable', 'deliverable.quotation', 'deliverable.quotation.customers'])->where('date', $date)->get();
        $payments = Payment::where('date', $date)->get();

        return response()->json([
            'deliveries' => $deliveries,
            'payments' => $payments
        ]);
    }

    public function search($search)
    {
        $deliveries = Delivery::with(['deliverable', 'deliverable.quotation', 'deliverable.quotation.customer'])
            ->whereHas('deliverable.quotation.customer', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })->get();

        return response()->json($deliveries);
    }

    public function checkDelivery($id)
    {
        $delivery = Delivery::find($id);
        $delivery->update([
            'type' => 1
        ]);
        return response()->json([
            'msg' => 'success'
        ]);
    }

    public function deliveriesMonth()
    {
        $deliveries = Delivery::with(['deliverable', 'deliverable.quotation', 'deliverable.quotation.customers'])->where('date', 'like', '%-' . date('m') . '-%')->get();
        return response()->json([
            'deliveries' => $deliveries
        ]);
    }
}
