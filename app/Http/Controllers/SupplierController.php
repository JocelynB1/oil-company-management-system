<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Supplier;
use Session;

class SupplierController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $supplier = Supplier::all();

        return view('suppliers.index')->withSupplier($supplier);
 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
     return view('suppliers.create');
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
            'supplier_number'=>'required',
            'supplier_name'=>'required',
            'company_name'=>'required',
            'phone_number'=>'required',
            'created_by'=>'required',
            'modified_by'=>'required',
        ]);
        $input=$request->all();
        Supplier::create($input);

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
        $supplier = Supplier::findOrFail($id);

        return view('suppliers.show')->with(['supplier'=>$supplier]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);

        return view('suppliers.edit')->with(['supplier'=>$supplier]);

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
        $model = Supplier::findOrFail($id);
        $this->validate($request,[
            'supplier_number'=>'required',
            'supplier_name'=>'required',
            'company_name'=>'required',
            'phone_number'=>'required',
            'created_by'=>'required',
            'modified_by'=>'required',
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
        $supplier = Supplier::findOrFail($id);

        $supplier->delete();
    
        Session::flash('flash_message', 'Record successfully deleted!');
    
        return redirect()->back();
    }
    public function search(Request $request)
    {
 
        $q = $request->q;
        if($q != ""){
        $user = Supplier::where ( 'supplier_name', 'LIKE', '%' . $q . '%' )->paginate (5)->setPath ( '' );
        $pagination = $user->appends ( array (
                    'q' =>  $request->q 
            ) );
        if (count ( $user ) > 0)
        return view('suppliers.index')->withSupplier($supplier)->withQuery ( $q );
        }
        Session::flash('flash_message', 'No records found!');
        return redirect()->route('suppliers.index')->withSupplier($supplier);
       
    }
}
