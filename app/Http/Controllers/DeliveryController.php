<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Http\Requests\StoreDeliveryRequest;
use App\Http\Requests\UpdateDeliveryRequest;
use App\Models\Academic_process;
use App\Models\Assigned_activity;
use App\Models\Payment;
use App\Models\Project;
use App\Models\Quality_indicator;
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
        $deliveries = Delivery::with(['project', 'project.projectable', 'project.projectable.quotation', 'project.projectable.quotation.customers'])->where('date', date('Y-m-d'))->get();
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
        $delivery = Delivery::create([
            'academic_date' => $request->get('dateAcad'),
            'advance' => $request->get('advance'),
            'type' => $request->get('type'),
            'status' => 0,
            'project_id' => $request->get('project_id'),
            'date' => $request->get('date')
        ]);

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
    public function destroy($id)
    {
        $delivery = Delivery::find($id);
        $delivery->delete();
        return response()->json([
            'msg' => 'success'
        ]);
    }

    public function getDeliveriesByDate($date)
    {
        $deliveries = Delivery::with(['project', 'project.projectable', 'project.projectable.quotation', 'project.projectable.quotation.customers'])->where('date', $date)->get();
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
        /* $deliveries = Project::with('deliveries')->get(); */
        $deliveries = Delivery::has('project')->with(['project', 'project.projectable', 'project.projectable.quotation', 'project.projectable.quotation.customers', 'user'])->get();

        return response()->json([
            'deliveries' => $deliveries
        ]);
    }

    public function processSprint($pid, $id)
    {
        $delivery = Delivery::find($id);

        $academic_process = Academic_process::with(['academic_products', 'academic_products.acceptance_indicators'])->find($pid);

        foreach ($academic_process->academic_products as $productAcad) {
            $assigned_activity = Assigned_activity::create([
                'assigned_activitiable_id' =>   $id,
                'assigned_activitiable_type' => 'App\Models\Delivery',
                'name' => $productAcad->name,
                'academic_process_id' => $academic_process->id
            ]);

            foreach ($productAcad->acceptance_indicators as $indicator) {
                $quality_indicator = Quality_indicator::create([
                    'quality_indicable_id' => $assigned_activity->id,
                    'quality_indicable_type' => 'App\Models\Assigned_activity',
                    'name' => $indicator->name
                ]);
            }
        }

        return response()->json([
            'msg' => 'success'
        ]);
    }

    public function changeColorEvent($deliveryId, $userId)
    {
        $delivery = Delivery::find($deliveryId);
        $delivery->update([
            'user_id' => $userId
        ]);

        return response()->json([
            'msg' => 'success'
        ]);
    }
}
