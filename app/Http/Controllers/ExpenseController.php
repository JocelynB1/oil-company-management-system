<?php

namespace App\Http\Controllers;
use App\Expense;
use Session;

use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expenses = Expense::paginate(25);
     
        if(!empty($expenses[0])){
            return view('expenses.index')->with(['expenses'=>$expenses]);
        }
        Session::flash('flash_message', 'No records found!');
            return view('expenses.index')->with(['expenses'=>$expenses]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('expenses.create');
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
            'expense_category'=>'required|unique:expenses,expense_category',
            'created_by'=>'required'
          ]);
        $input=$request->all();
        Expense::create($input);

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
        $expenses = Expense::findOrFail($id);

        return view('expenses.show')->with(['expenses'=>$expenses]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $expenses = Expense::findOrFail($id);

        return view('expenses.edit')->with(['expenses'=>$expenses]);
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
            $model = Expense::findOrFail($id);
            $this->validate($request,[
                'expense_category'=>'required|:expenses,expense_category'
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
        $expenses = Expense::findOrFail($id);

        $expenses->delete();
    
        Session::flash('flash_message', 'Record successfully deleted!');
    
        return redirect()->route('expenses.index');

    }
    public function search(Request $request)
    {
 
        $q = $request->q;
        if($q != ""){
        $user = Expense::where ( 'expense_category', 'LIKE', '%' . $q . '%' )->paginate (5)->setPath ( '' );
        $pagination = $user->appends ( array (
                    'q' =>  $request->q 
            ) );
        if (count ( $user ) > 0)
        return view('expenses.index')->with(['expenses'=>$user])->withQuery ( $q );
        }
        Session::flash('flash_message', 'No records found!');
        return redirect()->route('expenses.index')->with(['expenses'=>$user]);
       
    }
}
