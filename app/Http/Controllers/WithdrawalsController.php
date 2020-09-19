<?php

namespace App\Http\Controllers;

use App\Withdrawal;
use App\Transaction;

use Session;

use Illuminate\Http\Request;

class WithdrawalsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $withdrawals = Withdrawal::paginate(25);
     
        if (!empty($withdrawals[0])) {
            return view('withdrawals.index')->with(['withdrawals'=>$withdrawals]);
        }
        Session::flash('flash_message', 'No records found!');
        return view('withdrawals.index')->with(['withdrawals'=>$withdrawals]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('withdrawals.create');
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
            'bank_name'=>'required',
            'account_number'=>'required',
            'transaction_code'=>'required',
            'amount'=>'required|numeric',
            'narration'=>'required',
            'created_by'=>'required'
        ]);
        $input=$request->all();
        Withdrawal::create($input);

        $trans = \App\Transaction::all();
        $lastTrans = $trans->pop();
        if (!isset($lastTrans)) {
            $lastTransId=0;
        } else {
            $lastTransId=$lastTrans->id;
        }

        $lastWit = Withdrawal::all()->last();
       
        $transaction= new Transaction();
        $transaction->trn_ref_no="Withdrawal"."-". $lastWit->id;
        $transaction->transaction_date=$request->transaction_date;
        $transaction->bank_name=$request->bank_name;
        $transaction->account_number=$request->account_number;
        $transaction->transaction_code=$request->transaction_code;
        $transaction->amount_paid=$request->amount;
        $transaction->narration=$request->narration;
        $transaction->posted_from="Withdrawal";
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
        $withdrawals = Withdrawal::findOrFail($id);

        return view('withdrawals.show')->with(['withdrawals'=>$withdrawals]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $withdrawals = Withdrawal::findOrFail($id);

        return view('withdrawals.edit')->with(['withdrawals'=>$withdrawals]);
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
        $model =Withdrawal::findOrFail($id);
        $this->validate($request, [
            'transaction_date'=>'required',
            'bank_name'=>'required',
            'account_number'=>'required',
            'transaction_code'=>'required',
            'amount'=>'required|numeric',
            'narration'=>'required',
            'created_by'=>'required'
     
        ]);
        $input=$request->all();
        $model->update($input);

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
        $withdrawals = Withdrawal::findOrFail($id);

        $withdrawals->delete();
    
        Session::flash('flash_message', 'Record successfully deleted!');
    
        
        return redirect()->route('withdrawals.index');
    }
    public function search(Request $request)
    {
        $q = $request->q;
        if ($q != "") {
            $user = Withdrawal::where('account_number', 'LIKE', '%' . $q . '%')->paginate(5)->setPath('');
            $pagination = $user->appends(array(
                    'q' =>  $request->q
            ));
            if (count($user) > 0) {
                return view('withdrawals.index')->with(['withdrawals'=>$user])->withQuery($q);
            }
        }
        Session::flash('flash_message', 'No records found!');
        return redirect()->route('withdrawals.index')->with(['withdrawals'=>$user]);
    }
}
