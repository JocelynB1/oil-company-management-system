@extends('layouts.app')
@section('content')
<?php


$fieldList=array(
    
   
        "id"=>"ID",
        "supplier_number"=>"Supplier Number",
        "supplier_name"=>"Supplier Name",
        "company_name"=>"Company Name",
        "phone_number"=>"Phone Number",
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
    <h1>List Suppliers</h1>
    <div class="row">
            <div class="col-auto">

                    {!! Form::open([
                    'method' => 'GET',
                    'class'=>"form-inline",                                          
                    'action'=>'DisplayRecordsController@displaySuppliers'
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
                
                    <a href="{{route('displayrecords.suppliers')}}">Reset</a>
                </div>
                   <div class="col-auto text-right">
        <a href="{{route('displayrecords.suppliers',['transaction_date'=>request('transaction_date'),'sort'=>'asc'])}}">Ascending</a>
        <a href="{{route('displayrecords.suppliers',['transaction_date'=>request('transaction_date'),'sort'=>'desc'])}}">Descending</a>
        </div>
    </div>
    <div class="row">   
        <div class="form-row align-items-center">            
            {!! Form::open([
            'method' => 'GET',
            'class'=>"form-inline",
            'action'=>'ExcelController@exportSuppliers'
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
        <th>Supplier Number</th>
        <th>Supplier Name</th>
        <th>Company Name</th>
        <th>Phone Number</th>
        <th>Created By</th>
        <th>Modified By</th>
        <th>Created At</th>
        <th>Updated At</th>
    </tr>
    <tbody>
        @foreach($suppliers as $supplier)
        <tr>
                <td>  {!! Form::open([
                        'method' => 'DELETE',
                        'action' => ['DestroyController@destroySuppliers', $supplier->id]
                    ]) !!}
                        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                    {!! Form::close() !!}
                </td>
        <td><a href="{{ action('EditController@editSuppliers', $supplier->id) }}" style="color: black">{{$supplier->id}}</a></td>
        <td><a href="{{ action('EditController@editSuppliers', $supplier->id) }}" style="color: black">{{$supplier->supplier_number}}</a></td>
        <td><a href="{{ action('EditController@editSuppliers', $supplier->id) }}" style="color: black">{{$supplier->supplier_name}}</a></td>            
        <td><a href="{{ action('EditController@editSuppliers', $supplier->id) }}" style="color: black">{{$supplier->company_name}}</a></td>            
        <td><a href="{{ action('EditController@editSuppliers', $supplier->id) }}" style="color: black">{{$supplier->phone_number}}</a></td>            
        <td><a href="{{ action('EditController@editSuppliers', $supplier->id) }}" style="color: black">{{$supplier->created_by}}</a></td>
        <td><a href="{{ action('EditController@editSuppliers', $supplier->id) }}" style="color: black">{{$supplier->modified_by}}</a></td>
        <td><a href="{{ action('EditController@editSuppliers', $supplier->id) }}" style="color: black">{{$supplier->created_at}}</a></td>
        <td><a href="{{ action('EditController@editSuppliers', $supplier->id) }}" style="color: black">{{$supplier->updated_at}}</a></td>
        </tr>
        @endforeach
    </tbody>
</thead>
</table>
{{$suppliers->appends($_GET)->links()}}
</div>

@endsection
@section("scripts")
<?php
echo $a;
?>
@endsection



