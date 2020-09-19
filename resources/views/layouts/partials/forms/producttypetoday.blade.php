<?php

 $today = date("Y-m-d");

               $arr=[];
               
$products = \DB::table('products')
                ->select("product_type")
                ->get();
             
                $salesRateProducts = \DB::table('sales_rates')
                  ->select('product_type','entry_date')
                  ->where('entry_date','=',Carbon\Carbon::today())
                  ->orderBy('entry_date','desc')              
                  ->get();
               
              
                    $avaliableProducts=[''=>''];
                    foreach ($salesRateProducts as $key => $value) {
                        $avaliableProducts[$value->product_type]=$value->product_type;
                    }
                    if(count($avaliableProducts)==1){
        Session::flash('flash_message', 'Todays selling rate has not been set for any products');
                
                }

            
                
?>

<div class="form-group row">
{!!Form::label('product_type','Product Name:',['class'=>'col-md-4 col-form-label text-md-right']) !!}
<div class="col-md-6">
{!!Form::select('product_type', $avaliableProducts,null, ['class' => 'form-control'])!!}
</div>
</div>
