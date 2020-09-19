<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use Session;

class CustomerController extends Controller
{
  
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customer = Customer::all();

        if(!empty($customer[0])){
            return view('customers.index')->withCustomers($customer);
    }
    Session::flash('flash_message', 'No records found!');
    return view('customers.index')->withCustomers($customer);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customers.create');
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
            'customer_number'=>'required|unique:customers,customer_number',
            'customer_name'=>'required',
            'company_name'=>'required',
            'phone_number'=>'required',
            'created_by'=>'required',
            'modified_by'=>'required'
        ]);
        $input=$request->all();
        Customer::create($input);
       Session::flash('flash_message', 'Customer successfully added!');

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
        $customer = Customer::findOrFail($id);

        return view('customers.show')->with(['customer'=>$customer]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = Customer::findOrFail($id);

        return view('customers.edit')->with(['customer'=>$customer]);

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
        $customer = Customer::findOrFail($id);

        $this->validate($request, [
            'customer_number'=>'required',
            'customer_name'=>'required',
            'company_name'=>'required',
            'phone_number'=>'required',
            'created_by'=>'required',
            'modified_by'=>'required'
           ]);
    
        $input = $request->all();
    
        $customer->update($input);
    
        Session::flash('flash_message', 'Record Updated!');
    
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
        $customer = Customer::findOrFail($id);

        $customer->delete();
    
        Session::flash('flash_message', 'Customer successfully deleted!');
    
        return redirect()->back();

    }
    public function search(Request $request)
    {
 
        $q = $request->q;
        if($q != ""){
        $user = Customer::where ( 'customer_name', 'LIKE', '%' . $q . '%' )->paginate (5)->setPath ( '' );
        $pagination = $user->appends ( array (
                    'q' =>  $request->q 
            ) );
        if (count ( $user ) > 0)
        return view('customers.index')->withCustomers($user)->withQuery ( $q );
        }
        Session::flash('flash_message', 'No records found!');
        return redirect()->route('customers.index')->withCustomers($user);
       
    }
}
