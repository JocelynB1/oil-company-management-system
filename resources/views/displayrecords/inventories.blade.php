@extends('layouts.app')
@section('content')
<?php


$fieldList=array(
    
   
        "id"=>"ID",
        "supplier_name"=>"Supplier Name",
        "truck_number"=>"Truck Number",
        "driver_name"=>"Driver Name",
        "driver_phone"=>"Driver Phone",
        "product_type"=>"Product Type",
        "litres_loaded"=>"Litres Loaded",
        "supplier_rate"=>"Supplier Rate",
        "unit_price"=>"Unit Price",
        "total_cost"=>"Total Cost",
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
        "pdf"      => "pdf",
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
    <h1>Stock</h1>
    <div class="row">
        <div class="col-auto">

            {!! Form::open([
            'method' => 'GET',
            'class'=>"form-inline",                          
            'action'=>'DisplayRecordsController@displayInventories'
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
        
            <a href="{{route('displayrecords.inventories')}}">Reset</a>
        </div>
<div class="col-auto text-right">
        <a href="{{route('displayrecords.inventories',['supplier_name'=>request('supplier_name'),'sort'=>'asc'])}}">Ascending</a>
        <a href="{{route('displayrecords.inventories',['supplier_name'=>request('supplier_name'),'sort'=>'desc'])}}">Descending</a>
        </div>
    </div>
    <div class="row">   
        <div class="form-row align-items-center">            
            {!! Form::open([
            'method' => 'GET',
            'class'=>"form-inline",
            'action'=>'ExcelController@exportInventories'
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
        <th>Supplier Name</th>
        <th>Truck Number</th>
        <th>Driver Name</th>
        <th>Driver Phone</th>
        <th>Type Of Product</th>
        <th>Litres Loaded</th>
        <th>Supplier Rate</th>
        <th>Unit Price</th>
        <th>Total Cost</th>
        <th>Entry By</th>
        <th>Modified By</th>
        <th>Created At</th>
        <th>Updated At</th>
    </tr>
    <tbody>
        @foreach($inventories as $inventory)
        <tr>
                <td>  {!! Form::open([
                        'method' => 'DELETE',
                        'action' => ['DestroyController@destroyInventories', $inventory->id]
                    ]) !!}
                        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                    {!! Form::close() !!}
                </td>
        <td><a href="{{ action('EditController@editInventories', $inventory->id) }}" style="color: black">{{$inventory->id}}</a></td>
        <td><a href="{{ action('EditController@editInventories', $inventory->id) }}" style="color: black">{{$inventory->supplier_name}}</a></td>
        <td><a href="{{ action('EditController@editInventories', $inventory->id) }}" style="color: black">{{$inventory->truck_number}}</a></td>
        <td><a href="{{ action('EditController@editInventories', $inventory->id) }}" style="color: black">{{$inventory->driver_name}}</a></td>
        <td><a href="{{ action('EditController@editInventories', $inventory->id) }}" style="color: black">{{$inventory->driver_phone}}</a></td>
        <td><a href="{{ action('EditController@editInventories', $inventory->id) }}" style="color: black">{{$inventory->product_type}}</a></td>  
        <td><a href="{{ action('EditController@editInventories', $inventory->id) }}" style="color: black">{{$inventory->litres_loaded}}</a></td>
        <td><a href="{{ action('EditController@editInventories', $inventory->id) }}" style="color: black">{{$inventory->supplier_rate}}</a></td>
        <td><a href="{{ action('EditController@editInventories', $inventory->id) }}" style="color: black">{{$inventory->unit_price}}</a></td>
        <td><a href="{{ action('EditController@editInventories', $inventory->id) }}" style="color: black">{{$inventory->total_cost}}</a></td>
        <td><a href="{{ action('EditController@editInventories', $inventory->id) }}" style="color: black">{{$inventory->modified_by}}</a></td>
        <td><a href="{{ action('EditController@editInventories', $inventory->id) }}" style="color: black">{{$inventory->created_by}}</a></td>            
        <td><a href="{{ action('EditController@editInventories', $inventory->id) }}" style="color: black">{{$inventory->created_at}}</a></td>
        <td><a href="{{ action('EditController@editInventories', $inventory->id) }}" style="color: black">{{$inventory->updated_at}}</a></td>
        </tr>
        @endforeach
    </tbody>
</thead>
</table>
{{$inventories->appends($_GET)->links()}}
</div>

@endsection
@section("scripts")
<?php
echo $a;
?>
@endsection


