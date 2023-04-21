<?php

namespace App\Http\Controllers;

use App\Models\NewProduct;
use App\Http\Requests\StoreNewProductRequest;
use App\Http\Requests\UpdateNewProductRequest;

class NewProductController extends Controller
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
     * @param  \App\Http\Requests\StoreNewProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNewProductRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NewProduct  $newProduct
     * @return \Illuminate\Http\Response
     */
    public function show(NewProduct $newProduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\NewProduct  $newProduct
     * @return \Illuminate\Http\Response
     */
    public function edit(NewProduct $newProduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateNewProductRequest  $request
     * @param  \App\Models\NewProduct  $newProduct
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNewProductRequest $request, NewProduct $newProduct)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NewProduct  $newProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy(NewProduct $newProduct)
    {
        //
    }

    public function getAllNewProducts(){
        $new_products = NewProduct::with('newprices')->get();
        return response()->json($new_products);
    }
}
