<?php

namespace App\Http\Controllers;
use App\User;
use App\UsersRole;
Use App\Role;
use Session;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

class CreateNewUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $createnewusers = User::paginate(25);
     
        if(!empty($createnewusers[0])){
            return view('createnewusers.index')->with(['createnewusers'=>$createnewusers]);
        }
        Session::flash('flash_message', 'No records found!');
            return view('createnewusers.index')->with(['createnewusers'=>$createnewusers]);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('createnewusers.create');
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',

        ]);
        
     $newUser= new User();
     $newUser->name=$request->name;
     $newUser->email=$request->email;
     $newUser->password=Hash::make($request->password);
     $newUser->save();
     $UsersRole=new UsersRole();
     $UsersRole->user_id=$newUser->id;
     $UsersRole->role_id=$request->Description;
     $UsersRole->save();
            
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
        $createnewusers = User::findOrFail($id);

        return view('createnewusers.show')->with(['createnewusers'=>$createnewusers]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $createnewusers = User::findOrFail($id);

        return view('createnewusers.edit')->with(['createnewusers'=>$createnewusers]);

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
        $newUser = User::findOrFail($id);
     
        $UsersRole = UsersRole::find($newUserid);
        
        $this->validate($request,[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',

        ]);
        
   
     $newUser->name=$request->name;
     $newUser->email=$request->email;
     $newUser->password=Hash::make($request->password);
     $newUser->update();
     $UsersRole->user_id=$newUser->id;;
     $UsersRole->role_id=$request->Description;
     $UsersRole->update();
            
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
        $newUser = User::findOrFail($id);
   
        $UsersRole = UsersRole::find($newUser->id);
    
      
        $newUser->delete();
        $UsersRole->delete();
    
        Session::flash('flash_message', 'Record successfully deleted!');
    
        return redirect()->route('createnewusers.index');

    }
    public function search(Request $request)
    {
 
        $q = $request->q;
        if($q != ""){
        $user = User::where ( 'name', 'LIKE', '%' . $q . '%' )->paginate (5)->setPath ( '' );
        $pagination = $user->appends ( array (
                    'q' =>  $request->q 
            ) );
        if (count ( $user ) > 0)
        return view('createnewusers.index')->with(['createnewusers'=>$user])->withQuery ( $q );
        }
        Session::flash('flash_message', 'No records found!');
        return redirect()->route('createnewusers.index')->with(['createnewusers'=>$user]);
       
    }
}
