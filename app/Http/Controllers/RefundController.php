<?php

namespace App\Http\Controllers;

use App\Refund;
use App\Transaction;


use Session;

use Illuminate\Http\Request;

class RefundController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $refunds = Refund::paginate(25);
     
        if (!empty($refunds[0])) {
            return view('refunds.index')->with(['refunds'=>$refunds]);
        }
        Session::flash('flash_message', 'No records found!');
        return view('refunds.index')->with(['refunds'=>$refunds]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('refunds.create');
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
            'transaction_date'=>'required',
            'customer_name'=>'required',
            'account_number'=>'required',
            'refund_amount'=>'required|numeric',
            'payment_mode'=>'required',
            'created_by'=>'required',
            'transaction_code'=>'required',
            'approval_status'=>'required'
            
        ]);
        $input=$request->all();
        Refund::create($input);
          

        $trans = \App\Transaction::all();
        $lastTrans = $trans->pop();
        if (!isset($lastTrans)) {
            $lastTransId=0;
        } else {
            $lastTransId=$lastTrans->id;
        }
        $lastRef = Refund::all()->last();

       
        $transaction= new Transaction();
        $transaction->trn_ref_no="Refund"."-". $lastRef->id;
        $transaction->transaction_date=$request->transaction_date;
        $transaction->bank_name=$request->bank_name;
        $transaction->account_number=$request->account_number;
        $transaction->transaction_code=$request->transaction_code;
        $transaction->amount_paid=$request->refund_amount;
        $transaction->payment_mode=$request->payment_mode;
        $transaction->narration = "Refund to ".$request->customer_name.":".$request->account_number." " . $request->narration;
        $transaction->customer_name =$request->customer_name;
        $transaction->posted_from="Refunds";
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
        $refunds = Refund::findOrFail($id);

        return view('refunds.show')->with(['refunds'=>$refunds]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $refunds = Refund::findOrFail($id);

        return view('refunds.edit')->with(['refunds'=>$refunds]);
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
        $Refund = Refund::findOrFail($id);
        $this->validate($request, [
            'transaction_date'=>'required',
            'customer_name'=>'required',
            'account_number'=>'required',
            'refund_amount'=>'required|numeric',
            'payment_mode'=>'required',
            'created_by'=>'required',
            'transaction_code'=>'required',
            'approval_status'=>'required'
        ]);
        $input=$request->all();
        $Refund->update($input);

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
        $refunds = Refund::findOrFail($id);

        $refunds->delete();
    
        Session::flash('flash_message', 'Record successfully deleted!');
    
        return redirect()->back();
    }
    public function search(Request $request)
    {
        $q = $request->q;
        if ($q != "") {
            $user = Refund::where('customer_name', 'LIKE', '%' . $q . '%')->paginate(5)->setPath('');
            $pagination = $user->appends(array(
                    'q' =>  $request->q
            ));
            if (count($user) > 0) {
                return view('refunds.index')->with(['refunds'=>$user])->withQuery($q);
            }
        }
        Session::flash('flash_message', 'No records found!');
        return redirect()->route('refunds.index')->with(['refunds'=>$user]);
    }
}
