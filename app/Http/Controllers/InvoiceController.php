<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Http\Request;
use App\Transaction;
use App\Customer;
use App\Supplier;
use App\Worker;
use App\Inventory;

class InvoiceController extends Controller
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
        return view("invoices.create");
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
            'invoice_number' => 'required',
            'amount' => 'required|numeric',
            'narration' => 'required',
            'created_by' => 'required',
            'payment_to' => 'required'
        ]);

        $transaction = new Transaction();
        $lastTrans = \App\Transaction::all()->pop();
        if (!empty($lastTrans)) {
            $lastId = $lastTrans->id;
        } else {
            $lastId = 0;
        }
        
        $transaction->trn_ref_no = "Invoice" . "-" . $request->payment_to . "-" . ($lastId + 1);
        $transaction->transaction_date = $request->transaction_date;
        $transaction->product_type = "Invoice Generated";
        $transaction->liters = 0;
        $transaction->balance = $request->amount;
        $transaction->rate = null;
        $transaction->total_cost = $request->amount;
        $transaction->narration = $request->narration;
        $transaction->account_number = $request->payment_to;
        $transaction->transaction_code = "INV";
        $transaction->cheque_number=$request->invoice_number;
        $customer = Customer::where("customer_number", $request->payment_to)->get();
        if (isset($customer[0]->customer_name)) {
            $customerName = $customer[0]->customer_name;
        } else {
            $customerName = "";
        }
        $transaction->customer_name = $customerName;


        $transaction->shortages = 0;

        $supplier = "";
        $supplier = Supplier::where("supplier_number", $request->payment_to)->get();
        if (isset($supplier[0]->supplier_name)) {
            $supplierName = $supplier[0]->supplier_name;
        } else {
            $supplierName = "";
        }
        
        $transaction->supplier_name = $supplierName;
        /*
                if ($customerName == ""&&$supplierName=="") {
                    $customerName =    $request->payment_to;
                    $transaction->customer_name = $customerName;
                    $workerId = Worker::where("employee_name", $request->payment_to)->get();
                    $transaction->trn_ref_no = "Invoice" . "-" ."W"."-".$workerId[0]->id. "-" . ($lastId + 1);
                } else {
                    $customerName = "";
                }

                */
        $transaction->unit_price = 0;
        $transaction->posted_from = "InvoicesStart";

        $inv = Inventory::where("supplier_number", $request->payment_to)->get();
       
        if (!isset($inv[0]->supplier_number)) {
            $inventory=new Inventory;
            $inventory->transaction_date;
            $inventory->supplier_name=$supplierName;
            $inventory->supplier_number= $request->payment_to;
            $inventory->product_type="AGO";
            $inventory->litres_loaded=0;
            $inventory->created_by="Administrator";
            $inventory->supplier_rate=0;
            $inventory->total_cost= $request->amount;
            $inventory->modified_by="Administrator";
            $inventory->save();
        }
      
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
        $transaction = Transaction::findOrFail($id);

        return view('invoices.edit')->with(['transaction' => $transaction]);
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
        $oldtransaction = Transaction::findOrFail($id);
        $this->validate($request, [
            'transaction_date' => 'required',
            'invoice_number' => 'required',
            'amount' => 'required|numeric',
            'narration' => 'required',
            'created_by' => 'required',
            "payment_mode"=>"required",
            'payment_to' => 'required'
        ]);
        $oldtransaction->posted_from="InvoicesEnd";
        $oldtransaction->update();
        //  $input = $request->all();
        $lastTrans = \App\Transaction::all()->pop();
        if (!empty($lastTrans)) {
            $lastId = $lastTrans->id;
        } else {
            $lastId = 0;
        }

        $transaction = new Transaction();
        $transaction->trn_ref_no = "Invoice" . "-" . $request->payment_to . "-" . ($lastId + 1);
        $transaction->transaction_date = $request->transaction_date;
        $transaction->product_type = "Invoice Paid";
        $transaction->liters = 0;
        $transaction->amount_paid = $request->amount;
        $transaction->balance = $oldtransaction->total_cost-$request->amount;
        $transaction->rate = null;
        $transaction->total_cost = $oldtransaction->total_cost;
        $transaction->narration = $request->narration;
        $transaction->payment_mode = $request->payment_mode;
        $transaction->account_number = $request->payment_to;
        $transaction->transaction_code = "INV";
        $transaction->cheque_number=$request->invoice_number;
        $transaction->bank_name=$request->bank_name;
        $transaction->posted_from="InvoicesEnd";
        $supplier = Supplier::where("supplier_number", $request->payment_to)->get();
        if (isset($supplier[0]->supplier_name)) {
            $supplierName = $supplier[0]->supplier_name;
        } else {
            $supplierName = "";
        }
        
        $transaction->supplier_name = $supplierName;

        $transaction->save();
      
        Session::flash('flash_message', 'Record successfully processed!');

        return redirect()->route('displayrecords.invoices');
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
