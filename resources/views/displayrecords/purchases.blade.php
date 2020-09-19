@extends('layouts.app')
@section('content')
<?php


$fieldList=array(
    
   
        "id"=>"ID",
        "supplier_name"=>"Supplier Name",
        "type_of_purchase"=>"Purchase Type",
        "truck_number"=>"Truck Number",
        "driver_name"=>"Driver Name",
        "litres_loaded"=>"Litres Loaded",
        "shortages_in_litres"=>"Shortages In Litres",
        "net_loading_in_litres"=>"Net Loading In Litres",
        "total_cost"=>"Total Cost",
        "unit_price"=>"Unit Price",
        "total_shortage"=>"Total Shortage",
        "amount_paid"=>"Amount Paid",
        "balance"=>"Balance",
        "payment_mode"=>"Payment Mode",
        "bank_name"=>"Bank Name",
        "cheque_number"=>"Cheque Number",
        "narration"=>"Narration",
        "transaction_code"=>"Transaction Code",
        "transaction_date"=>"Transaction Date",
        "created_by"=>"Created By",
        "created_at"=>"Created At",
        "updated_at"=>"Updated At"

);

$exportFieldList=array(
        'xlsx'     => "xlsx",
        'xls'      => "xls",
        'html'     => "html",
        'csv'      => "csv",
        "pdf"=>"pdf",
);



        
        $a=<<<JS

window.onload = function () {

if (document.querySelector("#dateQuery")) {

    var dateQueryEnd = document.querySelector("#dateQueryEnd");
    var dateQuery = document.querySelector("#dateQuery");
    dateQueryEnd.disabled = true;
    dateQuery.disabled = true;


    document.querySelector("#dateQueryDiv").style.display = "none";
    document.querySelector("#dateQueryEndDiv").style.display = "none";

    var field = document.querySelector("#field");

    var textQuery = document.querySelector("#query");

    field.addEventListener('change', function (e) {
        switch (field.value) {
            case "date_of_last_transaction":
                switchToDateQueryInputs()
                break;

            case "created_at":
                switchToDateQueryInputs();
                break;

            case "updated_at":
                switchToDateQueryInputs();
                break;

            case "sales_date":
                switchToDateQueryInputs();
                break;
                case "transaction_date":
                switchToDateQueryInputs();
                break;  

            case "approval_date":
                switchToDateQueryInputs();
                break;

            default:
            switchToTextQueryInputs();
                break;
        }

        if (e.target != e.currentTarget) {
            e.preventDefault();
        }
        e.stopPropagation();
    }, false);
}
function switchToDateQueryInputs() {
    textQuery.style.display = "none";
    textQuery.disabled = true;
    dateQuery.disabled = false;
    dateQueryEnd.disabled = false;
    dateQuery.style.display = "block";
    dateQueryEnd.style.display = "block";
    document.querySelector("#dateQueryEndDiv").style.display = "block";
    document.querySelector("#dateQueryDiv").style.display = "block";
}
function switchToTextQueryInputs() {
    textQuery.style.display = "block";
    textQuery.disabled = false;
    dateQuery.disabled = true;
    dateQueryEnd.disabled = true;
    dateQuery.style.display = "none";
    dateQueryEnd.style.display = "none";
    document.querySelector("#dateQueryDiv").style.display = "none";
    document.querySelector("#dateQueryEndDiv").style.display = "none";

}
}



JS;


?>
<div class="container">
    <h1>List of Purchases</h1>
    <div class="row">
        <div class="col-auto">

            {!! Form::open([
            'method' => 'GET',
        
            'action'=>'DisplayRecordsController@displayPurchases'
            ])!!}
            @csrf
        
            <div class="form-row align-items-center">
                {!! Form::label('field','Filter:',['class'=>
                'col-auto col-form-label']) !!}
                <div class="col-auto">
                    {!!Form::select('field',$fieldList ,null, ['class' => 'form-control'])!!}
                </div>
                {!! Form::label('query','Query:',['class'=>
                'col-auto col-form-label']) !!}
                <div class="col-auto" id="textQueryDiv">
                    {!! Form::text('query',null,['class'=> 'form-control',"id"=>"query"]) !!}
                </div>
                <div class="col-auto" id="dateQueryDiv" style="display:none">
                    {!! Form::date('dateQuery',null,['class'=> 'form-control', "id"=>"dateQuery"]) !!}
                </div>
                <div class="col-auto" id="dateQueryEndDiv" style="display:none">
                        {!! Form::date('dateQueryEnd',null,['class'=> 'form-control', "id"=>"dateQueryEnd"]) !!}
                    </div>
    
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">
                        Search
                    </button>
                </div>
            </div>
        
        
            {!! Form::close() !!}
        
            <a href="{{route('displayrecords.purchases')}}">Reset</a>
        </div>
         <div class="col-auto text-right">
        <a href="{{route('displayrecords.purchases',['supplier_name'=>request('supplier_name'),'sort'=>'asc'])}}">Ascending</a>
        <a href="{{route('displayrecords.purchases',['supplier_name'=>request('supplier_name'),'sort'=>'desc'])}}">Descending</a>
        </div>
    </div>
    <div class="row">   
        <div class="form-row align-items-center">            
            {!! Form::open([
            'method' => 'GET',
            'class'=>"form-inline",
            'action'=>'ExcelController@exportPurchases'
            ])!!}
            @csrf

            <div class="col-auto">            
                    {!! Form::label('format','Format:',['class'=>
                    'col-auto col-form-label']) !!}
                </div>
                <div class="col-auto">
                    {!!Form::select('format',$exportFieldList ,null, ['class' => 'form-control'])!!}
                </div>
    
                <div class="col-auto">
                    <button class="btn btn-success" type="submit">Export</button>
                </div>
 
            {!! Form::close() !!}
        </div>
  </div>

