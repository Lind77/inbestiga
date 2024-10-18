<?php

namespace App\Http\Controllers;

use App\Events\NewCustomer;
use App\Events\NewDocument;
use App\Models\Quotation;
use App\Http\Requests\StoreQuotationRequest;
use App\Http\Requests\UpdateQuotationRequest;
use App\Models\Comission;
use App\Models\Contract;
use App\Models\Customer;
use App\Models\Detail;
use App\Models\External_voucher;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Promotion;
use App\Models\Seen;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;
use Illuminate\Support\Facades\Hash;

class QuotationController extends Controller
{
    /**
     * Muestra una lista de las cotizaciones.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $quotations = Quotation::with(['customers', 'details', 'details.product'])->orderBy('date', 'desc')->take(10)->get();
        return response()->json($quotations);
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
     * Almacena una nueva cotización en la base de datos.
     *
     * @param  \App\Http\Requests\StoreQuotationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required',
            'expiration_date' => 'required',
            'term' => 'required'
        ]);


        $quotation = Quotation::create([
            'customer_id' => $request->get('customer_id'),
            'date' => $request->get('date'),
            'amount' => $request->get('amount'),
            'expiration_date' => $request->get('expiration_date'),
            'discount' => $request->get('discount'),
            'term' => $request->get('term'),
            'note' => $request->get('note'),
            'status' => 5
        ]);

        $products = $request->get('products');

        $arrProds = json_decode($products, true);

        foreach ($arrProds as $prod) {
            $detail = Detail::create([
                'quotation_id' => $quotation->id,
                'product_id' => $prod['product_id'],
                'type' => $prod['type'],
                'description' => '-',
                'price' => $prod['price'],
                'level' => intval($prod['level']) - 1,
                'mode' => $prod['mode'],
                'extra_price' => $prod['extra_price'],
                'name' => $prod['product']['name']
            ]);
        }

        $customers = json_decode($request->get('customers'), true);

        foreach ($customers as $customer) {
            $quotation->customers()->attach($customer['id']);
            $customer = Customer::find($customer['id'])->update([
                'status' => 5
            ]);
        }

        $user = User::find($request->get('user_id'));

        $comission = Comission::create([
            'customer_id' => null,
            'concept' => 'Cotización',
            'percent' => 5,
            'referal' => $user->name,
            'user_id' => $request->get('user_id')
        ]);

        /*  $notification = Notification::create([
            'emisor_id' => $request->get('emisor_id'),
            'content' => 'generó la cotización de '.$customer->name,
            'type' => 1
        ]);

        $usersToNotify = User::role('Seller')->get(); */

        /*   foreach($usersToNotify as $user){
            Seen::create([
                'user_id' => $user->id,
                'notification_id' => $notification->id,
                'seen' => 0
            ]);
        } */

        //broadcast(new NewDocument($quotation));

        return response()->json([
            'msg' => 'success',
            'id' => $quotation->id
        ]);

        /* return  */

        /* foreach($products as $product){
            
        }

        

        

        foreach($sugested_products as $product){
            $detail = Detail::create([
                'product_id' => $product['id'],
                'quotation_id' => $quotation->id,
                'type' => 2
            ]);
        }
 */


