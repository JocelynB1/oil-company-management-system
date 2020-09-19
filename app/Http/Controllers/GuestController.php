<?php

namespace App\Http\Controllers;

use App\Guest;

use Illuminate\Http\Request;
use Session;

class GuestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('guests.create');
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
            'guest_number'=>'required|unique:guests,guest_number',
            'guest_name'=>'required',
            'phone_number'=>'required',
            'created_by'=>'required',
            'modified_by'=>'required'
        ]);
        $input=$request->all();
        Guest::create($input);
        Session::flash('flash_message', 'Guest successfully added!');

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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $guest = Guest::findOrFail($id);

        return view('guests.edit')->with(['guest'=>$guest]);
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
        $guest = Guest::findOrFail($id);

        $this->validate($request, [
            'guest_number'=>'required|unique:guests,guest_number',
            'guest_name'=>'required',
            'phone_number'=>'required',
            'created_by'=>'required',
            'modified_by'=>'required'
        ]);
        $input = $request->all();
  
        $guest->update($input);
    
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
        $guest = Guest::findOrFail($id);
        $guest->delete();
    
        Session::flash('flash_message', 'Guest successfully deleted!');
    
        return redirect()->back();
    }
}