<table class="table table-striped table-borded table-hover table-sm table-bordered">
<thead>
    <tr>
        <th>ID</th>
        <th>Supplier Name</th>
        <th>Product Type</th>
        <th>Truck Number</th>
        <th>Driver Name</th>
        <th>Litres Loaded</th>
        <th>Shortages In Litres</th>
        <th>Net Loading In Litres</th>
        <th>Price Per Litre</th>
        <th>Unit Price</th>
        <th>Total Shortage</th>
        <th>Total Cost</th>
        <th>Amount Paid</th>
        <th>Balance</th>
        <th>Payment Mode</th>
        <th>Name Of Bank</th>
        <th>Cheque Number</th>
        <th>Narration</th>
        <th>Transaction Code</th>
        <th>Transaction Date</th>
        <th>Created By</th>
        <th>Created At</th>
        <th>Updated At</th>
    </tr>
    <tbody>
        @foreach($purchases as $purchase)
        <tr>
         <td><a href="{{ action('EditController@editPurchases', $purchase->id) }}" style="color: black">{{$purchase->id}}</a></td>
        <td><a href="{{ action('EditController@editPurchases', $purchase->id) }}" style="color: black">{{$purchase->supplier_name}}</a></td>
        <td><a href="{{ action('EditController@editPurchases', $purchase->id) }}" style="color: black">{{$purchase->product_type }}</a></td>
        <td><a href="{{ action('EditController@editPurchases', $purchase->id) }}" style="color: black">{{$purchase->truck_number}}</a></td>            
        <td><a href="{{ action('EditController@editPurchases', $purchase->id) }}" style="color: black">{{$purchase->driver_name}}</a></td>
        <td><a href="{{ action('EditController@editPurchases', $purchase->id) }}" style="color: black">{{$purchase->litres_loaded}}</a></td>
        <td><a href="{{ action('EditController@editPurchases', $purchase->id) }}" style="color: black">{{$purchase->shortages_in_litres}}</a></td>
        <td><a href="{{ action('EditController@editPurchases', $purchase->id) }}" style="color: black">{{$purchase->net_loading_in_litres}}</a></td>
        <td><a href="{{ action('EditController@editPurchases', $purchase->id) }}" style="color: black">{{$purchase->price_per_litre}}</a></td>
        <td><a href="{{ action('EditController@editPurchases', $purchase->id) }}" style="color: black">{{$purchase->unit_price}}</a></td>
        <td><a href="{{ action('EditController@editPurchases', $purchase->id) }}" style="color: black">{{$purchase->total_shortage}}</a></td>
        <td><a href="{{ action('EditController@editPurchases', $purchase->id) }}" style="color: black">{{$purchase->total_cost}}</a></td>
        <td><a href="{{ action('EditController@editPurchases', $purchase->id) }}" style="color: black">{{$purchase->amount_paid}}</a></td>            
        <td><a href="{{ action('EditController@editPurchases', $purchase->id) }}" style="color: black">{{$purchase->balance}}</a></td>
        <td><a href="{{ action('EditController@editPurchases', $purchase->id) }}" style="color: black">{{$purchase->payment_mode}}</a></td>
        <td><a href="{{ action('EditController@editPurchases', $purchase->id) }}" style="color: black">{{$purchase->bank_name}}</a></td>
        <td><a href="{{ action('EditController@editPurchases', $purchase->id) }}" style="color: black">{{$purchase->cheque_number}}</a></td>
        <td><a href="{{ action('EditController@editPurchases', $purchase->id) }}" style="color: black">{{$purchase->narration}}</a></td>
        <td><a href="{{ action('EditController@editPurchases', $purchase->id) }}" style="color: black">{{$purchase->transaction_code}}</a></td>            
        <td><a href="{{ action('EditController@editPurchases', $purchase->id) }}" style="color: black">{{$purchase->transaction_date}}</a></td>
        <td><a href="{{ action('EditController@editPurchases', $purchase->id) }}" style="color: black">{{$purchase->created_by}}</a></td>
        <td><a href="{{ action('EditController@editPurchases', $purchase->id) }}" style="color: black">{{$purchase->created_at}}</a></td>
        <td><a href="{{ action('EditController@editPurchases', $purchase->id) }}" style="color: black">{{$purchase->updated_at}}</a></td>
        </tr>
        @endforeach
    </tbody>
</thead>
</table>
{{$purchases->appends($_GET)->links()}}
</div>

@endsection
@section("scripts")
<?php
echo $a;
?>
@endsection