        /* 

        $price = 0;

        foreach($products as $product){
            foreach($product['amount'] as $amount){
                $price = $price+$amount['price'];
            }
        }

        

        
        
         */
    }
    /**
     * Genera un PDF de la cotización especificada.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function generatePDF($id)
    {

        $quotation = Quotation::find($id);
        $customer = Customer::find($quotation->customer_id);
        $details = Detail::with('product')->where('quotation_id', $quotation->id)->get();

        $data = [
            'quotation' => $quotation,
            'customer' => $customer,
            'details' => $details
        ];
        return view('quotation', compact('quotation', 'customer', 'details'));
    }

    /**
     * Muestra la cotización especificada.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $quotation = Quotation::where('id', $id)->with(['customers', 'customers.province', 'customers.province.department', 'customers.province.department.provinces', 'customers.user', 'customers.comunications', 'details', 'details.product', 'order', 'contract', 'contract.projects', 'contract.projects.team', 'contract.projects.team.users', 'contract.projects.team.users.roles', 'contract.projects.files', 'contract.projects.posts' => function ($query) {
            $query->orderBy('id', 'desc')->get();
        }, 'contract.projects.posts.files', 'contract.properties' => function ($query) {
            $query->orderBy('id', 'desc')->first();
        }])->orderBy('created_at', 'desc')->first();

        return $quotation;

        return response()->json($quotation);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function edit(Quotation $quotation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateQuotationRequest  $request
     * @param  \App\Models\Quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateQuotationRequest $request, Quotation $quotation)
    {
        //
    }

    /**
     * Elimina la cotización especificada de la base de datos.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $quotation = Quotation::find($id);
        $quotation->customers->each->update([
            'status' => 4
        ]);
        $quotation->delete();
        return response()->json([
            'msg' => 'No existe cotización'
        ]);
    }
    /**
     * Obtiene la cotización asociada al ID del cliente.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getQuotationByCustomerId($id)
    {
        $customer = Customer::find($id);

        $quotation = Quotation::where('customer_id', $customer->id)->orderBy('id', 'desc')->with(['details', 'details.product', 'details.new_product', 'order', 'order.payments', 'contract', 'contract.fees'])->get();

        if (count($quotation) != 0) {
            return response()->json($quotation[0]);
        } else {
            return response()->json([
                'msg' => 'No existe cotización'
            ]);
        }
    }
    /**
     * Obtiene la cotización asociada a una orden específica.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getQuotationByOrder($id)
    {
        $order = Order::where('id', $id)->with(['quotation', 'quotation.customers', 'quotation.details', 'quotation.details.product', 'quotation.details.product', 'payments'])->first();

        return response()->json($order);
    }
    /**
     * Actualiza una cotización existente.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateQuotation(Request $request)
    {
        $discount = 0;

        if ($request->get('coupon') != '') {
            $coupon = $request->get('coupon');

            $promotion = Promotion::where('code', $coupon)->first();
            if ($promotion->limit == 0) {
                $discount = $request->get('discount');
            } else if ($promotion->limit < $promotion->discounted + 1) {
                $discount = 0;
                return response()->json('No se realizó el descuento', 402);
            } else {
                $discount = $request->get('discount');
                $promotion->update([
                    'discounted' => $promotion->discounted + 1
                ]);
            }
        }
        $quotation = Quotation::with('customers')->find($request->get('quotation_id'));

        $quotation->update([
            'date' => $request->get('date'),
            'amount' => $request->get('amount'),
            'expiration_date' => $request->get('expirationDay'),
            'discount' => $discount,
            'term' => $request->get('term')
        ]);

        $quotation->details()->delete();

        $products = json_decode($request->get('products'), true);


        foreach ($products as $product) {
            $detail = Detail::create([
                'quotation_id' => $quotation->id,
                'product_id' => $product['product_id'],
                'type' => $product['type'],
                'description' => '-',
                'price' => $product['price'],
                'level' => $product['level'],
                'mode' => $product['mode']
            ]);
        }

        //$customer = $quotation->customer;

        /*  $notification = Notification::create([
            'emisor_id' => $request->get('emisor_id'),
            'content' => 'generó la cotización de '.$customer->name,
            'type' => 1
        ]);

        $usersToNotify = User::role('Seller')->get();

        foreach($usersToNotify as $user){
            Seen::create([
                'user_id' => $user->id,
                'notification_id' => $notification->id,
                'seen' => 0
            ]);
        }

        broadcast(new NewDocument($quotation)); */

        return response()->json([
            'msg' => 'success',
            'id' => $quotation->id
        ]);
    }
    /**
     * Busca cotizaciones basadas en el nombre del cliente.
     *
     * @param string $search El término de búsqueda.
     * @return \Illuminate\Http\JsonResponse La respuesta JSON con las cotizaciones encontradas.
     */
    public function search($search)
    {
        $quotations = Quotation::with('customers')
            ->whereHas('customers', function ($query) use ($search) {
                $query->whereRaw('LOWER(name) like ?', ['%' . strtolower($search) . '%']);
            })->get();

        return response()->json($quotations);
    }
    /**
     * Busca cotizaciones por fecha.
     *
     * @param string $date La fecha a buscar.
     * @return \Illuminate\Http\JsonResponse La respuesta JSON con las cotizaciones encontradas.
     */
    public function searchQuotationsByDate($date)
    {
        $quotations = Quotation::with('customer')->where('date', $date)->get();
        return response()->json($quotations);
    }
    /**
     * Establece una relación entre un cliente y una cotización.
     *
     * @param int $customerId El ID del cliente.
     * @param int $quotationId El ID de la cotización.
     * @return \Illuminate\Http\JsonResponse La respuesta JSON indicando el éxito de la operación.
     */
    public function quotationCustomer($customerId, $quotationId)
    {
        DB::table('customer_quotation')->insert([
            'customer_id' => $customerId,
            'quotation_id' => $quotationId
        ]);
        return response()->json([
            'msg' => 'success'
        ]);
    }
    /**
     * Elimina la relación entre un cliente y una cotización.
     *
     * @param int $customerId El ID del cliente.
     * @param int $quotationId El ID de la cotización.
     * @return \Illuminate\Http\JsonResponse La respuesta JSON indicando el éxito de la operación.
     */
    public function deleteQuotationCustomer($customerId, $quotationId)
    {
        $relationship = DB::table('customer_quotation')->where('customer_id', $customerId)->where('quotation_id', $quotationId)->delete();
        return response()->json([
            'msg' => 'success'
        ]);
    }
    /**
     * Obtiene las cotizaciones agrupadas por estado para un usuario específico.
     *
     * @param int $id El ID del usuario.
     * @return \Illuminate\Support\Collection Las cotizaciones agrupadas por estado.
     */
    public function getQuotationsFunnel($id)
    {
        $customers = Customer::whereHas('quotations')->where('user_id', $id)->get();

        $quotationsNonFiltered = Quotation::whereHas('customers', function ($query) use ($id) {
            $query->where('user_id', $id);
        })->with(['customers', 'customers.comunications', 'customers.user'])->whereIn('status', range(5, 10))->orderBy('updated_at', 'desc')->get()->groupBy('status')
            ->map(function ($group) {
                return $group->take(10)->values(); // Tomamos solo los primeros 10 de cada grupo
            })
            ->flatten(1);
        return $quotationsNonFiltered;

        /* $totalQuotations = collect();

        for ($i = 5; $i < 11; $i++) {
            $quotations = Quotation::with(['customers' => function ($q) use ($id) {
                $q->where('user_id', $id);
            }, 'customers.comunications', 'customers.user'])->where('status', $i)->orderBy('updated_at', 'desc')->take(10)->get();

            $totalQuotations = $totalQuotations->merge($quotations);
        }
 */
        return response()->json($customers);
    }
    /**
     * Actualiza la calificación del cliente y, si es necesario, la contraseña.
     *
     * @param \Illuminate\Http\Request $request La solicitud con los datos a actualizar.
     * @return \Illuminate\Http\JsonResponse La respuesta JSON indicando el éxito de la operación.
     */
    public function updateCustomerGrade(Request $request)
    {
        $status = $request->get('status');
        $quotation = Quotation::find($request->get('quotation_id'));


        if ($status >= 3) {
            $quotation->update([
                'status' => $request->get('status')
            ]);

            $user = User::find($request->get('user_id'));
        }

        if ($status == 11) {
            $quotation->customers->each(function ($customer) use ($quotation) {
                $customer->update([
                    'password' => Hash::make($customer->dni)
                ]);
            });
        }



        broadcast(new NewCustomer($user));

        /* $eleventhCustomer = Customer::where('status', $oldStatus)->orderBy('updated_at', 'desc')->offset(10)->first(); */
        $quotation->customers->each->update([
            'status' => $request->get('status')
        ]);
        return response()->json([
            'msg' => 'success',
            /* 'eleventhCustomer' => $eleventhCustomer */
        ]);
    }
    /**
     * Actualiza el estado de un cliente.
     *
     * @param \Illuminate\Http\Request $request La solicitud con los datos del cliente a actualizar.
     * @return \Illuminate\Http\JsonResponse La respuesta JSON indicando el éxito de la operación.
     */
    public function updateCustomerStatus(Request $request)
    {
        $customer = Customer::find($request->get('customer_id'));
        $customer->update([
            'status' => $request->get('status')
        ]);
        return response()->json([
            'msg' => 'success',
            /* 'eleventhCustomer' => $eleventhCustomer */
        ]);
    }
    /**
     * Busca clientes, cotizaciones y contratos basados en un término de búsqueda.
     *
     * @param string $search El término de búsqueda.
     * @return \Illuminate\Http\JsonResponse La respuesta JSON con los clientes, cotizaciones y contratos encontrados.
     */
    public function searchQuotations($search)
    {
        $customers = Customer::where('name', 'like', '%' . $search . '%')->orWhere('cell', 'like', '%' . $search . '%')->orderBy('updated_at', 'desc')->get();

        $quotations = Quotation::with('customers')->whereHas('customers', function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%')->orWhere('cell', 'like', '%' . $search . '%');
        })->orderBy('updated_at', 'desc')->get();


        $contracts = Contract::with(['quotation', 'quotation.customers'])
            ->whereHas('quotation.customers', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')->orWhere('cell', 'like', '%' . $search . '%');
            })
            ->orderBy('updated_at', 'desc')
            ->get();

        return response()->json([
            'customers' => $customers,
            'quotations' => $quotations,
            'contracts' => $contracts
        ]);
    }
    /**
     * Filtra las cotizaciones que no tienen un estado igual a 11.
     *
     * @return \Illuminate\Http\JsonResponse La respuesta JSON con las cotizaciones filtradas.
     */
    public function filterQuotations()
    {
        $quotations = Quotation::with('customers')->where('status', '!=', 11)->orderBy('id', 'desc')->paginate(300);
        return response()->json([
            'quotations' => $quotations
        ]);
    }
    /**
     * Filtra cotizaciones entre dos fechas.
     *
     * @param \Illuminate\Http\Request $request La solicitud con las fechas de inicio y fin.
     * @return \Illuminate\Http\JsonResponse La respuesta JSON con las cotizaciones filtradas.
     */
    public function filterDates(Request $request)
    {

        $from = $request->get('startDate');
        $to = $request->get('endDate');

        $quotations = Quotation::with('customers')->whereBetween('date', [$from, $to])->where('status', '!=', 11)->orderBy('id', 'desc')->paginate(300);
        return response()->json([
            'quotations' => $quotations
        ]);
    }
    /**
     * Obtiene los clientes de un usuario específico que tienen cotizaciones activas.
     *
     * @return \Illuminate\Http\JsonResponse La respuesta JSON con los clientes encontrados.
     */
    public function customersLobo()
    {

        $quotations = Customer::where('user_id', 72)->whereHas('quotations', function ($query) {
            $query->where('status', '!=', 11);
        })->get();

        return response()->json($quotations);
    }
    /**
     * Obtiene las cotizaciones con vouchers externos asociados y que tienen un estado igual a 11.
     *
     * @return \Illuminate\Http\JsonResponse La respuesta JSON con las cotizaciones encontradas.
     */
    public function quotationVouchers()
    {
        /* $quotations = Quotation::with(['contract', 'contract.external_vouchers', 'contract.external_vouchers.images', 'contract.projects', 'customers'])->whereHas('contract.external_vouchers')->where('status', 11)->orderBy('updated_at', 'desc')->paginate(20); */

        $external_vouchers = External_voucher::with(['customer', 'contract', 'contract.user', 'images'])->orderBy('created_at', 'asc')->get();

        return response()->json($external_vouchers);
    }
    /**
     * Actualiza el estado de un voucher externo.
     *
     * @param string $voucherStatus El nuevo estado del voucher.
     * @param int $voucherId El ID del voucher a actualizar.
     * @return \Illuminate\Http\JsonResponse La respuesta JSON indicando el éxito de la operación.
     */
    public function statusVoucher($voucherStatus, $voucherId)
    {
        $external_voucher = External_voucher::find($voucherId);

        $external_voucher->update([
            'status' => $voucherStatus
        ]);

        return response()->json([
            'msg' => 'success'
        ]);
    }
}
