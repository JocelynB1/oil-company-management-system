<?php

namespace App\Http\Controllers;

use App\Purchase;
use App\Sale;
use App\TotalLitres;
use App\Inventory;
use App\Transaction;

use Session;

use Illuminate\Http\Request;
use Illuminate\Http\MessageBag;

class OutputManagerSalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $outputmanagersales = Sale::paginate(25);
        
        if (!empty($outputmanagersales[0])) {
            return view('outputmanagersales.index')->with(['outputmanagersales'=>$outputmanagersales]);
        }
        Session::flash('flash_message', 'No records found!');
        return view('outputmanagersales.index')->with(['outputmanagersales'=>$outputmanagersales]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('outputmanagersales.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'sales_date'=>'required',
            'customer_name'=>'required',
            'customer_number'=>'required',
            'litres_pumped'=>'required|numeric',
            'product_type'=>'required',
            'shortages'=>'required|numeric',
            'supplier_name'=>'required',
            'unit_price'=>'required|numeric',
            'stage_reached'=>'required'
           ]);
        $input=$request->all();
     
        Sale::create($input);
        $supplierId =$request->supplier_name_from_inventory;
        $productType=$request->product_type;
       
        $trans = \App\Transaction::all();
        $lastTrans = $trans->pop();
        if (!isset($lastTrans)) {
            $lastTransId=0;
        } else {
            $lastTransId=$lastTrans->id;
        }
        $s= Sale::all()->pop()->id;
        $transaction= new Transaction();
        $transaction->trn_ref_no = "Sales"  . "-" . $s;
        $transaction->transaction_date=$request->sales_date;
        $transaction->product_type=$request->product_type;
        $transaction->liters=$request->litres_pumped;
        $transaction->account_number=$supplierId;
        $transaction->total_cost=$request->litres_loaded*$request->unit_price;
        $transaction->amount_paid=0;
        $transaction->balance=$request->litres_loaded*$request->unit_price;
        $transaction->narration="";
        $transaction->transaction_code="DOB";
        $transaction->customer_name=$request->customer_name;
        $transaction->shortages=0;
        $transaction->supplier_name=$request->supplier_name;
        $transaction->unit_price=$request->unit_price;
        $transaction->payment_mode="";
        $transaction->bank_name="";
        $transaction->cheque_number="";
        $transaction->payment_status="";
        $transaction->discount_rate=0;
        $transaction->cash_discount_allowed=0;
        $transaction->approval_status="";
        $transaction->approval_date=null;
        $transaction->save();

        $inventory=\App\Inventory::where('supplier_number', '=', $supplierId)
          ->where('product_type', '=', $productType)
          ->orderBy('created_at', 'desc')
          ->get()
          ->pop();

        $newInventory=new Inventory();
        $newInventory->supplier_name=$inventory->supplier_name;
        $newInventory->supplier_number=$inventory->supplier_number;
        $newInventory->truck_number="N\A";
        $newInventory->driver_name="N\A";
        $newInventory->driver_phone="N\A";
        $newInventory->product_type=$inventory->product_type;
        $newInventory->litres_loaded=-($request->litres_pumped);
        $newInventory->save();
        $result = \App\TotalLitres::where('supplier_id', '=', $supplierId)
          ->where('product_type', '=', $productType)
          ->get();
        if (empty($result[0])) {
            $totalLitres=new TotalLitres();
            $totalLitres->supplier_id=$supplierId;
            $totalLitres->product_type=$productType;
            $totalLitres->total_litres=$request->litres_pumped;
            $totalLitres->save();
        } else {
            $totalLitres=$result[0];
            $totalLitres->total_litres-=$request->litres_pumped;
            $totalLitres->save();
        }
          
        Session::flash('flash_message', 'Record successfully added!');
   
        return redirect()->back();
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
        $outputmanagersales = Sale::findOrFail($id);

        return view('outputmanagersales.edit')->with(['outputmanagersales'=>$outputmanagersales]);
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
        $Sale = Sale::findOrFail($id);
        $this->validate($request, [
            'sales_date'=>'required',
            'customer_name'=>'required',
            'customer_number'=>'required',
            'litres_pumped'=>'required|numeric',
            'product_type'=>'required',
            'shortages'=>'required|numeric',
            'supplier_name'=>'required',
            'unit_price'=>'required|numeric',
            'stage_reached'=>'required'
           ]);
        $input=$request->all();
        $Sale->update($input);

        Session::flash('flash_message', 'Record successfully added!');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sale = Sale::findOrFail($id);

        $sale->delete();
    
        Session::flash('flash_message', 'Record successfully deleted!');
    
        return redirect()->route('outputmanagersales.index');
    }
    public function search(Request $request)
    {
        $q = $request->q;
        if ($q != "") {
            $user = Sale::where('customer_name', 'LIKE', '%' . $q . '%')->paginate(5)->setPath('');
            $pagination = $user->appends(array(
                    'q' =>  $request->q
            ));
            if (count($user) > 0) {
                return view('outputmanagersales.index')->withSale($user)->withQuery($q);
            }
        }
        Session::flash('flash_message', 'No records found!');
        return redirect()->route('outputmanagersales.index')->withSale($user);
    }
}
