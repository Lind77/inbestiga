<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Customer;
use App\Models\Price;
use App\Models\Project;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::orderBy('id','asc')
                            ->where('id', '!=', 1)
                            ->with(['fixedActivities','fixedActivities.fixedTasks','prices'])->get();
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
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductRequest  $request
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

        foreach ($prices as $key=>$price) {
            $price = Price::create([
                'product_id' => $product->id,
                'level' => $key+1,
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }

    public function assignProduct(Request $request){

        $customer = Customer::find($request->get('customer_id'));

        $project = Project::create([
            'title' => 'Prospecto '.$customer->name,
            'customer_id' => $request->get('customer_id'),
            'deadline' => date('Y-m-d'),
            'product_id' => $request->get('product_id')
        ]);

        $customer->update([
            'grade' => 4
        ]);

        return response()->json([
            'msg' => 'success'
        ]);
    }
}
