@extends('layouts.app')
<?php


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
                console.log(dates);
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
            <div class="card-header">           
        
                <div class="col-auto">
                    {!! Form::open([
                    'method' => 'GET',
                    'class'=>"form-inline",
                    'action'=>'DisplayRecordsController@displayBankStatementDetailsReport'
                    ])!!}
                    @csrf

                        <div class="col-auto" style="display: none">
                        {!!Form::text('bank_name',null, ['class' => 'form-control','id'=>'bank_name'])!!}
                    </div>
        
                    
                    <div class="col-auto" style="display: none">
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
                                <th>LAST TRANSACTION DATE</th>
                                <th>BANK NAME</th>
                                <th>CURRENT BALANCE</th>
                         </tr>
                        </thead>

                        <tbody>
                            <tr>
                                @foreach($bankTransactions as $bankTransaction)
                                <td>
                                        <a href="{{
                                 route('reports.bankStatementReport',
                                [
                                    'bank_name'=>request('bank_name'),
                                    'bank_name'=>$bankTransaction['bank_name']
                                    
                                ] 
                                )
                                 }}" style="color: black">
                             
                                    {{$bankTransaction['transaction_date']}}
                                        </a>
                                    </td>

                                                                  <td>
                                        <a href="{{
                                 route('reports.bankStatementReport',
                                [
                                      'bank_name'=>request('bank_name'),
                                    'bank_name'=>$bankTransaction['bank_name']
                                  
                                ] 
                                )
                                 }}" style="color: black">
                             
                                    {{$bankTransaction['bank_name']}}
                                        </a>
                                    </td>
                             
                                    
                                    
                                         
                                                                 
                                           <td>
                                        <a href="{{
                                 route('reports.bankStatementReport',
                                [
                                      'bank_name'=>request('bank_name'),
                                    'bank_name'=>$bankTransaction['bank_name']
                                  
                                ] 
                                )
                                 }}" style="color: black">
                             
                                    {{ number_format($bankTransaction['balance'],1)}}
                                        </a>
                                    </td>
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



