<?php

namespace App\Http\Controllers;

use App\Repayment;

use Session;
use Carbon\Carbon;

use Illuminate\Http\Request;

class CurrentCashBalanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('currentcashbalances.create');
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
            'current_balance' => 'required|numeric',
        ]);
        $trans = Repayment::all();
        $lastTrans = $trans->pop();
        if (!isset($lastTrans)) {
            $lastTransId = 0;
        } else {
            $lastTransId = $lastTrans->id;
        }




        

        $transaction = new Repayment();
        $transaction->transaction_reference_number = "CCB" . "-" . Carbon::Now();
        $transaction->transaction_date = Carbon::today() ;
        $transaction->client_name = "Current Cash Balance";
        $transaction->client_account_number =0;
        $transaction->outstanding_balance=0;
        $transaction->repayment_amount = 0;
        $transaction->current_balance = $request->current_balance;
        $transaction->created_by = $request->created_by;
        $transaction->transaction_description = "Current Cash Balance";
        $transaction->transaction_codes = "CCB";
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
