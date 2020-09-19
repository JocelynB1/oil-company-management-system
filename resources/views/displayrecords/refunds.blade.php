@extends('layouts.app')
@section('content')
<?php


$fieldList=array(
    
   
        "id"=>"ID",
        "transaction_date"=>"Transaction Date",
        "customer_name"=>"Customer Name",
        "account_number"=>"Account Number",
        "refund_amount"=>"Refund Amount",
        "payment_mode"=>"Payment Mode",
        "approval_status"=>"Approval Status",
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
    <h1>List Refunds</h1>
    <div class="row">
        <div class="col-auto">

            {!! Form::open([
            'method' => 'GET',
            'class'=>"form-inline",                                  
            'action'=>'DisplayRecordsController@displayRefunds'
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
        
            <a href="{{route('displayrecords.refunds')}}">Reset</a>
        </div>
        <div class="col-auto text-right">
        <a href="{{route('displayrecords.refunds',['transaction_date'=>request('transaction_date'),'sort'=>'asc'])}}">Ascending</a>
        <a href="{{route('displayrecords.refunds',['transaction_date'=>request('transaction_date'),'sort'=>'desc'])}}">Descending</a>
        </div>
    </div>
    <div class="row">   
        <div class="form-row align-items-center">            
            {!! Form::open([
            'method' => 'GET',
            'class'=>"form-inline",
            'action'=>'ExcelController@exportRefunds'
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
        <th>Transaction Date</th>
        <th>Customer Name</th>
        <th>Account Number</th>
        <th>Refund Amount</th>
        <th>Payment Mode</th>
        <th>Entry By</th>
        <th>Transaction Code</th>
        <th>Approval Status</th>
        <th>Created At</th>
        <th>Updated At</th>
    </tr>
    <tbody>
        @foreach($refunds as $refund)
        <tr>
        <td><a href="{{ action('EditController@editRefunds', $refund->id) }}" style="color: black">{{$refund->id}}</a></td>
        <td><a href="{{ action('EditController@editRefunds', $refund->id) }}" style="color: black">{{$refund->transaction_date}}</a></td>
        <td><a href="{{ action('EditController@editRefunds', $refund->id) }}" style="color: black">{{$refund->customer_name}}</a></td>
        <td><a href="{{ action('EditController@editRefunds', $refund->id) }}" style="color: black">{{$refund->account_number}}</a></td>            
        <td><a href="{{ action('EditController@editRefunds', $refund->id) }}" style="color: black">{{$refund->refund_amount}}</a></td>            
        <td><a href="{{ action('EditController@editRefunds', $refund->id) }}" style="color: black">{{$refund->payment_mode}}</a></td>            
        <td><a href="{{ action('EditController@editRefunds', $refund->id) }}" style="color: black">{{$refund->created_by}}</a></td>            
        <td><a href="{{ action('EditController@editRefunds', $refund->id) }}" style="color: black">{{$refund->transaction_code}}</a></td>            
        <td><a href="{{ action('EditController@editRefunds', $refund->id) }}" style="color: black">{{$refund->approval_status}}</a></td>            
        <td><a href="{{ action('EditController@editRefunds', $refund->id) }}" style="color: black">{{$refund->created_at}}</a></td>
        <td><a href="{{ action('EditController@editRefunds', $refund->id) }}" style="color: black">{{$refund->updated_at}}</a></td>
        </tr>
        @endforeach
    </tbody>
</thead>
</table>
{{$refunds->appends($_GET)->links()}}
</div>

@endsection
@section("scripts")
<?php
echo $a;
?>
@endsection



