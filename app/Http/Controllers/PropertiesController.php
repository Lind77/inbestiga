<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Project;
use App\Models\Property;
use App\Models\Quotation;
use Illuminate\Http\Request;

class PropertiesController extends Controller
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
     * Almacena una nueva propiedad en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request  Datos de la solicitud de creación.
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $property = Property::create([
            'propertiable_id' => $request->get('propertiable_id'),
            'propertiable_type' => $request->get('propertiable_type'),
            'properties' => $request->get('properties'),
            'project_situation_id' => $request->get('project_situation_id'),
            'documentary_processing' => $request->get('documentary_processing'),
        ]);

        $contract = Contract::with('quotation', 'quotation.customers')->find($request->get('propertiable_type'));

        $contract->quotation->customers->each->update([
            'property_fill' => 1
        ]);

        $project = Project::where('projectable_id', $request->get('propertiable_id'))->where('projectable_type', $request->get('propertiable_type'))->get();

        $project[0]->update([
            'status' => 1
        ]);



        return response()->json([
            'msg' => 'success'
        ]);
    }

    /**
     * Muestra la propiedad especificada.
     *
     * @param  int  $id  ID de la propiedad a mostrar.
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $contract = Contract::with('properties', 'quotation', 'quotation.details', 'quotation.details.product', 'quotation.order', 'quotation.contract', 'quotation.customers')->find($id);
        return $contract;
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
     * Actualiza la propiedad especificada en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request  Datos de la solicitud de actualización.
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $property = Property::where('propertiable_id', $request->get('propertiable_id'))->where('propertiable_type', $request->get('propertiable_type'))->first();

        $property->update([
            'properties' => $request->get('properties'),
            'documentary_processing' => $request->get('documentary_processing'),
            'project_situation_id' => $request->get('project_situation_id')
        ]);

        return response()->json([
            'msg' => 'success'
        ]);
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
    /**
     * Devuelve una lista de proyectos con sus propiedades asociadas.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function properties()
    {
        /* $properties = Property::orderBy('id', 'desc')->with(['propertiable', 'propertiable.projects', 'propertiable.projects.team', 'propertiable.quotation', 'propertiable.quotation.customers'])->get(); */
        /* $quotations =  Quotation::where('status', 11)->whereHas('contract')->with(['customers', 'contract', 'contract.properties', 'contract.projects'])->orderBy('id', 'desc')->paginate(8); */

        $projects = Project::with(['projectable', 'projectable.properties', 'projectable.quotation', 'projectable.quotation.customers', 'team', 'user'])
            ->whereHas('projectable', function ($query) {
                $query->whereHas('quotation', function ($secondquery) {
                    $secondquery->where('status', 11);
                });
            })
            ->orderBy('updated_at', 'desc')
            ->paginate(40);

        return $projects;
    }
}
