<?php

namespace App\Http\Controllers;

use App\Models\Owner;
use App\Http\Requests\StoreOwnerRequest;
use App\Http\Requests\UpdateOwnerRequest;
use App\Models\Customer;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $owners = User::role('Seller')->get();
        return response()->json($owners);
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
     * @param  \App\Http\Requests\StoreOwnerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOwnerRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Owner  $owner
     * @return \Illuminate\Http\Response
     */
    public function show(Owner $owner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Owner  $owner
     * @return \Illuminate\Http\Response
     */
    public function edit(Owner $owner)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateOwnerRequest  $request
     * @param  \App\Models\Owner  $owner
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOwnerRequest $request, Owner $owner)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Owner  $owner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Owner $owner)
    {
        //
    }
     /**
     * Verify the progress of a task by its ID.
     *
     * @param  int  $id  The ID of the task to verify.
     * @return \Illuminate\Http\Response
     */
    public function verifyOwner($id){
        $task = Task::find($id);
        $progress = $task->progress;

        return response()->json($progress);
    }
     /**
     * Update the owner of a customer.
     *
     * @param  \Illuminate\Http\Request  $request  The request containing the customer and user IDs.
     * @return \Illuminate\Http\Response
     */
    public function updateOwner(Request $request){
        $customer = Customer::find($request->get('customer_id'));

        $customer->update([
            'user_id' => $request->get('user_id')
        ]);
        
        return response()->json([
            'msg' => 'success'
        ]);
    }
}
