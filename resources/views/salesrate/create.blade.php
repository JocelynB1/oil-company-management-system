<?php
                $today = Carbon\Carbon::today();
                            $arr=[];
                $products = \DB::table('products')
                                ->select("product_type")
                                ->get();
                
                foreach ($products as $key => $value) {
                 
                  $salesRateProducts = \DB::table('sales_rates')
                  ->select('product_type','selling_rate')
                  ->where('product_type','=',$value->product_type)
                  ->where('entry_date', '=', $today)
                  ->orderBy('entry_date','desc')
                  ->first();
                if($salesRateProducts!=null){      
                    $arr[]=$salesRateProducts;
                }

}


                if(empty($arr)){
                    $avaliableProducts = [];

                }
                else{
                    $avaliableProducts=[''=>''];
                    foreach ($arr as $key => $value) {
                        $avaliableProducts[$value->product_type]=$value->selling_rate;
                    }
            
                }
?>

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
       
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Add Sales Rate</div>

                <div class="card-body">
                @include('layouts.partials.alerts')
{!! Form::open([
'route'=>'salesrate.store'
])!!}  
@csrf

@include('layouts.partials.forms.entrydate')
@include('layouts.partials.forms.producttypebyday')
                   @include('layouts.partials.forms.sellingrate')
                            @include('layouts.partials.forms.modifiedby')
                   @include('layouts.partials.forms.entryby')

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                            {!! Form::submit('Add New Sales Rate',['class'=>'btn btn-primary']) !!}

                            </div>
                        </div>
                        {!! Form::close() !!}
                </div>
            </div>
        </div>
          <div class="col-md-2">
          Rates for {{date("jS F Y")}}
                <table class="table table-striped table-borded">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Sales Rate</th>
                            </tr>
                            <tbody>
                                    @foreach($avaliableProducts as $key => $value)
                                <tr>
                                    
                                    <td>{{$key}}</td>
                                    <td>{{$value}}</td>
                                </tr>
                                @endforeach    
                            </tbody>
                        </thead>
                        </table>
      
    </div>
</div>
@endsection
