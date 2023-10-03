<?php

namespace App\Http\Controllers;

use App\Events\NewDocument;
use App\Models\Order;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Comission;
use App\Models\Contract;
use App\Models\Customer;
use App\Models\Delivery;
use App\Models\Detail;
use App\Models\Fee;
use App\Models\Notification;
use App\Models\Payment;
use App\Models\Payments;
use App\Models\Project;
use App\Models\Quotation;
use App\Models\Seen;
use App\Models\User;
use Illuminate\Http\Request;
use Mockery\Undefined;
use PDF;
use Symfony\Component\CssSelector\Node\FunctionNode;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::with(['quotation', 'quotation.customers'])->get();

        return response()->json($orders);
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
     * @param  \App\Http\Requests\StoreOrderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Verificar si hay una orden con el id de cotización
        $order = Order::where('quotation_id', $request->get('quotation_id'))->first();

        $order = Order::create([
            'quotation_id' => $request->get('quotation_id'),
            'final_delivery' => $request->get('final_delivery'),
            'observations' => $request->get('observations'),
            'suggested' => $request->get('suggested')
        ]);

        $payments = json_decode($request->get('payments'), true);

        foreach ($payments as $payment) {
            $payment_registered = Payment::create([
                'paymentable_id' => $order->id,
                'paymentable_type' => 'App\Models\Order',
                'date' => $payment['date'],
                'amount' => $payment['amount']
            ]);

            Delivery::create([
                'deliverable_id' => $order->id,
                'deliverable_type' => 'App\Models\Order',
                'date' => $payment['date'],
                'advance' => 'Entrega de Orden',
                'type' => 1
            ]);
        }


        $quotation = Quotation::find($request->get('quotation_id'));

        $quotation->update([
            'discount' => $request->get('discount')
        ]);

        $customer = Customer::find($quotation->customer_id);

        $customer->update([
            'status' => 9
        ]);

        $user = User::find($request->get('user_id'));

        $comission = Comission::create([
            'customer_id' => $customer->id,
            'concept' => 'Cierre no pagado',
            'percent' => 15,
            'referal' => $user->name,
            'user_id' => $request->get('user_id')
        ]);

        return response()->json($order->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateOrderRequest  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $order = Order::with(['quotation', 'quotation.details'])->find($request->get('order_id'));

        $order->update([
            'final_delivery' => $request->get('final_delivery'),
            'observations' => $request->get('observations')
        ]);

        $order->quotation->update([
            'discount' => $request->get('discount')
        ]);

        $order->quotation->details->each(function ($detail) {
            $detail->delete();
        });

        $products = $request->get('products');

        $arrProds = json_decode($products, true);

        foreach ($arrProds as $prod) {
            $detail = Detail::create([
                'quotation_id' => $order->quotation->id,
                'product_id' => $prod['product_id'],
                'type' => $prod['type'],
                'description' => '-',
                'price' => $prod['price'],
                'level' => $prod['level'],
                'mode' => $prod['mode']
            ]);
        }

        $order->payments->each(function ($payment) {
            $payment->delete();
        });

        $payments = json_decode($request->get('payments'), true);

        foreach ($payments as $payment) {
            $payment_registered = Payment::create([
                'paymentable_id' => $order->id,
                'paymentable_type' => 'App\Models\Order',
                'date' => $payment['date'],
                'amount' => $payment['amount']
            ]);
        }


        return response()->json([
            'msg' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }

    public function generateContract($id)
    {
        $contract = Contract::with(['quotation', 'quotation.details', 'quotation.details.product', 'quotation.customers', 'payments', 'projects', 'projects.deliveries'])->find($id);
        /* $customer = Customer::with(['quotations' => function ($query) {
            $query->orderBy('id', 'desc')->with(['contract' => function ($query2) {
                $query2->orderBy('id', 'desc')->with(['payments', 'deliveries'])->first();
            }])->first();
        }])->find($id); */
        $pdf = PDF::loadView('contract', compact('contract'));
        return $pdf->stream('prueba.pdf');
    }

    public function insertOrder(Request $request)
    {
        $payments = json_decode($request->get('payments'), true);

        $request->validate([
            'final_delivery' => 'required',
            'observations' => 'required',
            'payments' => 'required',
            'payments.*.date' => 'required'
        ]);

        $customers = json_decode($request->get('customers'), true);

        $quotation = Quotation::with(['order', 'customers', 'order.payments', 'details'])->where('id', $request->get('quotation_id'))->first();

        $customersId = [];

        foreach ($customers as $customer) {
            array_push($customersId, $customer['id']);
        }

        $quotation->customers()->sync($customersId);

        $quotation->details->each->delete();

        $products = $request->get('products');

        $arrProds = json_decode($products, true);

        foreach ($arrProds as $prod) {
            $detail = Detail::create([
                'quotation_id' => $quotation->id,
                'product_id' => $prod['product_id'],
                'type' => $prod['type'],
                'description' => '-',
                'price' => $prod['price'],
                'extra_price' => $prod['extra_price'],
                'level' => $prod['level']
            ]);
        }
        $quotation->update([
            'discount'  => $request->get('discount')
        ]);
        if ($quotation->order != null) {
            $quotation->order->payments->each->delete();
            $quotation->order->update([
                'final_delivery' => $request->get('final_delivery'),
                'observations' => $request->get('observations'),
                'suggested' => $request->get('suggested')
            ]);
            $order = $quotation->order;
        } else {
            $order = Order::create($request->all());
        }


        $project = Project::create([
            'projectable_id' => $order->id,
            'projectable_type' => 'App\Models\Order',
            'title' => 'Proyecto #' . $order->id,
            'user_id' => $request->get('user_id'),
            'status' => 0
        ]);




        foreach ($payments as $payment) {
            $payment_registered = Payment::create([
                'paymentable_id' => $order->id,
                'paymentable_type' => 'App\Models\Order',
                'date' => $payment['date'],
                'amount' => $payment['amount']
            ]);
            $delivery = Delivery::create([
                'advance' => '',
                'status' => 0,
                'project_id' => $project->id,
                'date' => $payment['date'],
                'type' => 2
            ]);
        }

        $quotation->customers->each->update([
            'status' => 9
        ]);

        $user = User::find($request->get('user_id'));

        /*  $comission = Comission::create([
            'customer_id' => $customer->id,
            'concept' => 'Cotización',
            'percent' => 5,
            'referal' => $user->name,
            'user_id' => $request->get('user_id')
        ]); */

        /*  $notification = Notification::create([
            'emisor_id' => $request->get('user_id'),
            'content' => 'generó la orden de ' . $customer->name,
            'type' => 1
        ]);

        $usersToNotify = User::role('Seller')->get();

        foreach ($usersToNotify as $user) {
            Seen::create([
                'user_id' => $user->id,
                'notification_id' => $notification->id,
                'seen' => 0
            ]);
        } */

        broadcast(new NewDocument($order));

        return response()->json($order->id);
    }
}
