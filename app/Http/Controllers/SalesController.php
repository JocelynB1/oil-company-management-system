<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Purchase;
use App\Sale;
use Session;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('sales.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sales.create');
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
            'sales_date'=>'required',
            'customer_name'=>'required',
            'customer_number'=>'required',
            'litres_pumped'=>'required',
            'product_type'=>'required',
            'shortages'=>'required',
            'supplier_name'=>'required',
            'unit_price'=>'required',
            'payment_mode'=>'required',
            'transfer_bank'=>'required',
            'payment_status'=>'required',
            'discount_rate'=>'required',
            'cash_discount_allowed'=>'required',
            'amount_paid'=>'required',
            'balance'=>'required',
            'transaction_code'=>'required',
            'stage_reached'=>'required'
           ]);
        
        $request->total_cost=($request->litres_pumped*$request->unit_price)
        -($request->litres_pumped*$request->discount_rate)-
        $request->discount_rate-$request->cash_discount_allowed;
        $input=$request->all();
        
        Sale::create($input);
        Purchase::create($input);


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
        $sale = Sale::findOrFail($id);

        return view('sales.show')->with(['sale'=>$sale]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sale = Sale::findOrFail($id);

        return view('sales.edit')->with(['sale'=>$sale]);
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
        $model=Sale::findOrFail($id);
        $this->validate($request, [
            'sales_date'=>'required',
            'customer_name'=>'required',
            'customer_number'=>'required',
            'litres_pumped'=>'required',
            'product_type'=>'required',
            'shortages'=>'required',
            'supplier_name'=>'required',
            'unit_price'=>'required',
            'payment_mode'=>'required',
            'transfer_bank'=>'required',
            'payment_status'=>'required',
            'discount_rate'=>'required',
            'cash_discount_allowed'=>'required',
            'amount_paid'=>'required',
            'balance'=>'required',
            'transaction_code'=>'required',
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
        $sale = Sale::findOrFail($id);

        $sale->delete();
    
        Session::flash('flash_message', 'Record successfully deleted!');
    
        return redirect()->back();
    }
    public function search(Request $request)
    {
        //not done
        $q = $request->q;
        if ($q != "") {
            $user = Sale::where('transaction_description', 'LIKE', '%' . $q . '%')->paginate(5)->setPath('');
            $pagination = $user->appends(array(
                    'q' =>  $request->q
            ));
            if (count($user) > 0) {
                return view('sales.index')->withSale($user)->withQuery($q);
            }
        }
        Session::flash('flash_message', 'No records found!');
        return redirect()->route('sales.index')->withSale($user);
    }
}
