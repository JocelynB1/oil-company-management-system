
               @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Add sales</div>

                <div class="card-body">
                @include('layouts.partials.alerts')
{!! Form::open([
'route'=>'sales.store'
])!!}  
@csrf


               @include('layouts.partials.forms.salesdate')
               @include('layouts.partials.forms.customername')
               @include('layouts.partials.forms.customeraccount')
               @include('layouts.partials.forms.litrespumped')
               @include('layouts.partials.forms.producttype')  
               @include('layouts.partials.forms.shortages')   
               @include('layouts.partials.forms.suppliernameop')    
               @include('layouts.partials.forms.unitprices')  
               @include('layouts.partials.forms.paymentmodeop')  
               @include('layouts.partials.forms.paymentstatus')  
               @include('layouts.partials.forms.discountrate')  
               @include('layouts.partials.forms.cashdiscountallowed')  
               @include('layouts.partials.forms.amountpaid') 
               @include('layouts.partials.forms.balance')  
               @include('layouts.partials.forms.transcodeop')  
               @include('layouts.partials.forms.transferbank')  
            
     <script>

         var link = document.getElementById("amount_paid");
link.addEventListener("click", function(event) {
console.log("Nope.");
event.preventDefault();
alert();
});
         var CashDiscountAllowed=document.getElementById('cash_discount_allowed');
         CashDiscountAllowed.addEventListener("change", function() {
alert();
});


        
     </script>          
               
                
     


       <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                               
                            {!! Form::submit('Add Sales',['class'=>'btn btn-primary']) !!}


                            </div>
                        </div>
                        {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
