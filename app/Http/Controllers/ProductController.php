<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Customer;
use App\Models\NewPrice;
use App\Models\NewProduct;
use App\Models\Price;
use App\Models\Project;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Mostrar una lista de los recursos.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::orderBy('id', 'asc')
            ->where('id', '!=', 1)
            ->get();
        return response()->json($products);
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
     * Almacenar un nuevo recurso en almacenamiento.
     *
     * @param  \App\Http\Requests\StoreProductRequest  $request  La solicitud que contiene los datos del nuevo producto.
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $product = Product::create([
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'amount' => $request->get('amount'),
            'term' => $request->get('term'),
            'type' => $request->get('type'),
            'level' => $request->get('level')
        ]);

        $prices = json_decode($request->get('prices'));

        foreach ($prices as $key => $price) {
            $price = Price::create([
                'product_id' => $product->id,
                'level' => $key + 1,
                'price' => $price
            ]);
        }


        return response()->json([
            'msg' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductRequest  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        //
    }

    /**
     * Eliminar el recurso especificado de almacenamiento.
     *
     * @param  int  $id  El ID del producto a eliminar.
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        return response()->json([
            'msg' => 'success'
        ]);
    }
     /**
     * Asignar un producto a un cliente y crear un proyecto asociado.
     *
     * @param  \Illuminate\Http\Request  $request  La solicitud que contiene los datos del cliente y del producto.
     * @return \Illuminate\Http\Response
     */
    public function assignProduct(Request $request)
    {

        $customer = Customer::find($request->get('customer_id'));


        $project = Project::create([
            'title' => 'Prospecto ' . $customer->name,
            'customer_id' => $request->get('customer_id'),
            'deadline' => date('Y-m-d'),
            'product_id' => $request->get('product_id')
        ]);

        $customer->update([
            'status' => 4
        ]);

        return response()->json([
            'msg' => 'success'
        ]);
    }
    /**
     * Obtener todos los productos con sus precios.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllProductsWithPrices()
    {
        $newProducts = Product::with('levels')->get();
        $products = Product::where('id', '!=', 1)->with('levels')->get();

        return response()->json($newProducts);
    }
    /**
     * Insertar un nuevo producto y sus precios.
     *
     * @param  \Illuminate\Http\Request  $request  La solicitud que contiene los datos del nuevo producto.
     * @return \Illuminate\Http\Response
     */
    public function insertNewProduct(Request $request)
    {
        $product = Product::create([
            'name' => $request->get('name'),
            'type' => $request->get('type'),
            'mode' => $request->get('mode')
        ]);

        $prices = json_decode($request->get('prices'));

        foreach ($prices as $key => $price) {
            if ($price != 0) {
                $product->levels()->attach($key + 1, ['price' => $price]);
            }
        }

        return response()->json([
            'msg' => 'success'
        ]);
    }
}
