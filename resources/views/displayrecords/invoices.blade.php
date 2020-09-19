@extends('layouts.app')
@section('content')

<?php

/*
<div class="row">
                                {!! Form::open([
                                'method' => 'GET',
                                'action'=>'DisplayRecordsController@displayinvoices'
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
                               
                                {!! Form::close() !!}

                                <a href="{{route('displayrecords.invoices')}}">Reset</a>
                            </div>
                            <div>
                                <a href="{{route('displayrecords.invoices',['sales_date'=>request('sales_date'),'sort'=>'asc'])}}">Ascending</a>
                                <a href="{{route('displayrecords.invoices',['sales_date'=>request('sales_date'),'sort'=>'desc'])}}">Descending</a>
                            </div>
                        </div>
*/
$fieldList=array(

""=>"",
"sales_date"=>"Date Posted",
"customer_name"=>"Customer Name",
"customer_number"=>"Account Number",
"supplier_name"=>"Supplier Name"

);


$a=<<<JS
window.onload = function () {
    var field = document.querySelector("#field");
    var textQuery = document.querySelector("#query");
    field.value="stage_reached";
    textQuery= "invoiced";

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
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Manage invoices</div>

                <div class="card-body">

                    <div class="container">
                        
                        @if(isset($sales))
                        <table class="table table-striped table-borded table-hover table-sm table-bordered">
                            <thead>
                                <tr>
                                    
                                    <th>Date Posted</th>
                                    <th>Supplier Name</th>
                                    <th>Account Number</th>
                                    <th>Process Invoice</th>             
                                </tr>
                            </thead>                
                            <tbody>
                                @foreach($sales as $accountantsale)
                                <tr>
                                  
                                    <td>{{$accountantsale->transaction_date}}</td>            
                                    <td>{{$accountantsale->supplier_name}}</td>   
                                    <td>{{ $accountantsale->account_number}}</td>
                                    <td>
                                        <a href="{{ route('invoices.edit', $accountantsale->id) }}"  class="btn btn-primary">Complete Sale</a>
                                    </td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{$sales->appends($_GET)->links()}}
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section("scripts")
<?php
echo $a;
?>
@endsection