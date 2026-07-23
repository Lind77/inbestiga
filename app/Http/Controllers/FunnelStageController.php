<?php

namespace App\Http\Controllers;

use App\Models\FunnelStage;
use Illuminate\Http\Request;

class FunnelStageController extends Controller
{
    /**
     * Display a listing of funnel stages.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stages = FunnelStage::orderBy('order', 'asc')->get();

        if ($stages->isEmpty()) {
            $defaultStages = [
                ['name' => 'Usuarios', 'order' => 1, 'color_status' => 'warning', 'is_system' => true],
                ['name' => 'Cotizaciones', 'order' => 2, 'color_status' => 'info', 'is_system' => true],
                ['name' => 'Contratos', 'order' => 3, 'color_status' => 'success', 'is_system' => true],
            ];

            foreach ($defaultStages as $stage) {
                FunnelStage::create($stage);
            }

            $stages = FunnelStage::orderBy('order', 'asc')->get();
        }

        return response()->json($stages);
    }

    /**
     * Store a newly created funnel stage in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        $maxOrder = FunnelStage::max('order') ?? 0;

        $stage = FunnelStage::create([
            'name' => $request->name,
            'order' => $maxOrder + 1,
            'color_status' => $request->color_status ?? 'primary',
            'is_system' => false
        ]);

        return response()->json([
            'msg' => 'Columna creada exitosamente',
            'stage' => $stage
        ], 201);
    }

    /**
     * Update the specified funnel stage in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        $stage = FunnelStage::findOrFail($id);
        $stage->name = $request->name;

        if ($request->has('color_status')) {
            $stage->color_status = $request->color_status;
        }

        $stage->save();

        return response()->json([
            'msg' => 'Columna actualizada exitosamente',
            'stage' => $stage
        ]);
    }

    /**
     * Remove the specified funnel stage from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $stage = FunnelStage::findOrFail($id);

        if ($stage->is_system) {
            return response()->json([
                'msg' => 'No se puede eliminar una columna de sistema'
            ], 422);
        }

        $stage->delete();

        return response()->json([
            'msg' => 'Columna eliminada correctamente'
        ]);
    }
}
