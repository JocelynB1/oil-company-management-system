@extends('layouts.app')

<?php
$js=<<<_
document.querySelector("#hidden").style.display="none";
var ts=document.querySelector("#transCode");
ts.style.display="none"
document.querySelector("#transaction_code").value="Refund";

var customername = document.querySelector('#customer_name');
var customeraccdiv = document.querySelector('#customerNumberDiv');
var customeracc = document.querySelector('#customer_number');
var accnum=document.querySelector('#account_number');
customeraccdiv.style.display = "none"
var cusnumdisp = document.querySelector("#customer_number_display");
    cusnumdisp.disabled = true;
    cusnumdisp.value = customeracc.value;

function getCustomerIdFromName(query) {
        request = createRequest();
        if (request == null) {

        }


        var url =  "../getCustomerIdFromName/" + query + "/"
        request.onreadystatechange = setCustomerAccountNumber;
        request.open("GET", url, true);
        request.setRequestHeader("Accept", "text/plain");
        request.setRequestHeader("Content-Type", "text/plain");
        request.responseType = 'text';
        request.send();

    }

    function setCustomerAccountNumber() {
        if (request.readyState == 4) {
            if (request.status == 200) {
                var id = JSON.parse(request.responseText);
                id = id[0];
                customeracc.value = id.customer_number;
                cusnumdisp.value = customeracc.value;
                accnum.value=id.customer_number;

            }
        }
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


if (document.querySelector("#bank_name_div")) {
        var bankname = document.querySelector("#bank_name_div");
        bankname.style.visibility = "hidden";
        bankname.selected = "NULL";
    }
    if (document.querySelector("#cheque_number_div")) {
        var cheque = document.querySelector("#cheque_number_div");
        cheque.style.visibility = "hidden";
    }

if (document.querySelector("#payment_mode")) {

var paymentmode = document.querySelector("#payment_mode");
paymentmode.addEventListener('change', function (e) {

    switch (paymentmode.value) {
        case "Transfer":
            bankname.style.visibility = "visible";
            cheque.style.visibility = "hidden";

            break;
        case "Bank":
            bankname.style.visibility = "visible";
            cheque.style.visibility = "hidden";

            break;
        case "Cheque":
            cheque.style.visibility = "visible";
            bankname.style.visibility = "visible";

            break;
        default:
            bankname.style.visibility = "hidden";
            cheque.style.visibility = "hidden";
            document.querySelector("#cheque_number").value = "";
            bankname.value = "NULL";

    }


    if (e.target != e.currentTarget) {
        e.preventDefault();
    }
    e.stopPropagation();
}, false);
}

customername.addEventListener('change', function (e) {
    getCustomerIdFromName(this.value);
    cusnumdisp.value = customeracc.value;
    if (e.target != e.currentTarget) {
        e.preventDefault();
    }
    e.stopPropagation();
}, false);
customeracc.addEventListener('change', function (e) {

    customeracc.value = cusnum;
    if (e.target != e.currentTarget) {
        e.preventDefault();
    }
    e.stopPropagation();
}
, false);
_;

?>
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Add Refund</div>

                <div class="card-body">
                @include('layouts.partials.alerts')
{!! Form::open([
'route'=>'refunds.store'
])!!}     
                        @csrf
                        
                   @include('layouts.partials.forms.transactiondate')
               
                   @include('layouts.partials.forms.customernameop')

                   @include('layouts.partials.forms.customeraccountdisabled')
                   @include('layouts.partials.forms.customernumberdisplay')
                  <div id="hidden">
                   @include('layouts.partials.forms.accountnumber')
                  </div>
                   
                   @include('layouts.partials.forms.refundamount')
                   @include('layouts.partials.forms.paymentmodeop')
                   @include('layouts.partials.forms.chequenumber')  
                   @include('layouts.partials.forms.nameofbankoption')
                   @include('layouts.partials.forms.entryby')
             
                   <div id="transCode">
                    @include('layouts.partials.forms.transcode')
                   </div>
                 
                   @include('layouts.partials.forms.approvalstatuswithdefault')
               
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                            {!! Form::submit('Add Refund',['class'=>'btn btn-primary']) !!}

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