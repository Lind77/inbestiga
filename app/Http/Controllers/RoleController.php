<?php

namespace App\Http\Controllers;

use App\Models\Subarea;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Muestra una lista de los roles disponibles con sus permisos asociados.
     *
     * @return \Illuminate\Http\Response Lista de roles.
     */
    public function index()
    {
        $roles = Role::with('permissions')->get();
        return $roles;
    }
    /**
     * Muestra los roles ordenados por jerarquía.
     *
     * @return \Illuminate\Http\Response Lista de roles ordenados por jerarquía.
     */
    public function hierarchy()
    {
        $roles = Role::with('permissions')->orderBy('hierarchy')->get();
        return $roles;
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
     * Almacena un nuevo rol en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request La solicitud con los datos del nuevo rol.
     * @return \Illuminate\Http\Response El rol creado.
     */
    public function store(Request $request)
    {
        $subarea = Subarea::find($request->get('subarea_id'));

        $role = Role::create([
            'name' => $request->get('name'),
            'guard_name' => 'web',
            'subarea_id' => $subarea->id,
            'roleable_id' => $subarea->area_id,
            'roleable_type' => 'App\\Models\\Area'
        ]);
        return $role;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Actualiza el rol especificado en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request La solicitud con los datos a actualizar.
     * @param  int  $id El ID del usuario cuyo rol se va a actualizar.
     * @return \Illuminate\Http\Response Mensaje de éxito.
     */
    public function update(Request $request, $id)
    {
        $user = User::with('roles')->find($id);

        $role = Role::find($request->get('newRole'));

        $user->update([
            'subarea_id' => $role->subarea_id
        ]);

        $user->syncRoles([$role->name]);

        return response()->json([
            'msg' => 'Role updated successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    /**
     * Obtiene todos los roles disponibles en la base de datos.
     *
     * @return \Illuminate\Http\Response Lista de roles.
     */
    public function getAllRoles()
    {
        $roles = Role::all();
        return $roles;
    }
}
