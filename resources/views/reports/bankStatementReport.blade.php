@extends('layouts.app')
<?php
$field=[];
$b = \DB::table('bank_accounts')
            ->select("bank_name")
            ->distinct()
            ->get();
foreach ($b as $key => $value) {
 $transactions = \DB::table('transactions')
                    ->where("bank_name", "=", $value->bank_name)
                    ->orderby('created_at', 'asc')
                    ->get();
               
                 
if(!empty($transactions->toArray())){
    $field[$value->bank_name]=$value->bank_name;
}
  
}
//$field = \App\Transaction::pluck( 'bank_name','bank_name');
$fieldList = collect(['' => ''] + $field);


$js=<<<JS


    var dateQueryEnd = document.querySelector("#dateQueryEnd");
    var dateQuery = document.querySelector("#dateQuery");
    dateQueryEnd.disabled = true;
    dateQuery.disabled = true;
    getTransactionDateRangeOfBanks(null);
    showDateQueryInputs();

function showDateQueryInputs() {
    dateQuery.disabled = false;
    dateQueryEnd.disabled = false;
    dateQuery.style.display = "block";
    dateQueryEnd.style.display = "block";
    document.querySelector("#dateQueryEndDiv").style.display = "block";
    document.querySelector("#dateQueryDiv").style.display = "block";
}


function createRequest() {
        try {
            request = new XMLHttpRequest();
        } catch (tryMS) {
            try {
                request = new ActiveXObject("Msxml2.XMLHTTP");
            } catch (otherMS) {
                try {
                    request = new ActiveXObject("Microsoft.XMLHTTP");
                } catch (failed) {
                    request = null;
                }
            }
        }
        return request;
    }


    function getTransactionDateRangeOfBanks(query) {
        request = createRequest();
        if (request == null) {

        }


        var url =  "/getTransactionDateRangeOfBanks/" + query + "/"
        request.onreadystatechange = setStartAndEndDates;
        request.open("GET", url, true);
        request.setRequestHeader("Accept", "text/plain");
        request.setRequestHeader("Content-Type", "text/plain");
        request.responseType = 'text';
        request.send();

    }
    function setStartAndEndDates() {
        if (request.readyState == 4) {
            if (request.status == 200) {
                var dates = JSON.parse(request.responseText);
                var startDate=dates[0].transaction_date;
                var  endDate=dates[dates.length-1].transaction_date;
                dateQuery.value = startDate;
                dateQueryEnd.value = endDate;         
            }
        }
    }


JS;



?>
@section('content')

<div class="container">
    <div class="card card-default">
        <div class="card-body">
                  
            <div class="row">
                <div class="col-auto">

                    {!! Form::open([
                    'method' => 'GET',
                    'class'=>"form-inline",                                          
                    'action'=>'DisplayRecordsController@displayBankStatementReport'
                    ])!!}
                    @csrf
                       {!! Form::label('bank_name','Bank Name:',['class'=>'col-auto col-form-label']) !!}
                        <div class="col-auto">
                            {!!Form::select('bank_name',$fieldList ,null, ['class' => 'form-control'])!!}
                        </div>
                     
                        <div class="col-auto" id="dateQueryDiv" style="display:none">
                        {!! Form::date('dateQuery',null,['class'=> 'form-control', "id"=>"dateQuery"]) !!}
                    </div>
                    <div class="col-auto" id="dateQueryEndDiv" style="display:none">
                            {!! Form::date('dateQueryEnd',null,['class'=> 'form-control', "id"=>"dateQueryEnd"]) !!}
                        </div>

                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary">
                            Submit
                        </button>
                    </div>
                    {!! Form::close() !!}
                </div>
                <div class="col-auto">
                    {!! Form::open([
                    'method' => 'GET',
                    'class'=>"form-inline",
                    'action'=>'DisplayRecordsController@displayBankStatementReport'
                    ])!!}
                    @csrf

                    
                    <div class="col-auto" style="display: none">
                            {!!Form::select('bank_name',$fieldList ,null, ['class' => 'form-control'])!!}
                        {!! Form::date('dateQuery',null,['class'=> 'form-control', "id"=>"dateQuery"]) !!}
                            {!! Form::date('dateQueryEnd',null,['class'=> 'form-control', "id"=>"dateQueryEnd"]) !!}
                     
                        {!!Form::text('export',null, ['class' => 'form-control'])!!}
                    </div>

                    <div class="col-auto">
                        <button class="btn btn-success" type="submit">Export</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
            
</div>
    </div>
<br><br>
            <div class="row justify-content-center">
                <div class="col-auto">
                        @if(isset($bankTransactions))

                    <table class="table table-striped table-borded table-hover table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>DATE</th>
                                <th>BANK NAME</th>
                                <th>CHEQUE NUMBER</th>
                                <th>NARRATION</th>
                                <th>ACCOUNT NAME</th>
                                <th>AMOUNT</th>
                                <th>BALANCE</th>
                         </tr>
                        </thead>

                        <tbody>
                            <tr>
                                @foreach($bankTransactions as $bankTransaction)
                                <td>{{$bankTransaction['transaction_date']}}</td>
                                <td>{{$bankTransaction['bank_name']}}</td>
                                <td>{{$bankTransaction['cheque_number']}}</td>
                                <td>{{$bankTransaction['narration']}}</td>
                                <td>{{$bankTransaction['customer_name']}}</td>
                                <td>{{ number_format($bankTransaction['amount'],2)}}</td>
                                <td>{{ number_format($bankTransaction['balance'],2)}}</td>
                              </tr>
                            @endforeach
                        </tbody>
                    </table>
                           {{$bankTransactions->appends($_GET)->links()}}
                        @endif
                        </div>
            </div>
        </div>
    



@endsection
@section("scripts")
{{!!$js!!}}
@endsection



