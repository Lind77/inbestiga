<?php

namespace App\Http\Controllers;

use App\Models\Price;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePriceRequest;
use App\Http\Requests\UpdatePriceRequest;
use App\Models\Product;
use App\Models\Promotion;
use Illuminate\Http\Request;

class PriceController extends Controller
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
     * @param  \App\Http\Requests\StorePriceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePriceRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Price  $price
     * @return \Illuminate\Http\Response
     */
    public function show(Price $price)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Price  $price
     * @return \Illuminate\Http\Response
     */
    public function edit(Price $price)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePriceRequest  $request
     * @param  \App\Models\Price  $price
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePriceRequest $request, Price $price)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Price  $price
     * @return \Illuminate\Http\Response
     */
    public function destroy(Price $price)
    {
        //
    }
    /**
     * Actualizar los precios de un producto específico.
     *
     * @param  \Illuminate\Http\Request  $request  La solicitud que contiene los IDs de producto y precios.
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePrices(Request $request)
    {
        $product = Product::find($request->get('productId'));
        $prices = $request->get('prices');
        $pricesArray = json_decode($prices, true);

        foreach ($pricesArray as $price) {
            Price::find($price['id'])->update([
                'price' => $price['price']
            ]);
        }

        return response()->json([
            'msg' => 'success'
        ]);
    }
    /**
     * Insertar un nuevo código de promoción en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request  La solicitud que contiene los datos del nuevo código de promoción.
     * @return \Illuminate\Http\JsonResponse
     */
    public function insertCode(Request $request)
    {
        $request->validate([
            'code' => 'unique:promotions'
        ]);

        $promotion = Promotion::create([
            'code' => $request->get('code'),
            'percent' => $request->get('percent'),
            'quantity' => $request->get('quantity'),
            'able' => $request->get('able'),
            'limit' => $request->get('limit'),
            'discounted' => 0
        ]);
        return response()->json($promotion->code);
    }

    /**
     * Obtener el último código de promoción insertado.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPromotionCode()
    {
        $promotion = Promotion::orderBy('id', 'desc')->first();

        return response()->json($promotion);
    }

    public function getAllPromotionsCode()
    {
        $promotions = Promotion::where('able', 1)->get();
        return response()->json($promotions);
    }
}
