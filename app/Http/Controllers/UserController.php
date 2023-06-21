<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Memoir;
use App\Models\Progress;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    public function index()
    {
        $users = User::with(['roles', 'area'])->get();
        return response()->json($users);
    }

    public function show($id)
    {
        $user = User::with(['memoir', 'memoir.team'])->find($id);
        $progress = Progress::where('owner', '=', $user->name)->with(['progressable', 'progressable.activity'])->get();
        return response()->json([
            'user' => $user,
            'progress' => $progress
        ]);
    }

    public function store(Request $request)
    {
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

    public function destroy($id)
    {

        $user = User::find($id);
        $user->delete();

        return response()->json([
            'msg' => 'success'
        ]);
    }

    public function assignTeam(Request $request)
    {
        $user = User::find($request->get('owner_id'));
        $memoir = $user->memoir;

        $memoir->update([
            'team_id' => $request->get('team_id')
        ]);

        return response()->json([
            'msg' => 'success'
        ]);
    }

    public function getSellers()
    {
        $memoirs = Memoir::where('area', 'sales')->with('user')->get();
        return response()->json($memoirs);
    }
}
