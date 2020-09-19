@extends('layouts.app')
<?php
$salesrates=\App\SalesRate::all()->toJson();
//$customers=\App\Customer::all()->toJson();
$customers="";
$getSumOfSupplierProducts=url("getSumOfSupplierProducts");
$a=<<<JS
window.onload = function () {
    document.querySelector("#supplier_name_from_inventory").disabled=true;
    if (document.querySelector("#supplierProduct")) {
        var sproduct = document.querySelector("#supplierProduct");
        sproduct.style.visibility = "hidden";
    }

    document.querySelector("#shortages").value = 0;

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

    var arrayOfElements = [
        "total_cost",
        "unit_price",
        "supplier_name",
        "shortages",
        "product_type",
        "customer_name",
        "balance",
        "litres_pumped"

    ];

    function getSumOfSupplierProducts(query) {
        request1 = createRequest();
        if (request1 == null) {

        }

        var url = "/getSumOfSupplierProducts/" + query + "/";
        request1.onreadystatechange = setAvailableProductFromSupplierTable;
        request1.open("GET", url, true);
        request1.setRequestHeader("Accept", "text/plain");
        request1.setRequestHeader("Content-Type", "text/plain");
        request1.responseType = 'text';
        request1.send();

    }

    function setAvailableProductFromSupplierTable() {

        if (request1.readyState == 4) {
            if (request1.status == 200) {
                var data = JSON.parse(request1.responseText);
                var table = document.querySelector("#supplierTable");
                old_body = table.children[1];
                var new_tbody = document.createElement('tbody');


                var sproduct = document.querySelector("#supplierProduct");
                sproduct.style.visibility = "visible";


                if (document.querySelector("#suppilerProductHeading")) {
                    if (data[0][0]) {
                        document.querySelector("#suppilerProductHeading").innerHTML = data[0][0].supplier_name + "'s Stock";
                    }
                }
                for (let i = 0; i < data.length; i++) {
                    for (let j = 0; j < data[i].length; j++) {
                        var tr = document.createElement('tr');
                        var td = document.createElement('td');
                        var td2 = document.createElement('td');
                        td.innerHTML = data[i][j].product_type;
                        td2.innerHTML = data[i][j].litres_loaded;
                        tr.appendChild(td);
                        tr.appendChild(td2);
                        new_tbody.appendChild(tr)
                    }
                }
                old_body.parentNode.replaceChild(new_tbody, old_body)

                var product_type_exists = false;
                var producttype = document.querySelector("#product_type");
                var litresPumped = document.querySelector("#litres_pumped").value;
                for (let i = 0; i < data.length; i++) {
                    for (let j = 0; j < data[i].length; j++) {
                        litresL = Number(data[i][j].litres_loaded);
                        if (data[i][j].product_type == producttype.value) {
                            product_type_exists = true;
                            if (litresPumped > litresL) {
                                alert("Supplier does not have enough stock");
                                document.querySelector("#litres_pumped").value = "Error: Supplier does not have enough stock";
                            }
                        }


                    }
                }
                if (product_type_exists === false) {
                    alert("Supplier does not have " + producttype.value);
                    document.querySelector("#supplier_name_from_inventory").value = "";

                    producttype.value = "";
                }
            }
        }
    }

    function disableDisplayElements(arrayOfElements) {

        for (i = 0; i < arrayOfElements; i++) {
            var arrElm = "#" + arrayOfElements[i] + "_display";
            if (document.querySelector(arrayElm)) {
                document.querySelector(arrayElm).disabled = true;
            }
        }
    }

    function initaliseElements(arrayOfElements) {
        var arrElmDisplay = "#" + arrayOfElements[0] + "_display";
        for (i = 0; i < arrayOfElements; i++) {
            var arrElmDisplay = "#" + arrayOfElements[i] + "_display";
            var arrElm = "#" + arrayOfElements[i];
            if (document.querySelector(arrayElm)) {
                document.querySelector(arrElmDisplay).value = document.querySelector(arrElm).value;
            }
        }
    }
    disableDisplayElements(arrayOfElements);
    initaliseElements(arrayOfElements);

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
                cusnumdisp.value = customeracc.value;

            }
        }
    }

    function getSupplierNameByProductType(query) {
        xmlhttp = new XMLHttpRequest();
        var url = "/getSupplierNameByProductType/" + query + "/";
        xmlhttp.open('GET', url, true);
        xmlhttp.onreadystatechange = setSupplierNamesAndNumbers;
        xmlhttp.send(null);

    }

    function setSupplierNamesAndNumbers() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            var select = document.getElementById("supplier_name_from_inventory");
            select.length = 0;
                           select.options[select.length] =
                    new Option("","");
 
            var supplierNamesAndNums = JSON.parse(xmlhttp.responseText);
            for (var i = 0; i < supplierNamesAndNums.length; i++) {
                select.options[select.length] =
                    new Option(supplierNamesAndNums[i].supplier_name, supplierNamesAndNums[i].supplier_number);
            }


        } else if (xmlhttp.readyState == 4 && xmlhttp.status != 200) {
            var select2 = document.getElementById("supplier_name_from_inventory");
            select2.length = 0;
            select2.options[0] = new Option('Product not in inventory', '');

        }
    }


    var cusnum = 0;
    var salesrates = $salesrates;

    document.querySelector("#stageReachedDiv").style.display = "none";
    if (document.querySelector("#outPutManagerSalesDiv")) {
        document.querySelector("#outPutManagerSalesDiv").style.display = "none";
        document.querySelector("#stage_reached").value = "complete";
    } else {
        document.querySelector("#stage_reached").value = "waiting_for_accountant";
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

    if (document.querySelector("#supplier_name_from_inventory")) {

        var supplier = document.querySelector("#supplier_name_from_inventory");
        supplier.addEventListener('change', function (e) {
          setUpSupplierTable()
            if (e.target != e.currentTarget) {
                e.preventDefault();
            }
            e.stopPropagation();
        }, false);
    }
    function setUpSupplierTable(){
          document.querySelector("#supplier_name").value = supplier.value;
            getSumOfSupplierProducts(supplier.value);
            getSupplierDetailsFromSupplierNumber(supplier.value);
          
    }
    var customername = document.querySelector('#customer_name');
    var customeraccdiv = document.querySelector('#customerNumberDiv');
    var customeracc = document.querySelector('#customer_number');
    customeraccdiv.style.display = "none"

    var cusnumdisp = document.querySelector("#customer_number_display");
    cusnumdisp.disabled = true;
    cusnumdisp.value = customeracc.value;

    var producttype = document.querySelector("#product_type");

    var unitprice = document.querySelector("#unit_price");
    var unitpricedisp = document.querySelector("#unit_price_display");
    unitpricedisp.disabled = true;
    var unitPricesDiv = document.querySelector("#unitPricesDiv");
    unitPricesDiv.style.display = "none"

    if (document.querySelector("#discount_rate")) {

        var discountrate = document.querySelector("#discount_rate");
        discountrate.addEventListener('change', function (e) {

            var totalCost = document.querySelector("#total_cost");
            totalCost.value = getTotalCost();
            document.querySelector("#total_cost_display").value =parseInt( totalCost.value);
            if (e.target != e.currentTarget) {
                e.preventDefault();
            }
            e.stopPropagation();
        }, false);
    }

    if (document.querySelector("#amount_paid")) {

        var amountpaid = document.querySelector("#amount_paid");
        var balance = document.querySelector("#balance");
        amountpaid.addEventListener('change', function (e) {
            balance.value = document.querySelector("#total_cost").value - amountpaid.value;


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
    }, false);
    producttype.addEventListener('change', function (e) {
        if(producttype.value==""|| producttype.value==" "){
            document.querySelector("#supplier_name_from_inventory").length=0;
            document.querySelector("#supplier_name_from_inventory").disabled=true;

        }else{
            document.querySelector("#supplier_name_from_inventory").disabled=false;
        }
        setUpSupplierTable();
        var result = "Sales rate not set";
        for (let i = 0; i < salesrates.length; i++) {
            if (salesrates[i].product_type == producttype.value) {
                result = salesrates[i].selling_rate;
            }
        }
        unitprice.value = result;
        unitpricedisp.value = result;
        getSupplierNameByProductType(producttype.value);
        if (e.target != e.currentTarget) {
            e.preventDefault();
        }
        e.stopPropagation();
    }, false);

    function getSupplierDetailsFromSupplierNumber(query) {
        request = createRequest();
        if (request == null) {

        }

        var url = "../getSupplierDetailsFromSupplierNumber/" + query + "/";
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
                var id = JSON.parse(request.responseText);
                id = id[0];
                document.querySelector("#supplier_name").value = id.supplier_name;
            }
        }
    }


    function getTotalCost() {
        var litresPumped = document.querySelector("#litres_pumped").value;
        var unitPrice = document.querySelector("#unit_price").value;
        var discountRate = document.querySelector("#discount_rate").value;
        if (discountRate != 0) {
            var x = (discountRate * litresPumped);
        }
        var cashDiscountAllowed = document.querySelector("#cash_discount_allowed").value;
        return (litresPumped * unitPrice) - x - cashDiscountAllowed;

    }

};

