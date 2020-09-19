@extends('layouts.app')
<?php
$js=<<<JS
window.onload = function () {
var ts=document.querySelector("#transCode");
ts.style.display="none"
document.querySelector("#transaction_code").value="Withdrawal";

  document.querySelector("#account_number_display").disabled=true;
            

 if (document.querySelector("#bank_name")) {

        var bn = document.querySelector("#bank_name");
        bn.addEventListener('change', function (e) {

            getAccountNumberFromBankName(bn.value);
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


    function getAccountNumberFromBankName(query) {
        request = createRequest();
        if (request == null) {

        }


        var url = "../getAccountNumberFromBankName/" + query+"/";
        request.onreadystatechange = setAccountNumberFromBankName;
        request.open("GET", url, true);
        request.setRequestHeader("Accept", "text/plain");
        request.setRequestHeader("Content-Type", "text/plain");
        request.responseType = 'text';
        request.send();

    }

    function setAccountNumberFromBankName() {
        if (request.readyState == 4) {
            if (request.status == 200) {
                var bankAccountNumber = JSON.parse(request.responseText);
document.querySelector("#account_number").value=bankAccountNumber[0].account_number;
            document.querySelector("#account_number_display").value=bankAccountNumber[0].account_number;
                
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
                <div class="card-header">Add Withdrawal</div>

                <div class="card-body">
                @include('layouts.partials.alerts')
{!! Form::open([
'route'=>'withdrawals.store'
])!!}     
                        @csrf
                   @include('layouts.partials.forms.transactiondate')
                   @include('layouts.partials.forms.nameofbankoption') 
                 
                    <div  style="display:none">     
                   @include('layouts.partials.forms.accountnumber')
                   </div>
                   @include('layouts.partials.forms.accountnumberdisplay')
                  
                   <div id="transCode">
                    @include('layouts.partials.forms.transcode')
                   </div>
                   @include('layouts.partials.forms.amount')
                   @include('layouts.partials.forms.narration')
                   @include('layouts.partials.forms.entryby')
                
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                            {!! Form::submit('Add Withdrawal',['class'=>'btn btn-primary']) !!}

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