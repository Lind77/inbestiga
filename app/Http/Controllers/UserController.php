<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Memoir;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function getAllUsers(){
        $users = User::with('roles')->get();
        return response()->json($users);
    }

    public function getRoles(){
        $roles = Role::all()->pluck('name');
        return $roles;
    }

    public function createRol(Request $request){
        $role = Role::create(['name' => $request->get('name')]);
        return $role;
    }

    public function createUser(Request $request){
        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password'))
        ]);

        $user->assignRole($request->get('rol'));

        $memoir = Memoir::create([
            'user_id' => $user->id,
            'area' => $request->get('area')
        ]);
        
        return response()->json([
            'msg' => 'success'
        ]);
    }

    public function deleteUser($id){

        $user = User::find($id);
        $user->delete();

        return response()->json([
            'msg' => 'success'
        ]);
    }

    public function assignTeamUser(Request $request){
        $user = User::find($request->get('owner_id'));
        $memoir = $user->memoir;

        $memoir->update([
            'team_id' => $request->get('team_id')
        ]);

        return response()->json([
            'msg' => 'success'
        ]);
    }
}
