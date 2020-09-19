@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Update Sale</div>

                <div class="card-body">
                @include('layouts.partials.alerts')
{!! Form::model($outputmanagersales,[
  'method' => 'PATCH',
    'route' => ['outputmanagersales.update', $outputmanagersales->id]
])!!}     
                        @csrf
                  
                        @include('layouts.partials.forms.salesdate')
                        @include('layouts.partials.forms.customernameop')
                        @include('layouts.partials.forms.customeraccountdisabled')
                        @include('layouts.partials.forms.litrespumped')
                        @include('layouts.partials.forms.producttype')  
                        @include('layouts.partials.forms.shortages')   
                        @include('layouts.partials.forms.suppliernameop')    
                        @include('layouts.partials.forms.unitprices')  
                        @include('layouts.partials.forms.stagereachedoutputmanager')  
            
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                            {!! Form::submit('Update Sale',['class'=>'btn btn-primary']) !!}

                            </div>
                        </div>
                        {!! Form::close() !!}
                        <?php

                        $a=<<<JS
                        <script>
                            
        window.onload = function () {
    var cusnum=0;
            var salesrates= $salesrates;
       var customers=$customers;
       if(document.querySelector("#bank_name_div")){
        var bankname=document.querySelector("#bank_name_div");
       bankname.style.visibility="hidden";
       }
       var customername = document.querySelector('#customer_name');
    var customeracc = document.querySelector('#customer_number');
    var producttype = document.querySelector("#product_type");
    var unitprice = document.querySelector("#unit_price");
    if(document.querySelector("#payment_mode")){

    var paymentmode=document.querySelector("#payment_mode");
    
    paymentmode.addEventListener('change', function (e) {
        
        if(paymentmode.value=="Transfer"||paymentmode.value=="Bank"){
            bankname.style.hidden="visible";
        }
        else
        {
            bankname.style.hidden="hidden";
            bankname.value="NULL";
        }

       
        if (e.target != e.currentTarget) {
            e.preventDefault();
        }
        e.stopPropagation();
    }, false);
    

    }
    
    customername.addEventListener('change', function (e) {
    
        customeracc.value = customername.value;
        for(let i=0;i<customers.length;i++){
           if(customers[i].customer_name==customername.value){
            customeracc.value=customers[i].customer_number;
  cusnum=customers[i].customer_name;
        }
        if (e.target != e.currentTarget) {
            e.preventDefault();
        }
        e.stopPropagation();
    }, false);
    customeracc.addEventListener('change', function (e) {

        customeracc.value = cusnum;
        if (e.target != e.currentTarget) {
            e.preventDefault();
        }
        e.stopPropagation();
    }
    , false);
    producttype.addEventListener('change', function (e) {
var result="Sales rate not set";
        for(let i=0;i<salesrates.length;i++){
            console.log(salesrates[i].product_type);
            console.log(producttype.value);
            console.log(salesrates[i].product_type==producttype.value);
    if(salesrates[i].product_type==producttype.value){
    result=salesrates[i].selling_rate;
    }
}
        unitprice.value = result;
        if (e.target != e.currentTarget) {
            e.preventDefault();
        }
        e.stopPropagation();
    }, false);
    }

 
                        </script>
JS;
                        echo $a;
                            ?>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
