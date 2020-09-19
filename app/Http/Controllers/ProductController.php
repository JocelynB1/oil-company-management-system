<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Session;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $products;
    protected $requests;

    public function __construct(Product $products,Request $requests)
    {
        $this->products=$products;
        $this->requests=$requests;

    }

    public function index()
    {
         $product = Product::paginate(25);
        
        if(!empty($product[0])){
            return view('product.index')->withProduct($product);
        }
        Session::flash('flash_message', 'No records found!');
            return view('product.index')->withProduct($product);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('product.create');
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
            'product_type'=>'required',
            'product_type'=>'unique:products,product_type',
            'created_by'=>'required',
            'modified_by'=>'required'
        ]);
        $input=$request->all();
        Product::create($input);

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
         
        $product = Product::findOrFail($id);

        return view('product.show')->with(['product'=>$product]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);

        return view('product.edit')->with(['product'=>$product]);

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
        $model = Product::findOrFail($id);
        
        $this->validate($request,[
            'product_type'=>'required',
            'product_type'=>'unique:products,product_type',
            'created_by'=>'required',
            'modified_by'=>'required'
        ]);
        $input=$request->all();
        $model->update($input);

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
        $product = Product::findOrFail($id);

        $product->delete();
    
        Session::flash('flash_message', 'Record successfully deleted!');
    
        return redirect()->back();
    }

    public function search(Request $request)
    {
 
        $q = $request->q;
        if($q != ""){
        $user = Product::where ( 'product_type', 'LIKE', '%' . $q . '%' )->paginate (5)->setPath ( '' );
        $pagination = $user->appends ( array (
                    'q' =>  $request->q 
            ) );
        if (count ( $user ) > 0)
        return view('product.index')->withProduct($user)->withQuery ( $q );
        }
        Session::flash('flash_message', 'No records found!');
        return redirect()->route('product.index')->withProduct($user);
       
    }
}
