@extends('layouts.app')
<?php
$js=<<<JS
window.onload=function(){
document.querySelector("#total_cost").value=getTotalCost();
      if (document.querySelector("#total_cost_display")) {
        document.querySelector("#total_cost_display").value = document.querySelector("#total_cost").value;
        document.querySelector("#total_cost_display").disabled = true;
    }

    document.querySelector("#hid").style.display="none";
    if (document.querySelector("#supplier_name_and_number")) {

var supplier = document.querySelector("#supplier_name_and_number");
supplier.addEventListener('change', function (e) {
    supplierName=supplier.options[supplier.selectedIndex].text;
    document.querySelector("#supplier_number").value=supplier.value;
    document.querySelector("#supplier_name").value=supplierName;

    if (e.target != e.currentTarget) {
        e.preventDefault();
    }
    e.stopPropagation();
}, false);
}
if (document.querySelector("#supplier_rate")) {

var supplierRate = document.querySelector("#supplier_rate");
supplierRate.addEventListener('change', function (e) {

    var totalCost = document.querySelector("#total_cost");
    totalCost.value = getTotalCost();
    document.querySelector("#total_cost_display").value = totalCost.value;
    if (e.target != e.currentTarget) {
        e.preventDefault();
    }
    e.stopPropagation();
}, false);
}
   if (document.querySelector("#litres_loaded")) {

var litresloaded = document.querySelector("#litres_loaded");
litresloaded.addEventListener('change', function (e) {

    var totalCost = document.querySelector("#total_cost");
    totalCost.value = getTotalCost();
    document.querySelector("#total_cost_display").value = totalCost.value;
    if (e.target != e.currentTarget) {
        e.preventDefault();
    }
    e.stopPropagation();
}, false);
}

function getTotalCost(){
     var litresloaded = document.querySelector("#litres_loaded").value;
    var supplierRate = document.querySelector("#supplier_rate").value;
    return (litresloaded * supplierRate);
   
}
}
JS;
?>
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Add Inventory</div>

                <div class="card-body">
                @include('layouts.partials.alerts')
{!! Form::open([
'route'=>'inventory.store'
])!!}     
                        @csrf
   
                   @include('layouts.partials.forms.suppliernameop')
                <div>
                {!! Form::label('split','Split :',['class'=>
'col-md-6 col-form-label text-md-right']) !!}
{!! Form::checkbox('split',"linked",false) !!}
</div>
                   @include('layouts.partials.forms.trucknumber')
                   @include('layouts.partials.forms.drivername')
                   @include('layouts.partials.forms.driverphone')
                   @include('layouts.partials.forms.producttype')
                   @include('layouts.partials.forms.litresloaded')
                   @include('layouts.partials.forms.supplierrate')
                   @include('layouts.partials.forms.totalcostdisplay')                                          
                   @include('layouts.partials.forms.entryby')
                   @include('layouts.partials.forms.modifiedby')
                   <div id="hid">
                        @include('layouts.partials.forms.transactiondate')
                        @include('layouts.partials.forms.suppliernumberin')
                        @include('layouts.partials.forms.totalcost')                 
                        @include('layouts.partials.forms.supplier_name_in')
                   </div>
                
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                            {!! Form::submit('Add New Stock',['class'=>'btn btn-primary']) !!}

                            </div>
                        </div>
                        {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section("scripts")
{{!!$js!!}}
@endsection