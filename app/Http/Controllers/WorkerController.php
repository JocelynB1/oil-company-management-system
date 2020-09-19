<?php

namespace App\Http\Controllers;

use App\Worker;

use Illuminate\Http\Request;
use Session;

class WorkerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('employees.create');
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
            'employee_name' => 'required',
            'phone_number'=>'required',
            'created_by'=>'required',
            'modified_by'=>'required'
        ]);
        $input=$request->all();
        
        Worker::create($input);
        Session::flash('flash_message', 'Worker successfully added!');

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
        $employee = Worker::findOrFail($id);

        return view('employees.edit')->with(['employee'=>$employee]);
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
        $employee = Worker::findOrFail($id);
        $this->validate($request, [
            'employee_name'=>'required',
            'phone_number'=>'required',
            'created_by'=>'required',
            'modified_by'=>'required'
        ]);
        $input = $request->all();
  
        $employee->update($input);
    
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
        $employee = Worker::findOrFail($id);
        $employee->delete();
    
        Session::flash('flash_message', 'Worker successfully deleted!');
    
        return redirect()->back();
    }
}
