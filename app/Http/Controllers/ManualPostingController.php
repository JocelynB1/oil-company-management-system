<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Http\Request;
use App\Transaction;
use App\Customer;
use App\Supplier;

class ManualPostingController extends Controller
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
        return view("manualposting.create");
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
            'transaction_date' => 'required',
            'transaction_code' => 'required',
            'account_number' => 'required',
            'amount' => 'required|numeric',
            'narration' => 'required',
            'created_by' => 'required',
            'payment_to' => 'required'
           ]);
       
        $transaction = new Transaction();
        $lastTrans = \App\Transaction::all()->pop();
        if (!empty($lastTrans)) {
            $lastId= $lastTrans->id;
        } else {
            $lastId=0;
        }
        if ($request->transaction_code=="DOB") {
            $transaction->balance=$request->amount;
            $transaction->amount_paid=0;
        } else {
            $transaction->amount_paid=$request->amount;
            $transaction->balance=0;
        }
        
        $transaction->trn_ref_no = "MPost" . "-" .$request->payment_to  . "-" .($lastId +1);
        $transaction->transaction_date = $request->transaction_date;
        $transaction->product_type = null;
        $transaction->liters = 0;
        $transaction->rate = null;
        $transaction->total_cost = null;
        $transaction->narration = $request->narration;
        $transaction->account_number=$request->account_number;
        $transaction->transaction_code = $request->transaction_code;
        $customer=Customer::where("customer_number", $request->payment_to)->get();
        if (isset($customer[0]->customer_name)) {
            $customerName=   $customer[0]->customer_name;
        } else {
            $customerName="";
        }
        $transaction->customer_name = $customerName;
                
        
        $transaction->shortages = 0;
        
        $supplier="";
        $supplier=Supplier::where("supplier_number", $request->payment_to)->get();
        if (isset($supplier[0]->supplier_name)) {
            $supplierName=$supplier[0]->supplier_name;
        } else {
            $supplierName="";
        }
       
        $transaction->supplier_name = $supplierName;
        
        
        $transaction->unit_price = 0;
        $transaction->payment_mode = "N/A";
        //$transaction->approved_by

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
        //
    }
}
