<?php

namespace App\Http\Controllers;

use Session;

use App\Transaction;
use App\CustomerPayment;
use Illuminate\Http\Request;

class CustomerPaymentController extends Controller
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
        return view("customerpayments.create");
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
            'customer_name' => 'required',
            'account_number' => 'required',
            'amount_paid' => 'required',
            'payment_mode' => 'required',
            'total_cost' => 'required',
            'balance' => 'required',
            'created_by' => 'required'
            
        ]);
        $input=$request->all();
        CustomerPayment::create($input);
        $c = CustomerPayment::all()->pop()->id;

        $transaction = new Transaction();
        $transaction->trn_ref_no = "CustomerPayment" . "-" . $c;
        $transaction->transaction_date = $request->transaction_date;
        $transaction->account_number = $request->account_number ;
        $transaction->product_type = $request->product_type;
        $transaction->liters=0;
        $transaction->total_cost=0;
        $transaction->amount_paid=$request->amount_paid;
        $transaction->balance=$request->balance;
        $transaction->narration="Customer Payment";
        $transaction->transaction_code=$request->transaction_code;
        $transaction->shortages = $request->shortages_in_litres;
        $transaction->unit_price = $request->unit_price;
        $transaction->customer_name = $request->customer_name;
        $transaction->payment_mode=$request->payment_mode;
        $transaction->bank_name=$request->bank_name;
        $transaction->cheque_number=$request->cheque_number;
        $transaction->payment_status=$request->payment_status;
        $transaction->posted_from = "CustomerPayment";

        $transaction->save();
        //total_shortage
        $transaction = new Transaction();
        $transaction->trn_ref_no = "CustomerPayment" . "-(" . $c.")";
        $transaction->transaction_date = $request->transaction_date;
        $transaction->account_number = $request->account_number ;
        $transaction->product_type = $request->product_type;
        $transaction->liters=$request->shortages_in_litres;
        $transaction->total_cost=0;
        $transaction->balance=0;
        $transaction->narration="shortage";
        $transaction->transaction_code=$request->transaction_code;
        $transaction->shortages = $request->shortages_in_litres;
        $transaction->unit_price = $request->total_shortage;
        $transaction->customer_name = $request->customer_name;
        $transaction->payment_mode=$request->payment_mode;
        $transaction->bank_name=$request->bank_name;
        $transaction->cheque_number=$request->cheque_number;
        $transaction->payment_status=$request->payment_status;
        $transaction->posted_from = "CustomerPayment";
        $transaction->save();

        Session::flash('flash_message', 'Customer Payment added successfully added!');

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
