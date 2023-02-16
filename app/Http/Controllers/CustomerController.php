<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
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
        $customers = Customer::with(['project','project.product'])->get();
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
    public function show(Customer $customer)
    {
        //
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
        $customer = Customer::create($request->all());
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

    public function updateCustomerGrade($id, $status){
        $customer = Customer::find($id);
        $customer->update([
            'status' => $status
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
            'status' => 0
        ]);
        return response()->json([
            'msg' => 'success'
        ]);
    }

    public function updateDniCustomer(Request $request){

        $customer = Customer::find($request->get('id_customer'));
        $customer->update([
            'dni' => $request->get('dni')
        ]);

        return response()->json($customer);
    }
}
