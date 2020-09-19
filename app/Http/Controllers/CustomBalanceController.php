<?php

namespace App\Http\Controllers;

use App\Transaction;
use App\Customer;
use App\Supplier;
use App\Worker;

use Session;
use Illuminate\Http\Request;

class CustomBalanceController extends Controller
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
        return view('custombalances.create');
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
            'transaction_type' => 'required',
            'created_by' => 'required',
            'payment_to' => 'required'
            
        ]);
        $trans = Transaction::all();
        $lastTrans = $trans->pop();
        if (!isset($lastTrans)) {
            $lastTransId = 0;
        } else {
            $lastTransId = $lastTrans->id+1;
        }
     
        $transaction = new Transaction();
        $transaction->trn_ref_no = "Bal" . "-"  .$lastTransId;
        $transaction->transaction_date = $request->transaction_date;

        if ($request->transaction_type == "Debt Opening Balance") {
            $transaction->total_cost = $request->amount;
        }
        if ($request->transaction_type == "Payment Advance") {
            $transaction->amount_paid = $request->amount;
        }

        $transaction->narration = $request->transaction_type;
        $customer=Customer::where("customer_number", $request->payment_to)->get();
        if (isset($customer[0]->customer_name)) {
            $customerName=$customer[0]->customer_name;
        } else {
            $customerName="";
        }
        $transaction->customer_name = $customerName;

        $transaction->posted_from="CustomBalance";
        
        $supplier="";
        $supplier=Supplier::where("supplier_number", $request->payment_to)->get();
        if (isset($supplier[0]->supplier_name)) {
            $name=$supplier[0]->supplier_name;
        } else {
            $name="";
            $worker = "";
            $worker = Worker::where("employee_name", $request->payment_to)->get();
            if (isset($worker[0]->employee_name)) {
                $name = $worker[0]->employee_name;
            } else {
                $name = "";
            }
        }
        $transaction->supplier_name = $name;
        $transaction->account_number= $request->payment_to;
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
