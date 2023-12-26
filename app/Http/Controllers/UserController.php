<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Memoir;
use App\Models\Progress;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    public function index()
    {
        $users = User::with(['roles', 'subarea', 'subarea.area', 'permissions', 'attendances'])->get();
        return response()->json($users);
    }

    public function show($id)
    {
        $user = User::with(['roles', 'permissions', 'schedules', 'images'])->find($id);
        /* $progress = Progress::where('owner', '=', $user->name)->with(['progressable', 'progressable.activity'])->get(); */
        return response()->json($user);
    }

    public function store(Request $request)
    {
        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
            'subarea_id' => $request->get('subarea_id')
        ]);

        $user->assignRole($request->get('rol'));

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
        $users = User::where('subarea_id', 2)->get();
        return response()->json($users);
    }

    public function createPermission(Request $request)
    {
        $permission = Permission::create([
            'name' => $request->get('name'),
            'siderbar_name' => $request->get('siderbar_name'),
            'route_name' => $request->get('route_name'),
            'icon_class' => $request->get('icon_class')
        ]);
        return response()->json([
            'msg' => 'success'
        ]);
    }

    public function getPermissions()
    {
        $permissions = Permission::with('roles')->get();
        return response()->json($permissions);
    }

    public function updatePermission($id, Request $request)
    {
        $permission = Permission::find($id);
        $permission->update([
            'name' => $request->get('name'),
            'siderbar_name' => $request->get('siderbar_name'),
            'route_name' => $request->get('route_name'),
            'icon_class' => $request->get('icon_class')
        ]);
        return response()->json([
            'msg' => 'success'
        ]);
    }

    public function syncPermission(Request $request)
    {
        $permission = Permission::find($request->get('permission_id'));
        $roles = json_decode($request->get('roles'), true);
        $permission->syncRoles($roles);
        return response()->json([
            'msg' => 'success'
        ]);
    }

    public function syncRole(Request $request)
    {
        $role = Role::where('name', $request->get('role'))->first();
        $permissions = json_decode($request->get('permissions'), true);
        $role->syncPermissions($permissions);
        return response()->json([
            'msg' => 'success'
        ]);
    }

    public function syncPermissionUser(Request $request)
    {
        $user = User::find($request->get('user_id'));
        $permissions = json_decode($request->get('permissions'), true);
        $user->givePermissionTo($permissions);
        return response()->json([
            'msg' => 'success'
        ]);
    }

    public function access($id, Request $request)
    {
        $user = User::find($id);
        $user->update([
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password'))
        ]);
        return response()->json([
            'msg' => 'success'
        ]);
    }

    public function academicUsers()
    {

        $users = User::where('subarea_id', 4)->where('team_id', null)->get();

        return response()->json($users);
    }

    public function updatePhoto(Request $request)
    {
        $photoExistent = Image::where('imageable_id', $request->get('imageable_id'))->where('imageable_type', 'App\\Models\\User')->first();

        if ($request->hasFile('file')) {
            $fileName = time() . '.' . $request->file->getClientOriginalExtension();
            $request->file->move(public_path('files'), $fileName);
        }
        if ($photoExistent) {
            $photoExistent->update([
                'url' => $fileName
            ]);
            return response()->json($photoExistent);
        } else {
            $image = Image::create([
                'imageable_id' => $request->get('imageable_id'),
                'imageable_type' => 'App\\Models\\User',
                'url' => $fileName
            ]);
            return response()->json($image);
        }
    }
}
