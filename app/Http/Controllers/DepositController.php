<?php

namespace App\Http\Controllers;

use App\Deposit;
use App\Transaction;

use Session;

use Illuminate\Http\Request;

class DepositController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $deposits = Deposit::paginate(25);
     
        if (!empty($deposits[0])) {
            return view('deposits.index')->with(['deposits'=>$deposits]);
        }
        Session::flash('flash_message', 'No records found!');
        return view('deposits.index')->with(['deposits'=>$deposits]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('deposits.create');
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
        Deposit::create($input);

        $lastDep = Deposit::all()->last();

        $transaction= new Transaction();
        $transaction->trn_ref_no="Deposit"."-".$lastDep->id;
        $transaction->transaction_date=$request->transaction_date;
        $transaction->bank_name=$request->bank_name;
        $transaction->account_number=$request->account_number;
        $transaction->transaction_code=$request->transaction_code;
        $transaction->amount_paid=$request->amount;
        $transaction->narration=$request->narration;
        $transaction->posted_from="Deposit";
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
        $deposits = Deposit::findOrFail($id);

        return view('deposits.show')->with(['deposits'=>$deposits]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $deposits = Deposit::findOrFail($id);

        return view('deposits.edit')->with(['deposits'=>$deposits]);
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
        $deposit = Deposit::findOrFail($id);
        $this->validate($request, [
            'transaction_date'=>'required',
            'bank_name'=>'required',
            'account_number'=>'required',
            'transaction_code'=>'required',
            'amount'=>'required',
            'narration'=>'required',
            'created_by'=>'required'
        ]);
        $input=$request->all();
        $deposit->update($input);

        Session::flash('flash_message', 'Record successfully updated!');

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
        $deposits = Deposit::findOrFail($id);

        $deposits->delete();
    
        Session::flash('flash_message', 'Record successfully deleted!');
    
        return redirect()->route('deposits.index');
    }
    public function search(Request $request)
    {
        $q = $request->q;
        if ($q != "") {
            $user = Deposit::where('account_number', 'LIKE', '%' . $q . '%')->paginate(5)->setPath('');
            $pagination = $user->appends(array(
                    'q' =>  $request->q
            ));
            if (count($user) > 0) {
                return view('deposits.index')->with(['deposits'=>$user])->withQuery($q);
            }
        }
        Session::flash('flash_message', 'No records found!');
        return redirect()->route('deposits.index')->with(['deposits'=>$user]);
    }
}
