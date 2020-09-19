<?php

namespace App\Http\Controllers;
use App\Status;
use Session;


use Illuminate\Http\Request;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $status = Status::paginate(25);
     
        if(!empty($status[0])){
            return view('status.index')->with(['status'=>$status]);
        }
        Session::flash('flash_message', 'No records found!');
            return view('status.index')->with(['status'=>$status]);
   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('status.create');
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
            'description'=>'required',
            'created_by'=>'required'
        ]);
        $input=$request->all();
        Status::create($input);

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
    
        $status = Status::findOrFail($id);

        return view('status.show')->with(['status'=>$status]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $status = Status::findOrFail($id);

        return view('status.edit')->with(['status'=>$status]);

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
        $model = Status::findOrFail($id);
        
        $this->validate($request,[
            'description'=>'required',
            'created_by'=>'required'
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
        $status = Status::findOrFail($id);

        $status->delete();
    
        Session::flash('flash_message', 'Record successfully deleted!');
    
        return redirect()->route('status.index');

    }

    public function search(Request $request)
    {
 
        $q = $request->q;
        if($q != ""){
        $user = Status::where ( 'description', 'LIKE', '%' . $q . '%' )->paginate (5)->setPath ( '' );
        $pagination = $user->appends ( array (
                    'q' =>  $request->q 
            ) );
        if (count ( $user ) > 0)
        return view('status.index')->with(['status'=>$user])->withQuery ( $q );
        }
        Session::flash('flash_message', 'No records found!');
        return redirect()->route('status.index')->with(['status'=>$user]);
       
    }
}
