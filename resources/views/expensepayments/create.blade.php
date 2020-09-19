@extends('layouts.app')
<?php
$js=<<<JS

window.onload = function () {
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
    function getSupplierNameAndId() {
        request = createRequest();
        if (request == null) {
        }
        var url = "../getSupplierNameAndId?"
        request.onreadystatechange = populatePaymentToWithSuppliers;
        request.open("GET", url, true);
        request.setRequestHeader("Accept", "text/plain");
        request.setRequestHeader("Content-Type", "text/plain");
        request.responseType = 'text';
        request.send();

    }

    function getCustomerNameAndId() {
        request = createRequest();
        if (request == null) {
        }
        var url = "../getCustomerNameAndId?"
        request.onreadystatechange = populatePaymentToWithCustomers;
        request.open("GET", url, true);
        request.setRequestHeader("Accept", "text/plain");
        request.setRequestHeader("Content-Type", "text/plain");
        request.responseType = 'text';
        request.send();

    }
    function getEmployeeNameAndId() {
        request = createRequest();
        if (request == null) {
        }
        var url = "../getEmployeeNameAndId?"
        request.onreadystatechange = populatePaymentToWithEmployees;
        request.open("GET", url, true);
        request.setRequestHeader("Accept", "text/plain");
        request.setRequestHeader("Content-Type", "text/plain");
        request.responseType = 'text';
        request.send();

    }
    function getGuestNameAndId() {
        request = createRequest();
        if (request == null) {
        }
        var url = "../getGuestNameAndId?"
        request.onreadystatechange = populatePaymentToWithGuests;
        request.open("GET", url, true);
        request.setRequestHeader("Accept", "text/plain");
        request.setRequestHeader("Content-Type", "text/plain");
        request.responseType = 'text';
        request.send();

    }

    function populatePaymentToWithCustomers() {
        if (request.readyState == 4) {
            if (request.status == 200) {
                var customers = JSON.parse(request.responseText);
                paymentto.disabled = false;
                paymentto.options.length=0;      
                paymentto.options[0]=new Option("", "");                          
                for (var i = 0; i < customers.length; i++) {
                    paymentto.options[paymentto.length] =
                            new Option(customers[i].customer_name, customers[i].customer_number);
                }
            }
        }
    }
    function populatePaymentToWithSuppliers() {
        if (request.readyState == 4) {
            if (request.status == 200) {
                var suppliers = JSON.parse(request.responseText);
                paymentto.disabled = false;
                paymentto.options.length=0;  
                paymentto.options[0]=new Option("", "");                              
                for (var i = 0; i < suppliers.length; i++) {
                    paymentto.options[paymentto.length] =
                            new Option(suppliers[i].supplier_name, suppliers[i].supplier_number);
                }
            }
        }
    }

function populatePaymentToWithEmployees() {
        if (request.readyState == 4) {
            if (request.status == 200) {
                var employees = JSON.parse(request.responseText);
                paymentto.disabled = false;
                paymentto.options.length = 0;
                paymentto.options[0]=new Option("", "");
                for (var i = 0; i < employees.length; i++) {
                    paymentto.options[paymentto.length] =
                            new Option(employees[i].employee_name, employees[i].employee_name);
                }
            }
        }
    }
function populatePaymentToWithGuests() {
        if (request.readyState == 4) {
            if (request.status == 200) {
                var guests = JSON.parse(request.responseText);
                paymentto.disabled = false;
                paymentto.options.length = 0;
                paymentto.options[0]=new Option("", "");
                for (var i = 0; i < guests.length; i++) {
                    paymentto.options[paymentto.length] =
                            new Option(guests[i].employee_name, guests[i].employee_name);
                }
            }
        }
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


    paymentto = document.querySelector("#payment_to");
    paymentto.disabled = true;


    if (document.querySelector("#customer_type")) {

        var customertype = document.querySelector("#customer_type");
        customertype.addEventListener('change', function (e) {
            switch (customertype.value) {
                case "customer":
                    getCustomerNameAndId();
                    break;
                case "supplier":
                    getSupplierNameAndId();
                    break;
                         case "employee":
           getEmployeeNameAndId();
            break;
            case "guest":
           getGuestNameAndId();
            break;
                default:
                    paymentto.options.length=0;
                    paymentto.disabled = true;
                    break;

            }

            if (e.target != e.currentTarget) {
                e.preventDefault();
            }
            e.stopPropagation();
        }, false);
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
}

JS;
?>
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Add Expenses Payments</div>

                <div class="card-body">
                @include('layouts.partials.alerts')
{!! Form::open([
'route'=>'expensepayments.store'
])!!}     
                        @csrf
               
                        @include('layouts.partials.forms.transactiondate')
                        @include('layouts.partials.forms.expensecategoryop')
                        @include('layouts.partials.forms.invoicenumber')
                        @include('layouts.partials.forms.amount')
                        @include('layouts.partials.forms.narration')
                        
                        @include('layouts.partials.forms.paymentmodeop')
                        @include('layouts.partials.forms.nameofbankoption')
                        @include('layouts.partials.forms.chequenumber')
                        @include('layouts.partials.forms.customertype')
                        @include('layouts.partials.forms.paymentto')
                        @include('layouts.partials.forms.entryby')
                
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                            {!! Form::submit('Add Expense Payment',['class'=>'btn btn-primary']) !!}

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