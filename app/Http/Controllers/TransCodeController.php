<?php

namespace App\Http\Controllers;
use App\TransCode;
use Session;

use Illuminate\Http\Request;

class TransCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transcodes = TransCode::paginate(25);
        
        if(!empty($transcodes[0])){
            return view('transcodes.index')->with(['transcodes'=>$transcodes]);
        }
        Session::flash('flash_message', 'No records found!');
            return view('transcodes.index')->with(['transcodes'=>$transcodes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('transcodes.create');
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
            'transaction_code'=>'required',
            'transaction_code'=>'unique:transaction_codes,transaction_code',
            'transaction_description'=>'required',
            'created_by'=>'required'
        ]);
        $input=$request->all();
        TransCode::create($input);

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
        $transcodes = TransCode::findOrFail($id);

        return view('transcodes.show')->with(['transcodes'=>$transcodes]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $transcodes = TransCode::findOrFail($id);

        return view('transcodes.edit')->with(['transcodes'=>$transcodes]);
  
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
        $model = TransCode::findOrFail($id);
     
        $this->validate($request,[
            'transaction_code'=>'required',
            'transaction_code'=>'unique:transaction_codes,transaction_code',
            'transaction_description'=>'required',
            'created_by'=>'required'
        ]);
        $input=$request->all();
        $model->update($input);

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
        $transcodes = TransCode::findOrFail($id);

        $transcodes->delete();
    
        Session::flash('flash_message', 'Record successfully deleted!');
    
        return redirect()->route('transcodes.index');
  
    }
    public function search(Request $request)
    {
 
        $q = $request->q;
        if($q != ""){
        $user = TransCode::where ( 'transaction_description', 'LIKE', '%' . $q . '%' )->paginate (5)->setPath ( '' );
        $pagination = $user->appends ( array (
                    'q' =>  $request->q 
            ) );
        if (count ( $user ) > 0)
        return view('transcodes.index')->with(['transcodes'=>$user])->withQuery ( $q );
        }
        Session::flash('flash_message', 'No records found!');
        return redirect()->route('transcodes.index')->with(['transcodes'=>$user]);
       
    }
}
