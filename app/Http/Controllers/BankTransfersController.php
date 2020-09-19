<?php

namespace App\Http\Controllers;

use App\Transaction;

use Session;

use Illuminate\Http\Request;

class BankTransfersController extends Controller
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
        return view("banktransfers.create");
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
            'amount' => 'required|numeric',
            'transfer_from' => 'required',
            'transfer_to' => 'required',
            'destination_account_number' => 'required',
            'originating_account_number'=>'required',
            'created_by' => 'required'
            
            
        ]);
        $input = $request->all();
        $trans = Transaction::all();
        $lastTrans = $trans->pop();
        if (!isset($lastTrans)) {
            $lastTransId = 0;
        } else {
            $lastTransId = $lastTrans->id+1;
        }
     
        $transaction = new Transaction();
        $transaction->trn_ref_no = "BankTransfer" . "-"  ."(".$lastTransId.")";
        $transaction->transaction_date = $request->transaction_date;
        $transaction->bank_name = $request->transfer_from;
        $transaction->amount_paid =- $request->amount;
        $transaction->narration ="Funds Transfered to:\t".$request->transfer_to." : ".$request->destination_account_number;
        $transaction->account_number= $request->originating_account_number;
        $transaction->posted_from="BankTransfer";
        $transaction->save();

        $transaction = new Transaction();
        $transaction->trn_ref_no = "BankTransfer" . "-"  .$lastTransId;
        $transaction->transaction_date = $request->transaction_date;
        $transaction->bank_name = $request->transfer_to;
        $transaction->amount_paid = $request->amount;
        $transaction->narration = $request->transaction_type;
        $transaction->narration ="Funds Transfered From:\t".$request->transfer_from." : ".$request->originating_account_number;
        $transaction->account_number= $request->destination_account_number;
        $transaction->posted_from="BankTransfer";
        $transaction->save();

        
        Session::flash('flash_message', 'Successfully Transfered!');

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
