<?php

namespace App\Http\Controllers;

use App\Events\NewDocument;
use App\Models\Quotation;
use App\Http\Requests\StoreQuotationRequest;
use App\Http\Requests\UpdateQuotationRequest;
use App\Models\Comission;
use App\Models\Customer;
use App\Models\Detail;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Promotion;
use App\Models\Seen;
use App\Models\User;
use Illuminate\Http\Request;
use PDF;

class QuotationController extends Controller
{
    /**
     * Display a listing of the resource.
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
     * Store a newly created resource in storage.
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
     * Display the specified resource.
     *
     * @param  \App\Models\Quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $quotation = Quotation::where('id', $id)->with(['customers', 'customers.user', 'customers.comunications', 'details', 'details.product', 'order', 'contract', 'contract.projects', 'order.properties', 'contract.properties'])->first();

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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Quotation  $quotation
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

    public function getQuotationByOrder($id)
    {
        $order = Order::where('id', $id)->with(['quotation', 'quotation.customers', 'quotation.details', 'quotation.details.product', 'quotation.details.product', 'payments'])->first();

        return response()->json($order);
    }

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

    public function search($search)
    {
        $quotations = Quotation::with('customers')
            ->whereHas('customers', function ($query) use ($search) {
                $query->whereRaw('LOWER(name) like ?', ['%' . strtolower($search) . '%']);
            })->get();

        return response()->json($quotations);
    }

    public function searchQuotationsByDate($date)
    {
        $quotations = Quotation::with('customer')->where('date', $date)->get();
        return response()->json($quotations);
    }

    public function getQuotationsFunnel()
    {
        $totalQuotations = collect();

        for ($i = 5; $i < 11; $i++) {
            $quotations = Quotation::with(['customers', 'customers.comunications', 'customers.user'])->where('status', $i)->orderBy('updated_at', 'desc')->take(10)->get();

            $totalQuotations = $totalQuotations->merge($quotations);
        }

        return response()->json($totalQuotations);
    }

    public function updateCustomerGrade(Request $request)
    {
        $status = $request->get('status');
        $quotation = Quotation::find($request->get('quotation_id'));


        if ($status >= 3) {
            $quotation->update([
                'status' => $request->get('status')
            ]);

            $user = User::find($request->get('user_id'));

            $comissionData = [
                'quotation_id' => $quotation->id,
                'referal' => $user->name,
                'user_id' => $request->get('user_id')
            ];

            switch ($request->get('status')) {
                    /*  case 3:
                    $comissionData['concept'] = 'Obtención de datos';
                    $comissionData['percent'] = 2;
                    break; */
                case 4:
                    $comissionData['concept'] = 'Obtención de necesidades específicas';
                    $comissionData['percent'] = 8;
                    break;
                case 5:
                    $comissionData['concept'] = 'Cotización';
                    $comissionData['percent'] = 5;
                    break;
                case 6:
                    $comissionData['concept'] = 'Explicación de la cotización';
                    $comissionData['percent'] = 5;
                    break;
                case 7:
                    $comissionData['concept'] = 'Explicación de la experiencia';
                    $comissionData['percent'] = 15;
                    break;
                case 8:
                    $comissionData['concept'] = 'Seguimientos';
                    $comissionData['percent'] = 15;
                    break;
                case 9:
                    $comissionData['concept'] = 'Cierre no pagado';
                    $comissionData['percent'] = 15;
                    break;
                case 10:
                    $comissionData['concept'] = 'Seguimiento de cierre';
                    $comissionData['percent'] = 10;
                    break;
                case 11:
                    $comissionData['concept'] = 'Gestión Documental';
                    $comissionData['percent'] = 2;
                    break;
            }

            $comission = Comission::where('quotation_id', $request->get('quotation_id'))->where('user_id', $request->get('user_id'))->where('concept', $comissionData['concept'])->first();

            if (!$comission) {
                $newComission = Comission::create($comissionData);
            }
        }

        $oldStatus = intval($request->get('status')) - 1;

        /* $eleventhCustomer = Customer::where('status', $oldStatus)->orderBy('updated_at', 'desc')->offset(10)->first(); */
        $quotation->customers->each->update([
            'status' => $request->get('status')
        ]);
        return response()->json([
            'msg' => 'success',
            /* 'eleventhCustomer' => $eleventhCustomer */
        ]);
    }

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

    public function searchQuotations($search)
    {
        $quotations = Quotation::with(['customers', 'customers.comunications', 'customers.user'])->whereHas('customers', function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%')->orWhere('cell', 'like', '%' . $search . '%')->orWhere('university', 'like', '%' . $search . '%')->orWhere('career', 'like', '%' . $search . '%');
        })->get();

        return response()->json($quotations);
    }
}
