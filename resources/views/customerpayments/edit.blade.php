@extends('layouts.app')
<?php
$js=<<<JS


window.onload = function () {

var arrayOfElements = [
  
    "customer_name"
   

];
document.querySelector("#total_shortage").value=getTotalShortage();
      if (document.querySelector("#total_shortage_display")) {
        document.querySelector("#total_shortage_display").value = document.querySelector("#total_shortage").value;
        document.querySelector("#total_shortage_display").disabled = true;
    }


function getIdFromCustomerName(query) {
    request = createRequest();
    if (request == null) {

    }


    var url = "../getCustomerIdFromName/" + query + "/"
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
            document.querySelector("#account_number").value= id.customer_number;
            cusnumdisp.value = customeracc.value;
            var customer = document.querySelector("#customer_number");
            getCustomerCurrentBalance(customer.value);


        }
    }
}

var customername = document.querySelector('#customer_name');
var customeraccdiv = document.querySelector('#customerNumberDiv');
var customeracc = document.querySelector('#customer_number');
customeraccdiv.style.display = "none"

var cusnumdisp = document.querySelector("#customer_number_display");
cusnumdisp.disabled = true;
cusnumdisp.value = customeracc.value;

customername.addEventListener('change', function (e) {
    getIdFromCustomerName(this.value);
   
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
function initaliseElements(arrayOfElements)
{
    var arrElmDisplay = "#" + arrayOfElements[0] + "_display";
    for (i = 0; i < arrayOfElements; i++) {
        var arrElmDisplay = "#" + arrayOfElements[i] + "_display";
        var arrElm = "#" + arrayOfElements[i];
        if (document.querySelector(arrayElm)) {
            document.querySelector(arrElmDisplay).value = document.querySelector(arrElm).value;
        }
    }
}
initaliseElements(arrayOfElements);

var customerCurrentBal=0;    
 document.querySelector("#total_shortage").value=getTotalShortage();
      if (document.querySelector("#total_shortage_display")) {
        document.querySelector("#total_shortage_display").value = document.querySelector("#total_shortage").value;
        document.querySelector("#total_shortage_display").disabled = true;
    }


document.querySelector("#hidden").style.display="none";
      

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


    


    function getCustomerCurrentBalance(query) {
        request = createRequest();
        if (request == null) {

        }


        var url = "../getCustomerCurrentBalance/" + query+"/";
        request.onreadystatechange = setCustomerCurrentBalance;
        request.open("GET", url, true);
        request.setRequestHeader("Accept", "text/plain");
        request.setRequestHeader("Content-Type", "text/plain");
        request.responseType = 'text';
        request.send();

    }
    
    function setCustomerCurrentBalance() {
        if (request.readyState == 4) {
            if (request.status == 200) {
                var sDetails = JSON.parse(request.responseText);
           
               if(sDetails){
               document.querySelector("#total_outstanding_balance").value=sDetails.balance;
           }else{
              document.querySelector("#total_outstanding_balance").value=0;
           }
        
            }
        }
    }



    document.querySelector("#computed_div").style.display = "none";


    if (document.querySelector("#supplier_stuff")) {
        document.querySelector("#supplier_stuff").style.display="none";
     }

   
    if (document.querySelector("#total_cost_display")) {
        document.querySelector("#total_cost_display").value = document.querySelector("#total_cost").value;
        document.querySelector("#total_cost_display").disabled = true;
    }


    if (document.querySelector("#balance_display")) {
        document.querySelector("#balance_display").value = document.querySelector("#balance").value;
        document.querySelector("#balance_display").disabled = true;
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



if (document.querySelector("#unit_price")) {

        var unitprices = document.querySelector("#unit_price");
        unitprices.addEventListener('change', function (e) {

            setComputedFields();
            if (e.target != e.currentTarget) {
                e.preventDefault();
            }
            e.stopPropagation();
        }, false);
    }

    if (document.querySelector("#litres_loaded")) {

        var litresLoaded = document.querySelector("#litres_loaded");
        litresLoaded.addEventListener('change', function (e) {
    
            setComputedFields();
            if (e.target != e.currentTarget) {
                e.preventDefault();
            }
            e.stopPropagation();
        }, false);
    }
    if (document.querySelector("#shortages_in_litres")) {

        var shortages = document.querySelector("#shortages_in_litres");
        shortages.addEventListener('change', function (e) {

            setComputedFields();
            if (e.target != e.currentTarget) {
                e.preventDefault();
            }
            e.stopPropagation();
        }, false);
    }


    function getTotalCost() {
    var litresLoaded = document.querySelector("#litres_loaded").value;     
        var pricePerLitre = document.querySelector("#unit_price").value;
        return (litresLoaded * pricePerLitre);
    }

    if (document.querySelector("#net_loading_in_litres")) {

        var netLoadingInLitres = document.querySelector("#net_loading_in_litres");
        netLoadingInLitres.addEventListener('change', function (e) {
            if (e.target != e.currentTarget) {
                e.preventDefault();
            }
            e.stopPropagation();
        }, false);
    }
    if (document.querySelector("#unit_price")) {

        var pricePerLitre = document.querySelector("#unit_price");
        pricePerLitre.addEventListener('change', function (e) {

            setComputedFields();
            if (e.target != e.currentTarget) {
                e.preventDefault();
            }
            e.stopPropagation();
        }, false);
    }

    function getBalance() {
   var netOutstandingBalance= document.querySelector("#net_outstanding_balance").value;        
        var totalCost = document.querySelector("#total_cost").value;
        var amountPaid = document.querySelector("#amount_paid").value;
        return (netOutstandingBalance - amountPaid);
    }
   
    if (document.querySelector("#amount_paid")) {

        var amountPaid = document.querySelector("#amount_paid");
        amountPaid.addEventListener('change', function (e) {

            setComputedFields();
            if (e.target != e.currentTarget) {
                e.preventDefault();
            }
            e.stopPropagation();
        }, false);
    }
    if (document.querySelector("#total_cost")) {

        var totalCost = document.querySelector("#total_cost");
        totalCost.addEventListener('change', function (e) {

            setComputedFields();
            if (e.target != e.currentTarget) {
                e.preventDefault();
            }
            e.stopPropagation();
        }, false);
    }
    function setComputedFields() {
     
             var customer = document.querySelector("#customer_number");
        getCustomerCurrentBalance(customer.value);

        var totalCost = document.querySelector("#total_cost");
        totalCost.value = getTotalCost();
        document.querySelector("#total_cost_display").value = totalCost.value;

        var balance = document.querySelector("#balance");
        balance.value = getBalance();
        var newBal=document.querySelector("#net_outstanding_balance").value-document.querySelector("amount_paid");
        document.querySelector("#balance_display").value = balance.value;

        document.querySelector("#total_shortage").value=getTotalShortage();
        document.querySelector("#total_shortage_display").value = document.querySelector("#total_shortage").value;
    
        document.querySelector("#net_outstanding_balance").value=document.querySelector("#total_outstanding_balance").value-document.querySelector("#total_shortage").value;

    }
    function getTotalShortage(){
        return  document.querySelector("#shortages_in_litres").value * document.querySelector("#unit_price").value;
      
    }
}
  


JS;
?>


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Edit Customer Payment</div>

                <div class="card-body">
                @include('layouts.partials.alerts')
                {!! Form::model($customerPayments, [
    'method' => 'PATCH',
    'route' => ['customerpayments.update', $customerPayments->id]
]) !!}

              @csrf
                   @include('layouts.partials.forms.transactiondate')
                   @include('layouts.partials.forms.customernameop')
                  <div class="form-group row">
{!! Form::label('total_outstanding_balance','Total Outstanding Balance:',['class'=>
'col-md-4 col-form-label text-md-right']) !!}
<div class="col-md-6">
{!! Form::text('total_outstanding_balance',null,['class'=> 'form-control']) !!}
</div>
</div>
                 
                   <div id="supplier_stuff">
                    </div>
                    @include('layouts.partials.forms.producttype')                  
                    @include('layouts.partials.forms.shortagesinlitres')
                    @include('layouts.partials.forms.unitprices')
                    @include('layouts.partials.forms.totalshortagedisplay')
<div class="form-group row">
{!! Form::label('net_outstanding_balance','Net Outstanding Balance:',['class'=>
'col-md-4 col-form-label text-md-right']) !!}
<div class="col-md-6">
{!! Form::text('net_outstanding_balance',null,['class'=> 'form-control']) !!}
</div>
</div>
@include('layouts.partials.forms.amountpaid')
                   @include('layouts.partials.forms.paymentmodeop')
                   @include('layouts.partials.forms.nameofbankoption')
                   @include('layouts.partials.forms.chequenumber')
                   @include('layouts.partials.forms.narration')
                   @include('layouts.partials.forms.balancedisplay')
                   @include('layouts.partials.forms.paymentstatus')

                    <div id="computed_div">
                    </div>
                    <div id="hidden">
                           @include('layouts.partials.forms.litresloaded')
                   @include('layouts.partials.forms.totalcostdisplay')                       
                 
                          @include('layouts.partials.forms.customeraccountdisabled')
                   @include('layouts.partials.forms.customernumberdisplay')

                    @include('layouts.partials.forms.totalcost')
                    @include('layouts.partials.forms.balance')               
                   @include('layouts.partials.forms.accountnumber')
                   @include('layouts.partials.forms.createdby')
                    </div>
                   <div  style="display:none">     
                    @include('layouts.partials.forms.totalshortage')
                                 
                        {!! Form::text('transaction_code',"Customer-Payment",['class'=> 'form-control']) !!}                    
                    </div>                        
                        
     
                   
                   
                   

                
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                            {!! Form::submit('Edit Customer Payment',['class'=>'btn btn-primary']) !!}

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
{{!!$js!!}}
@endsection