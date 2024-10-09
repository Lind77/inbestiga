<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use App\Http\Requests\StorePromotionRequest;
use App\Http\Requests\UpdatePromotionRequest;

class PromotionController extends Controller
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
     * @param  \App\Http\Requests\StorePromotionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePromotionRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function show(Promotion $promotion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function edit(Promotion $promotion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePromotionRequest  $request
     * @param  \App\Models\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePromotionRequest $request, Promotion $promotion)
    {
        //
    }

    /**
     * Elimina la promoción especificada de la base de datos.
     *
     * @param  int  $id  ID de la promoción a eliminar.
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $promotion = Promotion::find($id);

        $promotion->delete();
        return response()->json([
            'msg' => 'success'
        ]);
    }
    /**
     * Busca y devuelve una promoción por su código.
     *
     * @param  string  $code  Código de la promoción.
     * @return \Illuminate\Http\JsonResponse
     */
    public function discount($code)
    {
        $promotion = Promotion::where('code', $code)->first();
        return response()->json($promotion);
    }
}
