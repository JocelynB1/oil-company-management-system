@extends('layouts.app')
@section('content')
<?php


$fieldList=array(
    
   
        "id"=>"ID",
        "sales_date"=>"Sales Date",
        "customer_number"=>"Customer Number",
        "customer_name"=>"Customer Name",
        "litres_pumped"=>"Litres Pumped",
        "product_type"=>"Product Type",
        "shortages"=>"Shortages",
        "unit_price"=>"Unit Price",
        "payment_mode"=>"Payment Mode",
        "bank_name"=>"Bank Name",
        "supplier_name"=>"Supplier Name",
        "description"=>"Description",
        "discount_rate"=>"Discount Rate",
        "cash_discount_allowed"=>"Cash Discount Allowed",
        "total_cost"=>"Total Cost",
        "amount_paid"=>"Amount Paid",
        "balance"=>"Balance",
        "transaction_code"=>"Transaction Code",
        "stage_reached"=>"Stage Reached",
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
    <h1>List Sales</h1>
    <div class="row">
        <div class="col-auto">

            {!! Form::open([
            'method' => 'GET',
            'class'=>"form-inline",                                  
            'action'=>'DisplayRecordsController@displaySales'
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
        
            <a href="{{route('displayrecords.sales')}}">Reset</a>
        </div>
           <div class="col-auto text-right">
        <a href="{{route('displayrecords.sales',['sales_date'=>request('sales_date'),'sort'=>'asc'])}}">Ascending</a>
        <a href="{{route('displayrecords.sales',['sales_date'=>request('sales_date'),'sort'=>'desc'])}}">Descending</a>
        </div>
    </div>
    <div class="row">   
        <div class="form-row align-items-center">            
            {!! Form::open([
            'method' => 'GET',
            'class'=>"form-inline",
            'action'=>'ExcelController@exportSales'
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
        <th>Sales Date</th>
        <th>Customer Name</th>
        <th>Customer Account</th>
        <th>Litres Pumped</th>
        <th>Type Of Product</th>
        <th>Shortages</th>
        <th>Cheque Number</th>
        <th>Unit Price</th>
        <th>Payment Mode</th>
        <th>Name Of Bank</th>
        <th>Supplier Name</th>
        <th>Description</th>
        <th>Discount Rate</th>
        <th>Cash Discount Allowed</th>
        <th>Total Cost</th>
        <th>Amount Paid</th>
        <th>Balance</th>
        <th>Transaction Code</th>
        <th>Stage Reached</th>
        <th>Created At</th>
        <th>Updated At</th>
    </tr>
    <tbody>
        @foreach($sales as $sale)
        <tr>
        <td><a href="{{ action('EditController@editSales', $sale->id) }}" style="color: black">{{$sale->id}}</a></td>
        <td><a href="{{ action('EditController@editSales', $sale->id) }}" style="color: black">{{$sale->sales_date}}</a></td>
        <td><a href="{{ action('EditController@editSales', $sale->id) }}" style="color: black">{{$sale->customer_name}}</a></td>
        <td><a href="{{ action('EditController@editSales', $sale->id) }}" style="color: black">{{$sale->customer_number }}</a></td>
        <td><a href="{{ action('EditController@editSales', $sale->id) }}" style="color: black">{{$sale->litres_pumped}}</a></td>            
        <td><a href="{{ action('EditController@editSales', $sale->id) }}" style="color: black">{{$sale->product_type}}</a></td>
        <td><a href="{{ action('EditController@editSales', $sale->id) }}" style="color: black">{{$sale->shortages}}</a></td>
        <td><a href="{{ action('EditController@editSales', $sale->id) }}" style="color: black">{{$sale->cheque_number}}</a></td>
        <td><a href="{{ action('EditController@editSales', $sale->id) }}" style="color: black">{{$sale->unit_price}}</a></td>
        <td><a href="{{ action('EditController@editSales', $sale->id) }}" style="color: black">{{$sale->payment_mode}}</a></td>
        <td><a href="{{ action('EditController@editSales', $sale->id) }}" style="color: black">{{$sale->bank_name}}</a></td>
        <td><a href="{{ action('EditController@editSales', $sale->id) }}" style="color: black">{{$sale->supplier_name}}</a></td>
        <td><a href="{{ action('EditController@editSales', $sale->id) }}" style="color: black">{{$sale->description}}</a></td>            
        <td><a href="{{ action('EditController@editSales', $sale->id) }}" style="color: black">{{$sale->discount_rate}}</a></td>
        <td><a href="{{ action('EditController@editSales', $sale->id) }}" style="color: black">{{$sale->cash_discount_allowed}}</a></td>
        <td><a href="{{ action('EditController@editSales', $sale->id) }}" style="color: black">{{$sale->total_cost}}</a></td>
        <td><a href="{{ action('EditController@editSales', $sale->id) }}" style="color: black">{{$sale->amount_paid}}</a></td>
        <td><a href="{{ action('EditController@editSales', $sale->id) }}" style="color: black">{{$sale->balance}}</a></td>
        <td><a href="{{ action('EditController@editSales', $sale->id) }}" style="color: black">{{$sale->transaction_code}}</a></td>            
        <td><a href="{{ action('EditController@editSales', $sale->id) }}" style="color: black">{{$sale->stage_reached}}</a></td>
        <td><a href="{{ action('EditController@editSales', $sale->id) }}" style="color: black">{{$sale->created_at}}</a></td>
        <td><a href="{{ action('EditController@editSales', $sale->id) }}" style="color: black">{{$sale->updated_at}}</a></td>
        </tr>
        @endforeach
    </tbody>
</thead>
</table>
{{$sales->appends($_GET)->links()}}
</div>

@endsection
@section("scripts")
<?php
echo $a;
?>
@endsection



