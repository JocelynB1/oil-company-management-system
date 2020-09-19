@extends('layouts.app')
<?php
$bank_list = \App\BankAccount::pluck('bank_name', 'bank_name');
$thereAreNoBanks=empty($bank_list->all());
if($thereAreNoBanks){
    $default=['' => 'No Bank Accounts have been set up!'];
}else{
    $default=['' => ''];
}

$bank_list = collect($default + $bank_list->all());

$js=<<<JS
window.onload = function () {

    document.querySelector("#originating_account_number_display").disabled=true;
    document.querySelector("#destination_account_number_display").disabled=true;
    document.querySelector("#transfer_to").disabled=true;
            

 if (document.querySelector("#transfer_from")) {

        var transfer_from = document.querySelector("#transfer_from");
        transfer_from.addEventListener('change', function (e) {

            getAccountNumberFromBankNameA(transfer_from.value);
         

         
            if (e.target != e.currentTarget) {
                e.preventDefault();
            }
            e.stopPropagation();
        }, false);
    }
   if (document.querySelector("#transfer_to")) {

        var transfer_to = document.querySelector("#transfer_to");
        transfer_to.addEventListener('change', function (e) {

            getAccountNumberFromBankNameB(transfer_to.value);
         
            if (e.target != e.currentTarget) {
                e.preventDefault();
            }
            e.stopPropagation();
        }, false);
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


    function getAccountNumberFromBankNameA(query) {
        request = createRequest();
        if (request == null) {

        }


        var url = "../getAccountNumberFromBankName/" + query+"/";
        request.onreadystatechange = setAccountNumberFromBankNameA;
        request.open("GET", url, true);
        request.setRequestHeader("Accept", "text/plain");
        request.setRequestHeader("Content-Type", "text/plain");
        request.responseType = 'text';
        request.send();

    }
 function getAccountNumberFromBankNameB(query) {
        request = createRequest();
        if (request == null) {

        }


        var url = "../getAccountNumberFromBankName/" + query+"/";
        request.onreadystatechange = setAccountNumberFromBankNameB;
        request.open("GET", url, true);
        request.setRequestHeader("Accept", "text/plain");
        request.setRequestHeader("Content-Type", "text/plain");
        request.responseType = 'text';
        request.send();

    }

    function setAccountNumberFromBankNameA() {
        if (request.readyState == 4) {
            if (request.status == 200) {
                var bankAccountNumberA = JSON.parse(request.responseText);
document.querySelector("#originating_account_number").value=bankAccountNumberA[0].account_number;
            document.querySelector("#originating_account_number_display").value=bankAccountNumberA[0].account_number;
                
                   document.querySelector("#transfer_to").disabled=false;
  var select=document.querySelector("#transfer_to");
  select.length=0;
     for (var i = 0; i < transfer_from.length; i++) {
      
         if(transfer_from[i].value != transfer_from.value){
 select.options[select.length] =
                    new Option(transfer_from[i].value, transfer_from[i].value);
         }
               
            }
        
if(select.length<=1){
 select.options[1] =
                    new Option("Please Add Another Bank Account",null);
    
}
            }
        }
    }

    function setAccountNumberFromBankNameB() {
        if (request.readyState == 4) {
            if (request.status == 200) {
                var bankAccountNumber = JSON.parse(request.responseText);
document.querySelector("#destination_account_number").value=bankAccountNumber[0].account_number;
            document.querySelector("#destination_account_number_display").value=bankAccountNumber[0].account_number;
                
            }
        }
    }
}
JS;
?>
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Bank Transfer</div>

                <div class="card-body">
                @include('layouts.partials.alerts')
{!! Form::open([
'route'=>'banktransfers.store'
])!!}     
                        @csrf
                   @include('layouts.partials.forms.transactiondate')
                   
                   


<div class="form-group row" id="bank_name_div1">

{!! Form::label('transfer_from','Transfer From:',['class'=>
'col-md-4 col-form-label text-md-right']) !!}
<div class="col-md-6">
{!!Form::select('transfer_from', $bank_list, 0, ['class' => 'form-control'])!!}
</div>
</div>
  <div  style="display:none">     

<div class="form-group row">
{!! Form::label('originating_account_number','Originating Account Number:',['class'=>
'col-md-4 col-form-label text-md-right']) !!}
<div class="col-md-6">
{!! Form::text('originating_account_number',null,['class'=> 'form-control']) !!}
</div>
</div>
               
</div>

<div  style="display:none">     

<div class="form-group row">
{!! Form::label('destination_account_number','Originating Account Number:',['class'=>
'col-md-4 col-form-label text-md-right']) !!}
<div class="col-md-6">
{!! Form::text('destination_account_number',null,['class'=> 'form-control']) !!}
</div>
</div>
               
</div>
               
<div class="form-group row">
    {!! Form::label('originating_account_number_display','Transfer From Account Number:',['class'=>
    'col-md-4 col-form-label text-md-right']) !!}
    <div class="col-md-6">
    {!! Form::text('originating_account_number_display',null,['class'=> 'form-control']) !!}
    </div>
    </div>
    
                 
<div class="form-group row" id="bank_name_div2">

{!! Form::label('transfer_to','Transfer To:',['class'=>
'col-md-4 col-form-label text-md-right']) !!}
<div class="col-md-6">
{!!Form::select('transfer_to', [""=>""], 0, ['class' => 'form-control'])!!}
</div>
</div>

<div class="form-group row">
    {!! Form::label('destination_account_number_display','Transfer To Account Number:',['class'=>
    'col-md-4 col-form-label text-md-right']) !!}
    <div class="col-md-6">
    {!! Form::text('destination_account_number_display',null,['class'=> 'form-control']) !!}
    </div>
    </div>
    
                   
                 
                   
                   
<div class="form-group row">
{!! Form::label('amount','Transfer Amount:',['class'=>
'col-md-4 col-form-label text-md-right']) !!}
<div class="col-md-6">
{!! Form::text('amount',null,['class'=> 'form-control']) !!}
</div>
</div>


               
                   @include('layouts.partials.forms.entryby')
                
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                            {!! Form::submit('Submit',['class'=>'btn btn-primary']) !!}

                            </div>
                        </div>
                        {!! Form::close() !!}
               
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section("scripts")
{!!$js!!}
@endsection