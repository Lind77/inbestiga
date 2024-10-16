<?php

namespace App\Http\Controllers;

use App\Events\NewPost;
use App\Models\File;
use App\Models\Post;
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

    public function fileArchive(Request $request)
    {
        $fileName = $request->file->getClientOriginalName();
        $url = $request->file->move(public_path('files'), $fileName);

        $file = File::create([
            'fileable_id' => $request->get('project_id'),
            'fileable_type' => 'App\\Models\\Project',
            'url' => $fileName,
            'type' => 1,
            'status' => $request->get('status')
        ]);

        return response()->json(['success' => 'You have successfully upload file.']);
    }

    public function filePost(Request $request)
    {
        $post = Post::create([
            'postable_id' => $request->get('user_id'),
            'postable_type' => $request->get('postable_type'),
            'title' => $request->get('title'),
            'body' => $request->get('body'),
            'project_id' => $request->get('project_id'),
        ]);

        if ($request->hasFile('file')) {
            $fileName = $request->file->getClientOriginalName();
            $url = $request->file->move(public_path('files'), $fileName);
            $file = File::create([
                'fileable_id' => $post->id,
                'fileable_type' => 'App\\Models\\Post',
                'url' => $fileName,
                'type' => 3,
                'status' => 0
            ]);
        }

        $post->load('postable');

        broadcast(new NewPost($post));

        return response()->json(['success' => 'You have successfully upload file.']);
    }

    public function enableFilePost($id)
    {
        $file = File::find($id);
        $file->update([
            'type' => 3
        ]);
        return response()->json(['success' => 'You have successfully upload file.']);
    }
}
