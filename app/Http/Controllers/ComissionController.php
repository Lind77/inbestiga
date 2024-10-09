<?php

namespace App\Http\Controllers;

use App\Models\Comission;
use App\Http\Requests\StoreComissionRequest;
use App\Http\Requests\UpdateComissionRequest;
use App\Models\User;

class ComissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * This method is intended to retrieve a list of all comissions.
     * Currently, the implementation is not provided.
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
     * @param  \App\Http\Requests\StoreComissionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreComissionRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comission  $comission
     * @return \Illuminate\Http\Response
     */
    public function show(Comission $comission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comission  $comission
     * @return \Illuminate\Http\Response
     */
    public function edit(Comission $comission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateComissionRequest  $request
     * @param  \App\Models\Comission  $comission
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateComissionRequest $request, Comission $comission)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comission  $comission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comission $comission)
    {
        //
    }
    /**
     * Get all comissions for users with the 'Seller' role.
     *
     * This method retrieves all users who have the 'Seller' role,
     * along with their customers who are in status 11 and their associated comissions.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllComissions(){
        $users = User::with(['customers' => function ($query) {
            $query->where('status', 11);
        }, 'customers.comissions','customers.comissions.user'])
            ->whereHas('roles', function ($q) {
                $q->where('name', 'Seller');
            })->get();
        

        return response()->json($users);
    }
}
