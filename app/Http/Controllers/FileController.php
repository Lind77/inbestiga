<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use FileFacade;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //$fileName = time() . '.' . $request->file->getClientOriginalExtension();
        $fileName = $request->file->getClientOriginalName();
        $url = $request->file->move(public_path('files'), $fileName);

        $file = File::create([
            'fileable_id' => $request->get('user_id'),
            'fileable_type' => 'App\\Models\\User',
            'url' => $fileName
        ]);

        return response()->json(['success' => 'You have successfully upload file.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $files = File::where('fileable_id', $id)->get();

        return response()->json($files);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $file = File::find($id);

        $rutaArchivo = public_path('files/' . $file->url);

        // Verificar si el archivo existe antes de intentar eliminarlo
        if (FileFacade::exists($rutaArchivo)) {
            $file->delete();
            FileFacade::delete($rutaArchivo);
            return response()->json([
                'msg' => 'Archivo eliminado'
            ]);
        } else {
            return response()->json([
                'msg' => 'Archivo no encontrado'
            ]);
        }
    }

    public function filesProject(Request $request)
    {
        $fileName = $request->file->getClientOriginalName();
        $url = $request->file->move(public_path('files'), $fileName);

        $file = File::create([
            'fileable_id' => $request->get('project_id'),
            'fileable_type' => 'App\\Models\\Project',
            'url' => $fileName
        ]);

        return response()->json(['success' => 'You have successfully upload file.']);
    }
}
