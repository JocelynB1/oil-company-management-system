<?php

namespace App\Http\Controllers;

use App\Sale;
use App\Transaction;
use App\Inventory;
use App\TotalLitres;


use Session;

use Illuminate\Http\Request;

class AccountantSalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accountantsales=Sale::where('stage_reached', '=', 'waiting_for_accountant')->paginate(25);

        if (!empty($accountantsales[0])) {
            return view('accountantsales.index')->with(['accountantsales'=>$accountantsales]);
        }
        Session::flash('flash_message', 'No records found!  Waiting for the Output Manager to start sales.');
        return view('accountantsales.index')->with(['accountantsales'=>$accountantsales]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('accountantsales.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $accountantsales = Sale::findOrFail($id);

        return view('accountantsales.edit')->with(['accountantsales'=>$accountantsales]);
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
            'litres_pumped'=>'required',
            'product_type'=>'required',
            'shortages'=>'required',
            'unit_price'=>'required|numeric',
            'supplier_name'=>'required',
            'stage_reached'=>'required',
            'payment_mode'=>'required',
            'description'=>'required',
            'discount_rate'=>'required',
            'cash_discount_allowed'=>'required',
            'amount_paid'=>'required',
            'balance'=>'required',
            'transaction_code'=>'required'
           ]);
        $request->total_cost=$request->litres_pumped*$request->unit_price
           -($request->discount_rate*$request->litres_pumped)-$request->cash_discount_allowed;
        $request->stage_reached="complete";
        $input=$request->all();
        $trn_ref_no = "Sales" . "-" . $Sale->id;

        $transaction = \DB::table('transactions')
            ->where('trn_ref_no', '=', $trn_ref_no)
            ->get();
        $transactionId = $transaction[0]->id;
        $transaction = Transaction::findOrFail($transactionId);
        $transaction->transaction_date=$request->sales_date;
        $transaction->product_type=$request->product_type;
        $transaction->liters=$request->litres_pumped;
        $transaction->account_number= $request->customer_number;
        $transaction->total_cost=$request->total_cost;
        $transaction->amount_paid=$request->amount_paid;
        $transaction->balance=$request->balance;
        $transaction->narration = "Customer Payment";
        $transaction->transaction_code=$request->transaction_code;
        $transaction->customer_name=$request->customer_name;
        $transaction->shortages=$request->shortages;
        $transaction->supplier_name=$request->supplier_name;
        $transaction->unit_price=$request->unit_price;
        $transaction->payment_mode=$request->payment_mode;
        $transaction->bank_name=$request->bank_name;
        $transaction->payment_status= $request->payment_status;
        $transaction->discount_rate=$request->discount_rate;
        $transaction->cash_discount_allowed=$request->cash_discount_allowed;
        $transaction->approval_status="";
        $transaction->approval_date=null;

        $transaction->posted_from="AcceptPayment";

        $Sale->update($input);
        $transaction->update();
      
        Session::('flash_message', 'Record successfully updated!');

        return redirect()->route('displayrecords.accountantsales');
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

    
        $transactions = \DB::table('transactions')
                  ->where('transaction_date', '=', $sale->sales_date)
                  ->where('product_type', '=', $sale->product_type)
                  ->where('liters', '=', $sale->litres_pumped)
                  ->where('total_cost', '=', $sale->litres_loaded*$sale->unit_price)
                  ->where('amount_paid', '=', 0)
                  ->where('balance', '=', $sale->litres_loaded*$sale->unit_price)
                  ->where('narration', '=', "")
                  ->where('transaction_code', '=', "DOB")
                  ->where('customer_name', '=', $sale->customer_name)
                  ->where('shortages', '=', $sale->shortages)
                  ->where('unit_price', '=', $sale->unit_price)
                  ->where('bank_name', '=', "")
                  ->where('cheque_number', '=', "")
                  ->where('payment_status', '=', "")
                  ->where('discount_rate', '=', 0)
                  ->where('cash_discount_allowed', '=', 0)
                  ->where('approval_status', '=', "")
                  ->where('approval_date', '=', null)
                  ->orderby('created_at', 'asc')
                  ->get();

        
                  
        $supplierId=$transactions[0]->account_number;
        $productType=$transactions[0]->product_type;


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
        $newInventory->litres_loaded=($sale->litres_pumped);
        $newInventory->save();


        $result = \App\TotalLitres::where('supplier_id', '=', $supplierId)
          ->where('product_type', '=', $productType)
          ->get();
        $totalLitres=$result[0];
        $totalLitres->total_litres+=$sale->litres_pumped;
        $totalLitres->save();
        
        $transactions = Transaction::findOrFail($transactions[0]->id);
      
        $transactions->delete();
        $sale->delete();




        Session::flash('flash_message', 'Record successfully deleted!');

        return redirect()->route('displayrecords.accountantsales');
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
                return view('accountantsales.index')->withSale($user)->withQuery($q);
            }
        }
        Session::flash('flash_message', 'No records found!');
        return redirect()->route('accountantsales.index')->withSale($user);
    }
}
