<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Comission;
use App\Models\Comunication;
use App\Models\Detail;
use App\Models\NewProduct;
use App\Models\Origin;
use App\Models\Quotation;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::with(['project','project.product', 'comunications','quotations', 'quotations.order'])->orderBy('updated_at', 'desc')->take(10)->get();
        return response()->json($customers);
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
     * @param  \App\Http\Requests\StoreCustomerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCustomerRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = Customer::with(['quotations' => function($query){
            $query->with(['details', 'details.new_product', 'details.new_product.newprices', 'order', 'contract','contract.fees','contract.deliveries'])->orderBy('created_at', 'desc')->first();
        }])->find($id);
        return response()->json($customer);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCustomerRequest  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //
    }

    public function insertCustomer(Request $request){

        if($request->get('cell') != null){
            $request->validate([
                'cell' => 'unique:customers|max:12|min:9'
            ]);
        }
        

        $time = strtotime($request->get('next_management'));
        $date = date('Y-m-d', $time);
        $hour = date('H:i:s', $time);
        $customer = Customer::create($request->all());

        if($request->get('referedFrom') != 0){
            $origin = Origin::create([
                'customer_id' => $customer->id,
                'type' => $request->get('origin'),
                'channel' => null,
                'user_id' => $request->get('referedFrom')
           ]);
        }else{
            $origin = Origin::create([
                'customer_id' => $customer->id,
                'type' => $request->get('origin'),
                'channel' => $request->get('channel'),
                'user_id' => null
    
           ]);
        }

        $referal = User::find($request->get('referedFrom'));

        if(!$referal){
            $nameReferal = '-';
        }else{
            $nameReferal = $referal->name;
        }

        $comission = Comission::create([
            'customer_id' => $customer->id,
            'concept' => 'Marketing/referenciación',
            'percent' => 23,
            'referal' => $nameReferal,
            'user_id' => $request->get('user_id')
        ]);

        /* $comunication = Comunication::create([
            'customer_id' => $customer->id,
            'first_management' => $request->get('first_management'),
            'last_management' => $request->get('last_management'),
            'next_management' => $date,
            'comment' => $request->get('comment'),
            'product_tentative' => $request->get('product_tentative'),
            'type' => $request->get('type'),
            'time' => $hour
        ]);
 */
        return response()->json([
            'msg' => 'success'
        ]);
    }

    public function updateCustomer(Request $request){

        $customer = Customer::find($request->get('id'));

        $customer->update([
            'name' => $request->get('name'),
            'cell' => $request->get('cell'),
            'university' => $request->get('university'),
            'career' => $request->get('career'),
            'email' => $request->get('email')
        ]);

        return response()->json([
            'msg' => 'success'
        ]);
    }

    public function updateCustomerGrade(Request $request){
        $customer = Customer::find($request->get('customer_id'));
        $user = User::find($request->get('user_id'));

        $comissionData = [
            'customer_id' => $customer->id,
            'referal' => $user->name,
            'user_id' => $request->get('user_id')
        ];

        switch ($request->get('status')) {
            case 3:
                $comissionData['concept'] = 'Obtención de datos';
                $comissionData['percent'] = 2;
                break;
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

        $comission = Comission::where('customer_id', $request->get('customer_id'))->where('user_id', $request->get('user_id'))->where('concept', $comissionData['concept'])->first();

        if($request->get('status')>= 3 && $comission){
            $newComission = Comission::create($comissionData);
        }
        

        $customer->update([
            'status' => $request->get('status')
        ]);
        return response()->json([
            'msg' => 'success'
        ]);
    }

    public function standByCustomer($id){

        $customer = Customer::find($id);
        $customer->update([
            'status' => 0
        ]);

        return response()->json([
            'msg' => 'success'
        ]);
    }

    public function getAllStandByCustomers(){
        $customers = Customer::where('status', '=', null)->with(['project','project.product'])->get();
        return response()->json($customers);
    }

    public function reactivateCustomer($id){
        $customer = Customer::find($id);
        $customer->update([
            'status' => 1
        ]);
        return response()->json([
            'msg' => 'success'
        ]);
    }

    public function updateDniCustomer(Request $request){

        $customer = Customer::find($request->get('id_customer'));
        $customer->update([
            'dni' => $request->get('dni'),
            'address' => $request->get('address')
        ]);

        return response()->json($customer);
    }
    
    public function getAllPreleads(){
        $totalCustomers = collect();

        for($i = 1; $i <= 3; $i++){
            $customers = Customer::with(['project','project.product', 'comunications' => function($query){
                $query->orderBy('id', 'desc')->first();
            },'quotations', 'quotations.order','user'])->where('status', $i)->orderBy('updated_at', 'desc')->take(10)->get();
            
            $totalCustomers = $totalCustomers->merge($customers);
        }

        return response()->json($totalCustomers);
    }

    public function getAllLeads($id){

        $totalCustomers = collect();
        
        for($i = 4; $i <= 11; $i++){
            $customers = Customer::with(['origin','user','project','project.product', 'comunications' => function($query){
                $query->latest('id');
            },'quotations', 'quotations.order','quotations.contract'])->where('status', $i)->orderBy('updated_at', 'desc')->take(10)->get();
            
            $totalCustomers = $totalCustomers->merge($customers);
        }
        
        return response()->json($totalCustomers);
    }

    public function assignOwner(Request $request){
        $customer = Customer::find($request->get('customer_id'));
        $customer->update([
            'user_id' => $request->get('seller_selected'),
            'status' => 4,
            'needs' => $request->get('needs')
        ]);

        /* $quotation = Quotation::create([
            'customer_id' => $request->get('customer_id'),
            'date' => date('Y-m-d'),
            'amount' => 0,
            'term' => '-'
        ]); */

        /* $products = json_decode($request->get('products'), true);

        foreach ($products as $product){

            $newProduct = NewProduct::with('newprices')->find($product['id']);

            $levelSearched = $product['level'];

            $priceFounded = 0;

            foreach($newProduct->newprices as $price){
                if($price->level == $levelSearched){
                    $priceFounded = $price->price;
                }
            }
           
            $detail = Detail::create([
                'quotation_id' => $quotation->id,
                'product_id' => 1,
                'new_product_id' => $product['id'],
                'description' => '-',
                'type' => 1,
                'price' => $priceFounded,
                'level' => $product['level']
            ]);

        } */

        $user = User::find($request->get('user_id'));
        $nameReferal = $user->name;

        $comission = Comission::create([
            'customer_id' => $customer->id,
            'concept' => 'Obtención de necesidades específicas',
            'percent' => 8,
            'referal' => $nameReferal,
            'user_id' => $request->get('user_id')
        ]);


        return response()->json([
            'msg' => 'success'
        ]);
    }
    
    public function searchCustomers($search){
        $customers = Customer::with(['user','comunications' => function($query){
            $query->orderBy('id', 'desc')->first();
        },'quotations'])->where('name', 'like', '%'.$search.'%')->orWhere('cell','like','%'.$search.'%')->get();
        return response()->json($customers);
    }

    public function searchPreleads($search){
        $customers = Customer::with('comunications')->where(function ($query) use ($search) {
        $query->where('name', 'like', '%' . $search . '%')
            ->orWhere('cell', 'like', '%' . $search . '%');
    })->where('status', '<=', 3)->get();
        return response()->json($customers);
    }

    public function verifyCustomer(Request $request){

       $name = $request->get('name');
       $cell = $request->get('cell');

        if($name != null){
            $searchByName = Customer::where('name','like', '%'.$name.'%')->get();

            $cantResName = count($searchByName);

            if($cantResName == 0){
                $verifiedByName = true;
            }else{
                return response()->json([
                    'msg' => 'Se han encontrado coincidencias con este nombre',
                    'coincidences' => $searchByName
                ]);
            }
        }else{
            $verifiedByName = true;
        }

        
        if($cell != null){
            $searchByCell = Customer::where('cell','like', '%'.$cell.'%')->get();

            $cantResCell = count($searchByCell);

            if($cantResCell == 0){
                $verifiedByCell = true;
            }else{
                return response()->json([
                    'msg' => 'Se han encontrado coincidencias con este celular'
                ]);
            }
        }else{
            $verifiedByCell = true;
        }

        if($verifiedByCell && $verifiedByName){
            $verifiedTotal = true;
        }else{
            $verifiedTotal = false;
        }


        return response()->json($verifiedTotal);
    }

    public function getLeadsByDate($date){
        $customers = Customer::with(['comunications','quotations'])->whereHas('comunications', function ($query) use ($date) {
            $query->where('next_management', $date);
        })->get();
        return response()->json($customers);
    }

    public function getAllMyLeads($id){
        $today = date('Y-m-d');
        $customersToday = Customer::where('user_id', $id)->where('created_at', 'like', '%'.$today.'%')->get();

        $customers = Customer::where('user_id', $id)->orderBy('updated_at', 'desc')->get();


        return response()->json($customersToday);        
    }

}
