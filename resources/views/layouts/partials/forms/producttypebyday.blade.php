<?php

 $today = date("Y-m-d");

               $arr=[];
               
$products = \DB::table('products')
                ->select("product_type")
                ->get();
                
                foreach ($products as $key => $value) {
                  $salesRateProducts = \DB::table('sales_rates')
                  ->select('product_type','entry_date')
                  ->where('product_type','=',$value->product_type)
                  ->orderBy('entry_date','desc')              
                  ->first();
                  if($salesRateProducts==null){
                
                    $temp=[
                       'product_type'=> $value->product_type,
                       'entry_date'=>Carbon\Carbon::yesterday()
                  ]; 
                    $arr[]=(object)$temp;
                  }
          if($salesRateProducts!=null&&$salesRateProducts->entry_date!=$today){      
                 $arr[]=$salesRateProducts;
          }

}
                    $avaliableProducts=[''=>''];
                    foreach ($arr as $key => $value) {

                        if($value->entry_date!=$today){
                        $avaliableProducts[$value->product_type]=$value->product_type;
                        }
                    }
                    if(count($avaliableProducts)==1){
        Session::flash('flash_message', 'Selling rate has been set for all products');
                
                }

            
                
?>

<div class="form-group row">
{!!Form::label('product_type','Product Name:',['class'=>'col-md-4 col-form-label text-md-right']) !!}
<div class="col-md-6">
{!!Form::select('product_type', $avaliableProducts,null, ['class' => 'form-control'])!!}
</div>
</div>
