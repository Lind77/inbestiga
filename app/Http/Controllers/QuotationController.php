<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use App\Http\Requests\StoreQuotationRequest;
use App\Http\Requests\UpdateQuotationRequest;
use App\Models\Customer;
use App\Models\Detail;
use Illuminate\Http\Request;
use PDF;

class QuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $quotations = Quotation::with('customer')->get();
        return response()->json($quotations);
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
     * @param  \App\Http\Requests\StoreQuotationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /* $customer = Customer::create([
            'name' => $request->get('name'),
            'cell' => $request->get('cell'),
            'university' => $request->get('university'),
            'career' => $request->get('career'),
            'grade' => $request->get('grade'),
        ]); */

        $customer = json_decode($request->get('customer'),true);

        $quotation = Quotation::create([
            'customer_id' => $customer['id'],
            'date' => $request->get('date'),
            'amount' => $request->get('amount'),
            'expiration_date' => $request->get('expirationDay'),
            'discount' => $request->get('discount')
        ]);

        $products = $request->get('products');
        $suggestedProducts = $request->get('suggestedProducts');

        $arrProds = json_decode($products, true);

        $arrSuggesProds = json_decode($suggestedProducts, true);

        if(is_array($arrProds)){
            foreach($arrProds as $prod){
                $prod_decode =  json_decode($prod);
                $detail = Detail::create([
                    'product_id' => $prod_decode->id,
                    'quotation_id' => $quotation->id,
                    'type' => 1
                ]);
            }
        }else{
            return 'no es array';
        };

        if(is_array($arrSuggesProds)){
            foreach($arrSuggesProds as $prod){
                $prod_decode =  json_decode($prod);
                $detail = Detail::create([
                    'product_id' => $prod_decode->id,
                    'quotation_id' => $quotation->id,
                    'type' => 2
                ]);
            }
        }else{
            return 'no es array';
        };

        return response()->json([
            'msg' => 'success',
            'id' => $quotation->id
        ]);

        /* return  */
        
        /* foreach($products as $product){
            
        }

        

        $sugested_products = json_decode($request->get('suggestedProducts'),true);

        foreach($sugested_products as $product){
            $detail = Detail::create([
                'product_id' => $product['id'],
                'quotation_id' => $quotation->id,
                'type' => 2
            ]);
        }
 */
       
        
        /* 

        $price = 0;

        foreach($products as $product){
            foreach($product['amount'] as $amount){
                $price = $price+$amount['price'];
            }
        }

        

        
        
         */
    }

    public function generatePDF($id){

        $quotation = Quotation::find($id);
        $customer = Customer::find($quotation->customer_id);
        $details = Detail::with('product')->where('quotation_id',$quotation->id)->get();

        $data = [
            'quotation' => $quotation,
            'customer' => $customer,
            'details' => $details
        ];
        return view('quotation', compact('quotation','customer', 'details'));   
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function show(Quotation $quotation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function edit(Quotation $quotation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateQuotationRequest  $request
     * @param  \App\Models\Quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateQuotationRequest $request, Quotation $quotation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quotation $quotation)
    {
        //
    }

    public function newPDF(Request $request){

        $prueba = $request->get('all');


    }
}
