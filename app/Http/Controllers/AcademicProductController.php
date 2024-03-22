<?php

namespace App\Http\Controllers;

use App\Models\Academic_product;
use App\Models\Acceptance_indicator;
use App\Models\Assigned_activity;
use Illuminate\Http\Request;

class AcademicProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $academicProducts = Academic_product::all();
        return response()->json($academicProducts);
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
        $academicProduct = Academic_product::create([
            'name' => $request->get('name')
        ]);

        $indicators = json_decode($request->get('indicators'), true);

        $indicatorIds = [];

        foreach ($indicators as $indicator) {
            $newIndicator = Acceptance_indicator::create([
                'name' => $indicator['value']
            ]);
            array_push($indicatorIds, $newIndicator->id);
        }

        $academicProduct->acceptance_indicators()->attach($indicatorIds);


        $assigned_activity = Assigned_activity::create([
            'assigned_activitiable_type' => 'App\Models\Delivery',
            'assigned_activitiable_id' => $request->get('deliveryId'),
            'name' => $academicProduct->name,
            'status' => 0
        ]);

        return response()->json([
            'msg' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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
