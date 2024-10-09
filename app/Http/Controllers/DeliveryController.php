<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Http\Requests\StoreDeliveryRequest;
use App\Http\Requests\UpdateDeliveryRequest;
use App\Models\Academic_process;
use App\Models\Assigned_activity;
use App\Models\Payment;
use App\Models\Project;
use App\Models\Quality_indicator;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * Class DeliveryController
 *
 * Controlador para gestionar entregas en el sistema.
 * Incluye métodos para crear, actualizar, eliminar y buscar entregas.
 *
 * @package App\Http\Controllers
 */
class DeliveryController extends Controller
{
     /**
     * Muestra una lista de todas las entregas del día actual.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $deliveries = Delivery::with(['project', 'project.projectable', 'project.projectable.quotation', 'project.projectable.quotation.customers'])->where('date', date('Y-m-d'))->get();
        return response()->json([
            'deliveries' => $deliveries
        ]);
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
     * Almacena una nueva entrega en la base de datos.
     *
     * @param  \App\Http\Requests\StoreDeliveryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $delivery = Delivery::create([
            'academic_date' => $request->get('dateAcad'),
            'advance' => $request->get('advance'),
            'type' => $request->get('type'),
            'status' => 0,
            'project_id' => $request->get('project_id'),
            'date' => $request->get('date')
        ]);

        return response()->json([
            'msg' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Delivery  $delivery
     * @return \Illuminate\Http\Response
     */
    public function show(Delivery $delivery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Delivery  $delivery
     * @return \Illuminate\Http\Response
     */
    public function edit(Delivery $delivery)
    {
        //
    }

     /**
     * Actualiza una entrega específica en la base de datos.
     *
     * @param  \App\Http\Requests\UpdateDeliveryRequest  $request
     * @param  int  $id  El ID de la entrega a actualizar.
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $delivery = Delivery::with(['contract', 'contract.quotation', 'contract.quotation.customer'])->find($id);
        $delivery->update([
            'academic_date' => $request->get('academicDate')
        ]);
        return response()->json([
            'msg' => 'success',
            'delivery' => $delivery
        ]);
    }
    /**
     * Actualiza información adicional de una entrega específica.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id  El ID de la entrega a actualizar.
     * @return \Illuminate\Http\Response
     */
    public function updateInfo(Request $request, $id)
    {

        $delivery = Delivery::find($id);

        $delivery->update([
            'date' => $request->get('date'),
            'description' => $request->get('description')
        ]);

        return response()->json([
            'msg' => 'success'
        ]);
    }

    /**
     * Elimina una entrega específica de la base de datos.
     *
     * @param  int  $id  El ID de la entrega a eliminar.
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delivery = Delivery::find($id);
        $delivery->delete();
        return response()->json([
            'msg' => 'success'
        ]);
    }
    /**
     * Obtiene las entregas de un día específico.
     *
     * @param  string  $date  La fecha para filtrar las entregas.
     * @return \Illuminate\Http\Response
     */
    public function getDeliveriesByDate($date)
    {
        $deliveries = Delivery::with(['project', 'project.projectable', 'project.projectable.quotation', 'project.projectable.quotation.customers'])->where('date', $date)->get();
        $payments = Payment::where('date', $date)->get();

        return response()->json([
            'deliveries' => $deliveries,
            'payments' => $payments
        ]);
    }
     /**
     * Busca entregas basado en un término de búsqueda.
     *
     * @param  string  $search  El término de búsqueda.
     * @return \Illuminate\Http\Response
     */
    public function search($search)
    {
        $deliveries = Delivery::with(['deliverable', 'deliverable.quotation', 'deliverable.quotation.customer'])
            ->whereHas('deliverable.quotation.customer', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })->get();

        return response()->json($deliveries);
    }
    /**
     * Marca una entrega como verificada.
     *
     * @param  int  $id  El ID de la entrega a verificar.
     * @return \Illuminate\Http\Response
     */
    public function checkDelivery($id)
    {
        $delivery = Delivery::find($id);
        $delivery->update([
            'type' => 2
        ]);
        return response()->json([
            'msg' => 'success'
        ]);
    }
    /**
     * Obtiene las entregas de un mes específico.
     *
     * @param  string  $month  El mes para filtrar las entregas.
     * @return \Illuminate\Http\Response
     */
    public function deliveriesMonth($month)
    {
        /* $deliveries = Project::with('deliveries')->get(); */
        $deliveries = Delivery::has('project')->where('date', 'like', $month . '-%')->with(['project', 'project.projectable', 'project.projectable.quotation', 'project.projectable.quotation.customers', 'user'])->get();

        return response()->json([
            'deliveries' => $deliveries
        ]);
    }
      /**
     * Procesa un sprint para una entrega específica.
     *
     * @param  int  $pid  El ID del proceso académico.
     * @param  int  $id  El ID de la entrega.
     * @return \Illuminate\Http\Response
     */
    public function processSprint($pid, $id)
    {
        $delivery = Delivery::find($id);

        $academic_process = Academic_process::with(['academic_products', 'academic_products.acceptance_indicators'])->find($pid);

        foreach ($academic_process->academic_products as $productAcad) {
            $assigned_activity = Assigned_activity::create([
                'assigned_activitiable_id' =>   $id,
                'assigned_activitiable_type' => 'App\Models\Delivery',
                'name' => $productAcad->name,
                'academic_process_id' => $academic_process->id
            ]);

            foreach ($productAcad->acceptance_indicators as $indicator) {
                $quality_indicator = Quality_indicator::create([
                    'quality_indicable_id' => $assigned_activity->id,
                    'quality_indicable_type' => 'App\Models\Assigned_activity',
                    'name' => $indicator->name
                ]);
            }
        }

        return response()->json([
            'msg' => 'success'
        ]);
    }
    /**
     * Cambia el usuario asociado a una entrega.
     *
     * @param  int  $deliveryId  El ID de la entrega.
     * @param  int  $userId  El ID del usuario a asignar.
     * @return \Illuminate\Http\Response
     */
    public function changeColorEvent($deliveryId, $userId)
    {
        $delivery = Delivery::find($deliveryId);
        $delivery->update([
            'user_id' => $userId
        ]);

        $user = User::find($userId);

        return response()->json([
            'msg' => 'success',
            'user' => $user
        ]);
    }
}