JS;
    ?>
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Start Sale</div>

                <div class="card-body">
                @include('layouts.partials.alerts')
{!! Form::open([
'route'=>'outputmanagersales.store'
])!!}
@csrf
                  
@include('layouts.partials.forms.salesdate')
@include('layouts.partials.forms.customernameop')

@include('layouts.partials.forms.customeraccountdisabled')
@include('layouts.partials.forms.customernumberdisplay')

@include('layouts.partials.forms.litrespumped')
@include('layouts.partials.forms.producttypetoday')  
@include('layouts.partials.forms.suppliernameopfrominventory')
<div id="supplier_name_div"  style="display:none">
@include('layouts.partials.forms.shortages')       
@include('layouts.partials.forms.supplier_name_in')
@include('layouts.partials.forms.unitprices') 
</div>
 
@include('layouts.partials.forms.unitpricesdisplay')  

@include('layouts.partials.forms.stagereachedoutputmanager')  
            

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                            {!! Form::submit('Start Sale',['class'=>'btn btn-primary']) !!}

                            </div>
                        </div>
                        {!! Form::close() !!}
               
                </div>
            </div>
            
        </div>
        <?php
       $sumvals=array();
$bank_list = \App\TotalLitres::pluck( 'product_type',"product_type");
        foreach ($bank_list as $key => $value) {
            $sumvals[$key]= DB::table('total_litres')->where('product_type', $key)->sum('total_litres');
        }
 
