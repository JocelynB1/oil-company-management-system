@extends('layouts.app')
@section('content')
<?php


$fieldList=array(
    
   
        "id"=>"ID",
        "selling_rate"=>"Selling Rate",
        "product_type"=>"Product Type",
        "modified_by"=>"Modified By",
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
    <h1>List Sales Rates</h1>
    <div class="row">
        <div class="col-auto">

            {!! Form::open([
            'method' => 'GET',
            'class'=>"form-inline",                          
            'action'=>'DisplayRecordsController@displaySalesRates'
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
        
            <a href="{{route('displayrecords.salesrates')}}">Reset</a>
        </div>
           <div class="col-auto text-right">
        <a href="{{route('displayrecords.salesrates',['transaction_date'=>request('transaction_date'),'sort'=>'asc'])}}">Ascending</a>
        <a href="{{route('displayrecords.salesrates',['transaction_date'=>request('transaction_date'),'sort'=>'desc'])}}">Descending</a>
        </div>
    </div>
    <div class="row">   
        <div class="form-row align-items-center">            
            {!! Form::open([
            'method' => 'GET',
            'class'=>"form-inline",
            'action'=>'ExcelController@exportSalesRates'
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
        <th>Delete</th>
        <th>ID</th>
        <th>Selling Rate</th>
        <th>Product Type</th>
        <th>Entry By</th>
        <th>Modified By</th>
        <th>Created At</th>
        <th>Updated At</th>
    </tr>
    <tbody>
        @foreach($salesrates as $salesrate)
        <tr>
                <td>  {!! Form::open([
                        'method' => 'DELETE',
                        'action' => ['DestroyController@destroySalesRates', $salesrate->id]
                    ]) !!}
                        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                    {!! Form::close() !!}
                </td>
        <td><a href="{{ action('EditController@editSalesRates', $salesrate->id) }}" style="color: black">{{$salesrate->id}}</a></td>
        <td><a href="{{ action('EditController@editSalesRates', $salesrate->id) }}" style="color: black">{{$salesrate->selling_rate}}</a></td>
        <td><a href="{{ action('EditController@editSalesRates', $salesrate->id) }}" style="color: black">{{$salesrate->product_type}}</a></td>
        <td><a href="{{ action('EditController@editSalesRates', $salesrate->id) }}" style="color: black">{{$salesrate->created_by}}</a></td>            
        <td><a href="{{ action('EditController@editSalesRates', $salesrate->id) }}" style="color: black">{{$salesrate->modified_by}}</a></td>            
        <td><a href="{{ action('EditController@editSalesRates', $salesrate->id) }}" style="color: black">{{$salesrate->created_at}}</a></td>
        <td><a href="{{ action('EditController@editSalesRates', $salesrate->id) }}" style="color: black">{{$salesrate->updated_at}}</a></td>
        </tr>
        @endforeach
    </tbody>
</thead>
</table>
{{$salesrates->appends($_GET)->links()}}
</div>

@endsection
@section("scripts")
<?php
echo $a;
?>
@endsection



