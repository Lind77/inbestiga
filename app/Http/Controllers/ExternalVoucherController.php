<?php

namespace App\Http\Controllers;

use App\Models\External_voucher;
use App\Models\Image;
use Illuminate\Http\Request;
/**
 * Class ExternalVoucherController
 *
 * Controlador para gestionar los vales externos.
 * Incluye métodos para listar, crear, y gestionar los vales externos.
 *
 * @package App\Http\Controllers
 */
class ExternalVoucherController extends Controller
{
    /**
     * Muestra una lista de los vales externos.
     *
     * @return \Illuminate\Http\JsonResponse  La respuesta JSON con la lista de vales externos.
     */
    public function index()
    {
        $external_vouchers = External_voucher::with(['contract', 'contract.projects', 'contract.quotation', 'contract.quotation.customers', 'images'])->get();
        return response()->json($external_vouchers);
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
     * Almacena un nuevo vale externo en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request  La solicitud que contiene los datos del nuevo vale.
     * @return \Illuminate\Http\JsonResponse  La respuesta JSON con el vale externo creado.
     */
    public function store(Request $request)
    {
        $external_voucher = External_voucher::create([
            'contract_id' => $request->get('contractId'),
            'customer_id' => $request->get('customerId'),
            'status' => 1,
            'date' => date('Y-m-d')
        ]);

        if ($request->hasFile('file')) {
            $fileName = $request->file->getClientOriginalName();
            $url = $request->file->move(public_path('files'), $fileName);
            $image = Image::create([
                'imageable_id' => $external_voucher->id,
                'imageable_type' => 'App\\Models\\External_voucher',
                'url' => $fileName
            ]);
        }

        return response()->json($external_voucher->load('images'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
