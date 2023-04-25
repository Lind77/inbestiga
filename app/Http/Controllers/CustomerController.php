<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Comission;
use App\Models\Comunication;
use App\Models\Detail;
use App\Models\NewProduct;
use App\Models\Origin;
use App\Models\Quotation;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::with(['project','project.product', 'comunication','quotations', 'quotations.orders'])->orderBy('updated_at', 'desc')->get();
        return response()->json($customers);
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
     * @param  \App\Http\Requests\StoreCustomerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCustomerRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = Customer::find($id);
        return response()->json($customer);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCustomerRequest  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //
    }

    public function insertCustomer(Request $request){
        $time = strtotime($request->get('next_management'));
        $date = date('Y-m-d', $time);
        $hour = date('H:i:s', $time);
        $customer = Customer::create($request->all());

        if($request->get('referedFrom') != 0){
            $origin = Origin::create([
                'customer_id' => $customer->id,
                'type' => $request->get('origin'),
                'channel' => null,
                'user_id' => $request->get('referedFrom')
           ]);
        }else{
            $origin = Origin::create([
                'customer_id' => $customer->id,
                'type' => $request->get('origin'),
                'channel' => $request->get('channel'),
                'user_id' => null
    
           ]);
        }

        $referal = User::find($request->get('referedFrom'));

        if(!$referal){
            $nameReferal = '-';
        }else{
            $nameReferal = $referal->name;
        }

        $comission = Comission::create([
            'customer_id' => $customer->id,
            'concept' => 'Marketing/referenciación',
            'percent' => 23,
            'referal' => $nameReferal,
            'user_id' => $request->get('user_id')
        ]);

        /* $comunication = Comunication::create([
            'customer_id' => $customer->id,
            'first_management' => $request->get('first_management'),
            'last_management' => $request->get('last_management'),
            'next_management' => $date,
            'comment' => $request->get('comment'),
            'product_tentative' => $request->get('product_tentative'),
            'type' => $request->get('type'),
            'time' => $hour
        ]);
 */
        return response()->json([
            'msg' => 'success'
        ]);
    }

    public function updateCustomer(Request $request){

        $customer = Customer::find($request->get('id'));

        $customer->update([
            'name' => $request->get('name'),
            'cell' => $request->get('cell'),
            'university' => $request->get('university'),
            'career' => $request->get('career'),
            'email' => $request->get('email')
        ]);

        return response()->json([
            'msg' => 'success'
        ]);
    }

    public function updateCustomerGrade(Request $request){
        $customer = Customer::find($request->get('customer_id'));
        $user = User::find($request->get('user_id'));

        if($request->get('status') == 3){
            $comission = Comission::create([
                'customer_id' => $customer->id,
                'concept' => 'Obtención de datos',
                'percent' => 2,
                'referal' => $user->name,
                'user_id' => $request->get('user_id')
            ]);
        }

        $customer->update([
            'status' => $request->get('status')
        ]);
        return response()->json([
            'msg' => 'success'
        ]);
    }

    public function standByCustomer($id){

        $customer = Customer::find($id);
        $customer->update([
            'status' => null
        ]);

        return response()->json([
            'msg' => 'success'
        ]);
    }

    public function getAllStandByCustomers(){
        $customers = Customer::where('status', '=', null)->with(['project','project.product'])->get();
        return response()->json($customers);
    }

    public function reactivateCustomer($id){
        $customer = Customer::find($id);
        $customer->update([
            'status' => 1
        ]);
        return response()->json([
            'msg' => 'success'
        ]);
    }

    public function updateDniCustomer(Request $request){

        $customer = Customer::find($request->get('id_customer'));
        $customer->update([
            'dni' => $request->get('dni'),
            'address' => $request->get('address')
        ]);

        return response()->json($customer);
    }
    
    public function getAllPreleads(){
        $customers = Customer::where('status','<=', 3)->with(['project','project.product', 'comunication','quotations', 'quotations.orders'])->orderBy('updated_at', 'desc')->get();
        return response()->json($customers);
    }

    public function getAllLeads($id){
        if($id == 7){
            $customers = Customer::where('status','>', 2)->with(['project','project.product', 'comunication','quotations', 'quotations.orders'])->orderBy('updated_at', 'desc')->get();
        }else{
            $customers = Customer::where('status','>', 2)->where('user_id', $id)->with(['project','project.product', 'comunication','quotations', 'quotations.orders'])->orderBy('updated_at', 'desc')->get();
        }
        
        return response()->json($customers);
    }

    public function assignOwner(Request $request){
        $customer = Customer::find($request->get('customer_id'));
        $customer->update([
            'user_id' => $request->get('seller_selected'),
            'status' => 4
        ]);

        $quotation = Quotation::create([
            'customer_id' => $request->get('customer_id'),
            'date' => date('Y-m-d'),
            'amount' => 0,
            'term' => '-'
        ]);

        $products = json_decode($request->get('products'), true);

        foreach ($products as $product){

            $newProduct = NewProduct::with('newprices')->find($product['id']);

            $levelSearched = $product['level'];

            $priceFounded = 0;

            foreach($newProduct->newprices as $price){
                if($price->level == $levelSearched){
                    $priceFounded = $price->price;
                }
            }
           
            $detail = Detail::create([
                'quotation_id' => $quotation->id,
                'product_id' => 1,
                'new_product_id' => $product['id'],
                'description' => '-',
                'type' => 1,
                'price' => $priceFounded,
                'level' => $product['level']
            ]);

        }

        $user = User::find($request->get('user_id'));
        $nameReferal = $user->name;

        $comission = Comission::create([
            'customer_id' => $customer->id,
            'concept' => 'Obtención de necesidades específicas',
            'percent' => 8,
            'referal' => $nameReferal,
            'user_id' => $request->get('user_id')
        ]);


        return response()->json([
            'msg' => 'success'
        ]);
    }
}
