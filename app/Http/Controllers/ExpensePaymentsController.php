<?php

namespace App\Http\Controllers;

use App\ExpensePayment;
use App\Transaction;
use App\Customer;
use App\Supplier;
use App\Worker;

use Session;
use Illuminate\Http\Request;

class ExpensePaymentsController extends Controller
{

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expensepayments = ExpensePayment::paginate(25);

        if (!empty($expensepayments[0])) {
            return view('expensepayments.index')->with(['expensepayments' => $expensepayments]);
        }
        Session::flash('flash_message', 'No records found!');
        return view('expensepayments.index')->with(['expensepayments' => $expensepayments]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('expensepayments.create');
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
            'expense_category' => 'required',
            'amount' => 'required|numeric',
            'created_by' => 'required',
            'payment_to' => 'required',
            'payment_mode' => 'required'
        ]);
        $input = $request->all();
        ExpensePayment::create($input);

        $lastExp = ExpensePayment::all()->last();
        

        $trans = Transaction::all();
        $lastTrans = $trans->pop();
        if (!isset($lastTrans)) {
            $lastTransId = 0;
        } else {
            $lastTransId = $lastTrans->id;
        }
     
        $transaction = new Transaction();
        $transaction->trn_ref_no = "ExpensePayment" . "-"  .$lastExp->id;
        $transaction->transaction_date = $lastExp->transaction_date;
        $transaction->product_type = null;
        $transaction->expense_category=$request->expense_category;
        $transaction->invoice_number = $request->invoice_number;
        $transaction->cheque_number = $request->cheque_number;
        $transaction->liters = 0;
        $transaction->rate = null;
        $transaction->total_cost = null;
        $transaction->amount_paid = $lastExp->amount;
        $transaction->balance = null;
        $transaction->narration = "Expenses Payment";
        $transaction->transaction_code = $lastExp->transaction_code;
        $customer=Customer::where("customer_number", $lastExp->payment_to)->get();
        if (isset($customer[0]->customer_name)) {
            $customerName=$customer[0]->customer_name;
        } else {
            $customerName="";
        }
        $transaction->customer_name = $customerName;

        $transaction->posted_from="OtherExpensePayment";
        $transaction->shortages = 0;
        
        $supplier="";
        $supplier=Supplier::where("supplier_number", $lastExp->payment_to)->get();
        if (isset($supplier[0]->supplier_name)) {
            $name=$supplier[0]->supplier_name;
        } else {
            $name="";
            $worker = "";
            $worker = Worker::where("employee_name", $lastExp->payment_to)->get();
            if (isset($worker[0]->employee_name)) {
                $name = $worker[0]->employee_name;
            } else {
                $name = "";
            }
        }
     
        
        $transaction->supplier_name = $name;
        
        
        $transaction->unit_price = 0;
        $transaction->payment_mode = $lastExp->payment_mode;
        $transaction->bank_name = $lastExp->bank_name;
        $transaction->cheque_number =$lastExp->cheque_number;
        $transaction->payment_status = "";
        $transaction->discount_rate = 0;
        $transaction->cash_discount_allowed = 0;
        $transaction->approval_status = "";
        $transaction->approval_date = null;
        $transaction->account_number= $lastExp->payment_to;
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
        $expensepayments = ExpensePayment::findOrFail($id);

        return view('expensepayments.show')->with(['expensepayments' => $expensepayments]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $expensepayments = ExpensePayment::findOrFail($id);

        return view('expensepayments.edit')->with(['expensepayments' => $expensepayments]);
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
        $model = ExpensePayment::findOrFail($id);
        $this->validate($request, [
            'transaction_date' => 'required',
            'expense_category' => 'required',
            'amount' => 'required|numeric',
            'created_by' => 'required',
            'payment_to' => 'required',
            'payment_mode' => 'required'
        ]);
        $input = $request->all();
        $model->update($input);

        $trn_ref_no = "ExpensePayment" . "-" . $id;

        $transaction = \DB::table('transactions')
            ->where('trn_ref_no', '=', $trn_ref_no)
            ->get();

        $trans = Transaction::all();
        $lastTrans = $trans->pop();
        if (!isset($lastTrans)) {
            $lastTransId = 0;
        } else {
            $lastTransId = $lastTrans->id;
        }

        $transactionId = $transaction[0]->id;
        $transaction = Transaction::findOrFail($transactionId);
        $transaction->transaction_date = $model->transaction_date;
        $transaction->product_type = null;
        $transaction->expense_category = $request->expense_category;
        $transaction->invoice_number = $request->invoice_number;
        $transaction->cheque_number = $request->cheque_number;
        $transaction->liters = 0;
        $transaction->rate = null;
        $transaction->total_cost = null;
        $transaction->amount_paid = $model->amount;
        $transaction->balance = null;
        $transaction->narration = $model->narration;
        $transaction->transaction_code = $model->transaction_code;
        $customer = Customer::where("customer_number", $model->payment_to)->get();
        if (isset($customer[0]->customer_name)) {
            $customerName = $customer[0]->customer_name;
        } else {
            $customerName = "";
        }
        $transaction->customer_name = $customerName;


        $transaction->shortages = 0;

        $supplier = "";
        $supplier = Supplier::where("supplier_number", $model->payment_to)->get();
        if (isset($supplier[0]->supplier_name)) {
            $name = $supplier[0]->supplier_name;
        } else {
            $worker = "";
            $worker = Worker::where("employee_name", $model->payment_to)->get();
            if (isset($worker[0]->employee_name)) {
                $name = $worker[0]->employee_name;
            } else {
                $name = "";
            }
        }

        $transaction->supplier_name = $name;

        //  $transaction->supplier_name = $workerName;
       
        $transaction->unit_price = 0;
        $transaction->payment_mode = $model->payment_mode;
        $transaction->bank_name = $model->bank_name;
        $transaction->cheque_number = $model->cheque_number;
        $transaction->payment_status = "";
        $transaction->discount_rate = 0;
        $transaction->cash_discount_allowed = 0;
        $transaction->approval_status = "";
        $transaction->approval_date = null;
        $transaction->account_number = $model->payment_to;

        $transaction->posted_from="OtherExpensePayment";
        $transaction->save();
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
        $expensepayments = ExpensePayment::findOrFail($id);

        $expensepayments->delete();
        $trn_ref_no = "ExpensePayment" . "-" . $id;

        $transaction = \DB::table('transactions')
            ->where('trn_ref_no', '=', $trn_ref_no)
            ->get();
        $transactionId = $transaction[0]->id;
        $transaction = Transaction::findOrFail($transactionId);
        $transaction->delete();
        Session::flash('flash_message', 'Record successfully deleted!');

        return redirect()->route('expensepayments.index');
    }

    public function search(Request $request)
    {
        $q = $request->q;
        if ($q != "") {
            $user = ExpensePayment::where('invoice_number', 'LIKE', '%' . $q . '%')->paginate(5)->setPath('');
            $pagination = $user->appends(array(
                'q' => $request->q
                    ));
            if (count($user) > 0) {
                return view('expensepayments.index')->with(['expensepayments' => $user])->withQuery($q);
            }
        }
        Session::flash('flash_message', 'No records found!');
        return redirect()->route('expensepayments.index')->with(['expensepayments' => $user]);
    }
}
