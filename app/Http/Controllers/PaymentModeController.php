<?php

namespace App\Http\Controllers;

use App\PaymentMode;
use Illuminate\Http\Request;
use Session;
class PaymentModeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
   

        $paymentMode = PaymentMode::paginate(25);
        
        if(!empty($paymentMode[0])){
            return view('paymentMode.index')->withPaymentMode($paymentMode);
        }
        Session::flash('flash_message', 'No records found!');
            return view('paymentMode.index')->withPaymentMode($paymentMode);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('paymentMode.create');
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
            'payment_mode'=>'required',
            'payment_mode'=>'unique:payment_modes,payment_mode',
            'created_by'=>'required',
            'modified_by'=>'required'
        ]);
        $input=$request->all();
        PaymentMode::create($input);

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
        
        $paymentMode = PaymentMode::findOrFail($id);

        return view('paymentMode.show')->with(['paymentMode'=>$paymentMode]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $paymentMode = PaymentMode::findOrFail($id);

        return view('paymentMode.edit')->with(['paymentMode'=>$paymentMode]);

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
        $model = PaymentMode::findOrFail($id);
        $this->validate($request,[
            'payment_mode'=>'required',
            'payment_mode'=>'unique:payment_modes,payment_mode',
            'created_by'=>'required',
            'modified_by'=>'required'
        ]);
        $input=$request->all();
        $model->update($input);

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
        $paymentMode = PaymentMode::findOrFail($id);

        $paymentMode->delete();
    
        Session::flash('flash_message', 'Record successfully deleted!');
    
        return redirect()->back();
    }

    public function search(Request $request)
    {
 
        $q = $request->q;
        if($q != ""){
        $user = PaymentMode::where ( 'payment_mode', 'LIKE', '%' . $q . '%' )->paginate (5)->setPath ( '' );
        $pagination = $user->appends ( array (
                    'q' =>  $request->q 
            ) );
        if (count ( $user ) > 0)
        return view('paymentMode.index')->withPaymentMode($user)->withQuery ( $q );
        }
        Session::flash('flash_message', 'No records found!');
        return redirect()->route('paymentMode.index')->withPaymentMode($user);
       
    }
}
