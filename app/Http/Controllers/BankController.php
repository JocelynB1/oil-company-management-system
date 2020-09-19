<?php

namespace App\Http\Controllers;
use App\Bank;
use Session;

use Illuminate\Http\Request;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banks = Bank::paginate(25);
        
        if(!empty($banks[0])){
            return view('banks.index')->withBanks($banks);
        }
        Session::flash('flash_message', 'No records found!');
            return view('banks.index')->withBanks($banks);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
     return view('banks.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      
        $this->validate($request,[
            'bank_name'=>'required',
            'bank_name'=>'unique:banks,bank_name',
            'created_by'=>'required'
        ]);
        $input=$request->all();
        Bank::create($input);

        Session::flash('flash_message', 'Bank successfully added!');

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
        $bank = Bank::findOrFail($id);

        return view('banks.show')->withBank($bank);  
      }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $banks = Bank::findOrFail($id);

        return view('banks.edit')->with(['banks'=>$banks]);


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
        $bank = Bank::findOrFail($id);

        $this->validate($request,[
            'bank_name'=>'required',
            'created_by'=>'required'
        ]);
    
        $input = $request->all();
    
        $bank->update($input);
    
        Session::flash('flash_message', 'Bank successfully added!');
    
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
        $bank = Bank::findOrFail($id);

        $bank->delete();
    
        Session::flash('flash_message', 'Bank successfully deleted!');
    
        return redirect()->back();
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
 
        $q = $request->q;
        if($q != ""){
        $user = Bank::where ( 'bank_name', 'LIKE', '%' . $q . '%' )->paginate (5)->setPath ( '' );
        $pagination = $user->appends ( array (
                    'q' =>  $request->q 
            ) );
        if (count ( $user ) > 0)
        return view('banks.index')->withBanks($user)->withQuery ( $q );
        }
        Session::flash('flash_message', 'No records found!');
        return redirect()->route('banks.index')->withBanks($user);
       
    }
    public function table(BankDataTable $dataTable)
    {
        return $dataTable->render('banks.table');
    }
}
