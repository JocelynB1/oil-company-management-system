@extends('layouts.app')
@section('content')

<?php


$fieldList=array(
    
   
        "id"=>"ID",
        "trn_ref_no"=>"Reference Number",
        "transaction_date"=>"Transaction Date",
        "product_type"=>"Product Type",
        "liters"=>"Liters",
        "selling_rate"=>"Rate",
        "total_cost"=>"Total Cost",
        "amount_paid"=>"Amount Paid",
        "balance"=>"Balance",
        "narration"=>"Narration",
        "transaction_code"=>"Transaction code",
        "customer_name"=>"Customer Name",
        "shortages"=>"Shortages",
        "supplier_name"=>"Supplier Name",
        "unit_price"=>"Unit Price",
        "payment_mode"=>"Payment Mode",
        "bank_name"=>"Bank Name",
        "cheque_number"=>"Cheque Number",
        "payment_status"=>"Payment Status",
        "discount_rate"=>"Discount Rate",
        "cash_discount_allowed"=>"Cash Discount Allowed",
        "approval_status"=>"Approval Status",
        "approval_date"=>"Approval Date",
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
    <h1>List Transactions</h1>
    <div class="row">
            <div class="col-auto">

                    {!! Form::open([
                    'method' => 'GET',
                    'class'=>"form-inline",                                          
                    'action'=>'DisplayRecordsController@displayTransactions'
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
                
                    <a href="{{route('displayrecords.transactions')}}">Reset</a>
                </div>
                   <div class="col-auto text-right">
        <a href="{{route('displayrecords.transactions',['transaction_date'=>request('transaction_date'),'sort'=>'asc'])}}">Ascending</a>
        <a href="{{route('displayrecords.transactions',['transaction_date'=>request('transaction_date'),'sort'=>'desc'])}}">Descending</a>
        </div>
    </div>
    <div class="row">   
        <div class="form-row align-items-center">            
            {!! Form::open([
            'method' => 'GET',
            'class'=>"form-inline",
            'action'=>'ExcelController@exportTransactions'
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
        <th>Transaction Reference Number</th>
        <th>Transaction Date</th>
        <th>Product Type</th>
        <th>Liters</th>
        <th>Rate</th>
        <th>Total Cost</th>
        <th>Amount Paid</th>
        <th>Balance</th>
        <th>Narration</th>
        <th>Transaction Code</th>
        <th>Customer Name</th>
        <th>Shortages</th>
        <th>Supplier Name</th>
        <th>Unit Price</th>
        <th>Payment Mode</th>
        <th>Bank Name</th>
        <th>Cheque Number</th>
        <th>Payment Status</th>
        <th>Discount Rate</th>
        <th>Cash Discount Allowed</th>
        <th>Account Number</th>
        <th>Approval Status</th>
        <th>Approval Date</th>
        <th>Approved By</th>
        <th>Created At</th>
        <th>Updated At</th>
        </tr>
    <tbody>
        @foreach($transactions as $transaction)
        <tr>
            
        <td>{{$transaction->id}}</td>
        <td>{{$transaction->trn_ref_no}}</td>
        <td>{{$transaction->transaction_date}}</td>            
        <td>{{$transaction->product_type}}</td>            
        <td>{{$transaction->liters}}</td>            
        <td>{{$transaction->selling_rate}}</td>            
        <td>{{$transaction->total_cost}}</td>            
        <td>{{$transaction->amount_paid}}</td>            
        <td>{{$transaction->balance}}</td>            
        <td>{{$transaction->narration}}</td>            
        <td>{{$transaction->transaction_code}}</td>            
        <td>{{$transaction->customer_name}}</td>            
        <td>{{$transaction->shortages}}</td>            
        <td>{{$transaction->supplier_name}}</td>            
        <td>{{$transaction->unit_price}}</td>            
        <td>{{$transaction->payment_mode}}</td>            
        <td>{{$transaction->bank_name}}</td>            
        <td>{{$transaction->cheque_number}}</td>            
        <td>{{$transaction->payment_status}}</td>            
        <td>{{$transaction->discount_rate}}</td>            
        <td>{{$transaction->cash_discount_allowed}}</td>            
        <td>{{$transaction->account_number}}</td>            
        <td>{{$transaction->approval_status}}</td>            
        <td>{{$transaction->approval_date}}</td>            
        <td>{{$transaction->approved_by}}</td>                       
        <td>{{$transaction->created_at}}</td>
        <td>{{$transaction->updated_at}}</td>
        </tr>
        @endforeach
    </tbody>
</thead>
</table>
{{$transactions->appends($_GET)->links()}}
</div>

@endsection
@section("scripts")
<?php
echo $a;
?>
@endsection



