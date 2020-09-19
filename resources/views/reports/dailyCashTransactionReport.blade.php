@extends('layouts.app')
<?php
$js=<<<JS
window.onload = function () {



    var dateQueryEnd = document.querySelector("#dateQueryEnd");
    var dateQuery = document.querySelector("#dateQuery");
 
 getTransactionDateRange();
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


    function getTransactionDateRange() {
        request = createRequest();
        if (request == null) {

        }


        var url =  "../getTransactionDateRange/"
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
}

JS;

?>
@section('content')
    
<div class="container">
    
            <div class="row justify-content-center">
                    <div class="col-auto">

                    {!! Form::open([
                    'method' => 'GET',
                    'class'=>"form-inline",                                          
                    'action'=>'DisplayRecordsController@displayDailyCashTransactionReport'
                    ])!!}
                    @csrf
                  
                    <div class="col-auto" id="dateQueryDiv">
                        {!! Form::date('dateQuery',null,['class'=> 'form-control', "id"=>"dateQuery"]) !!}
                    </div>
                    <div class="col-auto" id="dateQueryEndDiv">
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
                    'action'=>'DisplayRecordsController@displayDailyCashTransactionReport'
                    ])!!}
                    @csrf

                    <div class="col-auto" style="display:none">
                        {!!Form::text('export',null, ['class' => 'form-control'])!!}
                    </div>

                    <div class="col-auto">
                        <button class="btn btn-success" type="submit">Export</button>
                    </div>
                    {!! Form::close() !!}
                 </div>
        
            </div>
        
           <div class="row justify-content-center">
                <h1>Daily Cash Transaction Reports</h1>
            </div>
   </div>
            
        <br><br>
        <div class="row justify-content-center">
            <div class="col-auto">
                 @if(isset($customerAccounts))
                <table class="table table-striped table-borded table-hover table-sm table-bordered">
                    <thead>
                        <tr>
                            <th>DATE</th>
                            <th>NAME</th>                            
                            <th>PAYMENT MODE</th>
                            <th>PAYMENT STATUS</th>
                            <th>BANK NAME</th>
                            <th>NARRATION</th>
                            <th>AMOUNT</th>
                            <th>BALANCE</th>
                        </tr>
                    </thead>

                    <tbody>
                            @foreach($customerAccounts as $customerAccount)
                        <tr>
                            <td>{{$customerAccount['transaction_date']}}</td>
                            <td>{{$customerAccount['name']}}</td>
                            <td>{{$customerAccount['payment_mode']}}</td>
                            <td>{{$customerAccount['payment_status']}}</td>
                            <td>{{$customerAccount['bank_name']}}</td>
                            <td>{{$customerAccount['narration']}}</td>
                            <td>{{number_format($customerAccount['amount_paid'],2)}}</td>
                            <td>{{number_format($customerAccount['balance'],2)}}</td>
                        </tr>
                        @endforeach                       
                    </tbody>
                </table>
                  {{$customerAccounts->appends($_GET)->links()}}
            @endif
                </div>
        </div>
    





@endsection
@section("scripts")
    {{!!$js!!}}
@endsection
    
    
    
    