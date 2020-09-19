<?php

namespace App\Http\Controllers;

use App\BankAccount;
use Illuminate\Http\Request;
use App\Transaction;

use Session;

class BankAccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bankaccounts = BankAccount::paginate(25);
        if (!empty($bankaccounts[0])) {
            return view('bankaccounts.index')->withBankAccounts($bankaccounts);
        }
        Session::flash('flash_message', 'No records found!');
        return view('bankaccounts.index')->withBankAccounts($bankaccounts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("bankaccounts.create");
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
            'bank_name'=>'required',
            'account_number'=>'required',
            'current_balance'=>'required',
            'current_balance'=>'numeric',
            'date_of_last_transaction'=>'required'
            
        ]);
        $input=$request->all();
        BankAccount::create($input);

        $ba= BankAccount::all()->pop()->id;
        $transaction= new Transaction();
        $transaction->trn_ref_no = "Bank Account"  . "-" . $ba;
        $transaction->transaction_date=$request->date_of_last_transaction;
        $transaction->account_number= $request->account_number;
        $transaction->amount_paid =$request->current_balance;
        $transaction->bank_name=$request->bank_name;
        $transaction->narration = "Current Balance Forward";
        $transaction->posted_from="AddNewBankAccount";
        $transaction->save();
      
        Session::flash('flash_message', 'Bank Account successfully added!');

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
        $bankaccounts = BankAccount::findOrFail($id);

        return view('bankaccounts.show')->with(['bankaccounts'=>$bankaccounts]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bankaccounts = BankAccount::findOrFail($id);

        return view('bankaccounts.edit')->with(['bankaccounts'=>$bankaccounts]);
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
        $bankaccount = BankAccount::findOrFail($id);

        $this->validate($request, [
        
        'bank_name'=>'required',
        'account_number'=>'required',
        'current_balance'=>'required',
        'current_balance'=>'numeric',
        'date_of_last_transaction'=>'required'
     
    ]);

        $input = $request->all();
        $trn_ref_no = "Bank Account" . "-" . $id;
        
        $transaction = \DB::table('transactions')
            ->where('trn_ref_no', '=', $trn_ref_no)
            ->get();

        $bankaccount->update($input);
        $transactionId = $transaction[0]->id;
        $transaction = Transaction::findOrFail($transactionId);
        $transaction->transaction_date=$request->date_of_last_transaction;
        $transaction->account_number= $request->account_number;
        $transaction->amount_paid = $request->current_balance;
        $transaction->bank_name=$request->bank_name;
        $transaction->update();
        Session::flash('flash_message', 'Bank Account successfully updated!');

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
        $bankaccount = BankAccount::findOrFail($id);

        $bankaccount->delete();
    
        Session::flash('flash_message', 'Bank Account successfully deleted!');
    
        return redirect()->back();
    }
    public function search(Request $request)
    {
        $q = $request->q;
        if ($q != "") {
            $user = BankAccount::where('bank_name', 'LIKE', '%' . $q . '%')->paginate(5)->setPath('');
            $pagination = $user->appends(array(
                    'q' =>  $request->q
            ));
            if (count($user) > 0) {
                return view('bankaccounts.index')->withBankAccounts($user)->withQuery($q);
            }
        }
        Session::flash('flash_message', 'No records found!');
        return redirect()->route('bankaccounts.index')->withBankAccounts($user);
    }
}
