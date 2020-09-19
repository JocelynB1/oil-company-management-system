<?php

namespace App\Http\Controllers;

use App\SalesRate;
use App\SalesRatesHistory;
use Session;

use Illuminate\Http\Request;

class SalesRateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $salesrate = SalesRate::paginate(25);
        if (!empty($salesrate[0])) {
            return view('salesrate.index')->with(['salesrate'=>$salesrate]);
        }
        Session::flash('flash_message', 'No records found!');
        return view('salesrate.index')->with(['salesrate'=>$salesrate]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('salesrate.create');
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
            'selling_rate'=>'required|numeric',
            'product_type'=>'required',
            'created_by'=>'required',
            'modified_by'=>'required'
        ]);
        $input=$request->all();
        SalesRate::create($input);
        SalesRatesHistory::create(SalesRate::all()->last()->toArray());

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
        $salesrate = SalesRate::findOrFail($id);

        return view('salesrate.show')->with(['salesrate'=>$salesrate]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $salesrate = SalesRate::findOrFail($id);

        return view('salesrate.edit')->with(['salesrate'=>$salesrate]);
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
        $SalesRate = SalesRate::findOrFail($id);
        $this->validate($request, [
            'selling_rate'=>'required|numeric',
            'product_type'=>'required',
            'created_by'=>'required',
            'modified_by'=>'required'
        ]);
     
        $input=$request->all();
        $SalesRate->update($input);
        SalesRatesHistory::create($SalesRate->toArray());

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
        $salesrate = SalesRate::findOrFail($id);

        $salesrate->delete();
    
        Session::flash('flash_message', 'Record successfully deleted!');
    
        return redirect()->route('salesrate.index');
    }
    public function search(Request $request)
    {
        $q = $request->q;
        if ($q != "") {
            $user = SalesRate::where('product_type', 'LIKE', '%' . $q . '%')->paginate(5)->setPath('');
            $pagination = $user->appends(array(
                    'q' =>  $request->q
            ));
            if (count($user) > 0) {
                return view('salesrate.index')->with(['salesrate'=>$user])->withQuery($q);
            }
        }
        Session::flash('flash_message', 'No records found!');
        return redirect()->route('salesrate.index')->with(['salesrate'=>$user]);
    }
}
