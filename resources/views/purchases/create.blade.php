@extends('layouts.app')
<?php
$js=<<<JS


window.onload = function () {
var supplierCurrentBal=0;    
 document.querySelector("#total_shortage").value=getTotalShortage();
      if (document.querySelector("#total_shortage_display")) {
        document.querySelector("#total_shortage_display").value = document.querySelector("#total_shortage").value;
        document.querySelector("#total_shortage_display").disabled = true;
    }


document.querySelector("#hidden").style.display="none";
                document.querySelector("#truck_number_display").disabled=true;
                document.querySelector("#driver_name_display").disabled=true;
  

    if (document.querySelector("#supplier_name_from_inventory")) {

        var supplier = document.querySelector("#supplier_name_from_inventory");
        supplier.addEventListener('change', function (e) {
        document.querySelector("#account_number").value=supplier.value;
        document.querySelector("#supplier_number").value=supplier.value;
            
        document.querySelector("#supplier_name").value=supplier.value;

        getSupplierDetailsFromSupplierNumber(supplier.value);
        setComputedFields();
        document.querySelector("#net_outstanding_balance").value=document.querySelector("#total_outstanding_balance").value;

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


    function getSupplierDetailsFromSupplierNumber(query) {
        request = createRequest();
        if (request == null) {

        }


        var url = "../getSupplierDetailsFromSupplierNumber/" + query+"/";
        request.onreadystatechange = setSupplierDetails;
        request.open("GET", url, true);
        request.setRequestHeader("Accept", "text/plain");
        request.setRequestHeader("Content-Type", "text/plain");
        request.responseType = 'text';
        request.send();

    }

    function setSupplierDetails() {
        if (request.readyState == 4) {
            if (request.status == 200) {
                var supplierDetails = JSON.parse(request.responseText);
                generalDetails = supplierDetails[0];
                document.querySelector("#supplier_name").value=generalDetails.supplier_name;
                document.querySelector("#truck_number").value=generalDetails.truck_number;
                document.querySelector("#truck_number_display").value=generalDetails.truck_number;
                document.querySelector("#driver_name").value=generalDetails.driver_name;
                document.querySelector("#driver_name_display").value=generalDetails.driver_name;                 
                document.querySelector("#litres_loaded").value=generalDetails.litres_loaded;
                
                
                
               litresLoadedop= document.querySelector("#litres_loaded");
                litresLoadedop.options.length=0;      
                litresLoadedop.options[0]=new Option("", "");                          
                for (var i = 0; i < supplierDetails.length; i++) {
                    litresLoadedop.options[litresLoadedop.length] =
                            new Option(supplierDetails[i].litres_loaded, supplierDetails[i].litres_loaded);
                }
            }
        }
    }

    function getSupplierCurrentBalance(query) {
        request = createRequest();
        if (request == null) {

        }


        var url = "../getSupplierCurrentBalance/" + query+"/";
        request.onreadystatechange = setSupplierCurrentBalance;
        request.open("GET", url, true);
        request.setRequestHeader("Accept", "text/plain");
        request.setRequestHeader("Content-Type", "text/plain");
        request.responseType = 'text';
        request.send();

    }
    
    function setSupplierCurrentBalance() {
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
            setNetLoading();
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
            setNetLoading()
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
            setNetLoading();
            if (e.target != e.currentTarget) {
                e.preventDefault();
            }
            e.stopPropagation();
        }, false);
    }

function setNetLoading(){
    var litresLoaded = document.querySelector("#litres_loaded");
    var netLoadingInLitres = document.querySelector("#net_loading_in_litres");
    var shortages = document.querySelector("#shortages_in_litres");
    netLoadingInLitres.value=litresLoaded.value-shortages.value;
}

    function getTotalCostWithNetLoadingInLitres() {
        var netLoadingInLitres = document.querySelector("#net_loading_in_litres").value;
        var pricePerLitre = document.querySelector("#price_per_litre").value;
        return (netLoadingInLitres * pricePerLitre);
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
    if (document.querySelector("#price_per_litre")) {

        var pricePerLitre = document.querySelector("#price_per_litre");
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
     
             var supplier = document.querySelector("#supplier_name_from_inventory");
        getSupplierCurrentBalance(supplier.value);

        var totalCost = document.querySelector("#total_cost");
        totalCost.value = getTotalCostWithNetLoadingInLitres();
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
                <div class="card-header">Add Supplier Payment</div>

                <div class="card-body">
                @include('layouts.partials.alerts')
{!! Form::open([
'route'=>'purchases.store'
])!!}     
                        @csrf
                   @include('layouts.partials.forms.transactiondate')
                   @include('layouts.partials.forms.suppliernameopfrominventory')
                   <div class="form-group row">
{!! Form::label('total_outstanding_balance','Total Outstanding Balance:',['class'=>
'col-md-4 col-form-label text-md-right']) !!}
<div class="col-md-6">
{!! Form::text('total_outstanding_balance',null,['class'=> 'form-control']) !!}
</div>
</div>
                    <div id="supplier_stuff">
                    @include('layouts.partials.forms.trucknumber')
                    @include('layouts.partials.forms.drivername')
                    </div>
                   @include('layouts.partials.forms.producttype')                  

                    @include('layouts.partials.forms.shortagesinlitres')

                    
                   
<div class="form-group row" id="unitPricesDiv">
{!! Form::label('unit_price','Unit Price per Shortage:',['class'=>
'col-md-4 col-form-label text-md-right']) !!}
<div class="col-md-6">
{!! Form::text('unit_price',null,['class'=> 'form-control']) !!}
</div>
</div>
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
  
  
  <div class="form-group row">
{!! Form::label('balance_display','Current Balance Outstanding:',['class'=>
'col-md-4 col-form-label text-md-right']) !!}
<div class="col-md-6">
{!! Form::text('balance_display',null,['class'=> 'form-control']) !!}
</div>
</div>

  
                   @include('layouts.partials.forms.paymentstatus')
                   
                
                    <div id="computed_div">
                    @include('layouts.partials.forms.supplier_name_in')
                                

                    @include('layouts.partials.forms.balance')               
                    </div>
                    <div id="hidden">
                     @include('layouts.partials.forms.litresloadedoption')
                   @include('layouts.partials.forms.netloadinginlitres')                               
                    @include('layouts.partials.forms.priceperlitre')
                    @include('layouts.partials.forms.totalcost')
                   @include('layouts.partials.forms.totalcostdisplay')                       

                             @include('layouts.partials.forms.trucknumberdisplay')
                    @include('layouts.partials.forms.drivernamedisplay')
               
                   @include('layouts.partials.forms.accountnumber')
                   @include('layouts.partials.forms.suppliernumberin')
                   @include('layouts.partials.forms.createdby')
                    </div>
                   <div  style="display:none">     
                    @include('layouts.partials.forms.totalshortage')
                                 
                        {!! Form::text('transaction_code',"Supplier-Payment",['class'=> 'form-control']) !!}                    
                    </div>                        
                        
     
                   
                   
                   

                
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                            {!! Form::submit('Add Supplier Payment',['class'=>'btn btn-primary']) !!}

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