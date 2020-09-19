<?php

namespace App\Http\Controllers;

use App\Purchase;
use App\Transaction;
use App\Inventory;
use Session;

use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $purchases = Purchase::paginate(25);
     
        if (!empty($purchases[0])) {
            return view('purchases.index')->with(['purchases'=>$purchases]);
        }
        Session::flash('flash_message', 'No records found!');
        return view('purchases.index')->with(['purchases'=>$purchases]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("purchases.create");
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
            'supplier_name' => 'required',
            'payment_status' => 'required',
            'net_loading_in_litres' => 'required',
            'total_cost' => 'required|numeric',
            'amount_paid' => 'required|numeric',
            'balance' => 'required|numeric',
            'transaction_code' => 'required',
            'transaction_date' => 'required'
        ]);
        $input=$request->all();
        $supplierName = Inventory::where("supplier_number", "=", $request->supplier_name)->get();
        $supplierName =$supplierName[0]->supplier_name;

        Purchase::create($input);
        $lastPur = Purchase::all()->last();

      
        $trans = \App\Transaction::all();
        
        $transaction= new Transaction();
        $transaction->trn_ref_no="SupplierPayment"."-". $lastPur->id;
        $transaction->transaction_date=$request->transaction_date;
        $transaction->product_type=$request->product_type;
        $transaction->liters=0;
        $transaction->total_cost=0;
        $transaction->amount_paid=$request->amount_paid;
        $transaction->balance=$request->balance;
        $transaction->narration="Payment to supplier";
        
        $transaction->transaction_code=$request->transaction_code;
        $transaction->customer_name = "";
        $transaction->payment_status=$request->payment_status;
        $transaction->shortages=$request->shortages_in_litres;
        $transaction->unit_price=$request->price_per_litre;
        $transaction->posted_from="SupplierPayment";
        

        $supplier = "";
        /*
            $supplier = \App\Supplier::where("supplier_number", $lastExp->payment_to)->get();
            if (isset($supplier[0]->supplier_name)) {
                $supplierName = $supplier[0]->supplier_name;
            } else {
                $supplierName = "";
            }
          */
        $transaction->supplier_name= $supplierName;
        // $transaction->unit_price=$request->unit_price;
        $transaction->payment_mode=$request->payment_mode;
        $transaction->bank_name=$request->bank_name;
        $transaction->cheque_number=$request->cheque_number;
        $transaction->payment_status=$request->payment_status;
        $transaction->account_number=$request->account_number;
        //$transaction->discount_rate=$request->discount_rate;
        //$transaction->cash_discount_allowed=$request->cash_discount_allowed;
        //$transaction->approval_status="";
        //$transaction->approval_date=null;
        $transaction->save();


        $transaction = new Transaction();
        $transaction->trn_ref_no = "SupplierPayment" . "-(" . $lastPur->id.")";
        $transaction->transaction_date = $request->transaction_date;
        $transaction->product_type = $request->product_type;
        $transaction->liters = 0;
        $transaction->total_cost = 0;
        $transaction->amount_paid = $request->total_shortage;
        $transaction->balance = 0;
        $transaction->narration = "shortage";
        $transaction->supplier_rate= $request->unit_price;
        $transaction->shortages = $request->shortages_in_litres;

        $transaction->transaction_code = $request->transaction_code;
        $transaction->customer_name = "";
        $transaction->payment_status = $request->payment_status;
        $transaction->shortages = $request->shortages_in_litres;
        $transaction->unit_price = $request->price_per_litre;
        $transaction->posted_from = "SupplierPayment";


        $supplier = "";
       
        $transaction->supplier_name = $supplierName;
        $transaction->payment_mode = $request->payment_mode;
        $transaction->bank_name = $request->bank_name;
        $transaction->cheque_number = $request->cheque_number;
        $transaction->payment_status = $request->payment_status;
        $transaction->account_number = $request->account_number;
        $transaction->save();
       
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
        $purchases = Purchase::findOrFail($id);

        return view('purchases.show')->with(['purchases'=>$purchases]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $purchases = Purchase::findOrFail($id);

        return view('purchases.edit')->with(['purchases'=>$purchases]);
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
        $purchases = Purchase::findOrFail($id);
        $this->validate($request, [
            'supplier_name' => 'required',
            'payment_status' => 'required',
            'net_loading_in_litres' => 'required',
            'total_cost' => 'required|numeric',
            'amount_paid' => 'required|numeric',
            'balance' => 'required|numeric',
            'payment_mode' => 'required',
            'transaction_code' => 'required',
            'transaction_date' => 'required'
        ]);
        $input=$request->all();
        
        $supplierName = Inventory::where("supplier_number", "=", $request->supplier_name_from_inventory)->get();

        $supplierName="";
        $transRefNo = "SupplierPayment-" . $id;
        $transaction = \App\Transaction::where('trn_ref_no', '=', $transRefNo)
            ->get();
        $trans= $transaction->toArray();
        $transaction = Transaction::findOrFail($trans[0]['id']);
        $transaction->delete();

        $transRefNo = "SupplierPayment-(" . $id.")";
        $transaction = \App\Transaction::where('trn_ref_no', '=', $transRefNo)
            ->get();
        $trans = $transaction->toArray();
        $transaction = Transaction::findOrFail($trans[0]['id']);
        $transaction->delete();


        $transaction = new Transaction();
        $transaction->trn_ref_no = "SupplierPayment" . "-" . $id;
        $transaction->transaction_date = $request->transaction_date;
        $transaction->product_type = $request->product_type;
        $transaction->liters = 0;
        $transaction->total_cost = 0;
        $transaction->amount_paid = $request->amount_paid;
        $transaction->balance = $request->balance;
        $transaction->narration = "Payment to supplier";

        $transaction->transaction_code = $request->transaction_code;
        $transaction->customer_name = "";
        $transaction->payment_status = $request->payment_status;
        $transaction->shortages = $request->shortages_in_litres;
        $transaction->unit_price = $request->price_per_litre;
        $transaction->posted_from = "SupplierPayment";
        $supplier = "";
        $transaction->supplier_name = $supplierName;
        $transaction->payment_mode = $request->payment_mode;
        $transaction->bank_name = $request->bank_name;
        $transaction->cheque_number = $request->cheque_number;
        $transaction->payment_status = $request->payment_status;
        $transaction->account_number = $request->account_number;
        $transaction->save();


        $transaction = new Transaction();
        $transaction->trn_ref_no = "SupplierPayment" . "-(" . $id . ")";
        $transaction->transaction_date = $request->transaction_date;
        $transaction->product_type = $request->product_type;
        $transaction->liters = 0;
        $transaction->total_cost = 0;
        $transaction->amount_paid = $request->total_shortage;
        $transaction->balance = 0;
        $transaction->narration = "shortage";
        $transaction->supplier_rate = $request->unit_price;
        $transaction->shortages = $request->shortages_in_litres;
        $transaction->transaction_code = $request->transaction_code;
        $transaction->customer_name = "";
        $transaction->payment_status = $request->payment_status;
        $transaction->shortages = $request->shortages_in_litres;
        $transaction->unit_price = $request->price_per_litre;
        $transaction->posted_from = "SupplierPayment";
        $supplier = "";
        $transaction->supplier_name = $supplierName;
        $transaction->payment_mode = $request->payment_mode;
        $transaction->bank_name = $request->bank_name;
        $transaction->cheque_number = $request->cheque_number;
        $transaction->payment_status = $request->payment_status;
        $transaction->account_number = $request->account_number;
        $transaction->save();


      
        $purchases->update($input);


        
        Session::flash('flash_message', 'Record successfully Updated!');

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
        $purchases = Purchase::findOrFail($id);

        $purchases->delete();
    
        Session::flash('flash_message', 'Record successfully deleted!');
    
        return redirect()->back();
    }
    public function search(Request $request)
    {
        $q = $request->q;
        if ($q != "") {
            $user = Purchase::where('supplier_name', 'LIKE', '%' . $q . '%')->paginate(5)->setPath('');
            $pagination = $user->appends(array(
                    'q' =>  $request->q
            ));
            if (count($user) > 0) {
                return view('purchases.index')->with(['purchases'=>$user])->withQuery($q);
            }
        }
        Session::flash('flash_message', 'No records found!');
        return redirect()->route('purchases.index')->with(['purchases'=>$user]);
    }
}