/*
$sumVals=array();
$totalLitresDetails=\App\TotalLitres::all();
  $sumvals=$totalLitresDetails;
*/
  //  dd($sumvals);
     
//       $a= \App\Inventory::groupBy('product_type')->get()->avg("litres_loaded");
       //dd($bank_list);
       ?>
        <div class="col-md-2">
                <table class="table table-striped table-borded">
                        <thead>
                            <tr>
                                <th>Product Type</th>
                                <th>Available Litres</th>
                            </tr>
                            <tbody>
                                    @foreach($sumvals as $key => $value)
                                <tr>
                                    
                                    <td>{{$key}}</td>
                                    <td>{{number_format($value,2)}}</td>
                                </tr>
                                @endforeach     </tbody>
                        </thead>
                        </table>
        <div id="supplierProduct">
      
            <h3 id="suppilerProductHeading"></h3>
                <table class="table table-striped table-borded" id="supplierTable">
                        <thead>
                            <tr>
                                <th>Product Type</th>
                                <th>Available Litres</th>
                            </tr>
                            <tbody>
                                <tr>
                                 
                                </tr>
                            </tbody>
                        </thead>
                        </table>
        </div>
                        
        </div>
        <div class="col-md-2">   
    <product-sales-from-total-litres></product-sales-from-total-litres>    
</div>
</div>
@endsection
@section("scripts")
{{!!$a!!}} 
@endsection