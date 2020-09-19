

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


    function getIdFromCustomerName(query) {
        request = createRequest();
        if (request == null) {

        }


        var url = "/getIdFromCustomerName/" + query + "/"
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



    var cusnum = 0;
    var salesrates = $salesrates;
    // var customers = $customers;


    document.querySelector("#stageReachedDiv").style.display = "none";
    if (document.querySelector("#total_cost_display")) {
        document.querySelector("#total_cost_display").value = document.querySelector("#total_cost").value;
        document.querySelector("#total_cost_display").disabled = true;
    }

    if (document.querySelector("#unit_price_display")) {
        document.querySelector("#unit_price_display").value = document.querySelector("#unit_price").value;
        document.querySelector("#unit_price_display").disabled = true;
    }

    if (document.querySelector("#supplier_name_display")) {
        document.querySelector("#supplier_name_display").value = document.querySelector("#supplier_name").value;
        document.querySelector("#supplier_name_display").disabled = true;
    }


    if (document.querySelector("#shortages_display")) {
        document.querySelector("#shortages_display").value = document.querySelector("#shortages").value;
        document.querySelector("#shortages_display").disabled = true;
    }

    if (document.querySelector("#product_type_display")) {
        document.querySelector("#product_type_display").value = document.querySelector("#product_type").value;
        document.querySelector("#product_type_display").disabled = true;
    }


    if (document.querySelector("#customer_name_display")) {
        document.querySelector("#customer_name_display").value = document.querySelector("#customer_name").value;
        document.querySelector("#customer_name_display").disabled = true;
    }

    if (document.querySelector("#litres_pumped_display")) {
        document.querySelector("#litres_pumped_display").value = document.querySelector("#litres_pumped").value;
        document.querySelector("#litres_pumped_display").disabled = true;
    }


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
            document.querySelector("#total_cost_display").value = totalCost.value;
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
            balance.value = amountpaid.value - document.querySelector("#total_cost").value;


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
                    bankname.style.visibility = "hidden";

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
        /*
         for (let i = 0; i < customers.length; i++) {
         if (customers[i].customer_name == customername.value) {
         customeracc.value = customers[i].customer_number;
         cusnumdisp.value=customers[i].customer_number;
         cusnum = customers[i].customer_number;
         }
         }
         */
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
    producttype.addEventListener('change', function (e) {
        var result = "Sales rate not set";
        for (let i = 0; i < salesrates.length; i++) {
            if (salesrates[i].product_type == producttype.value) {
                result = salesrates[i].selling_rate;
            }
        }
        unitprice.value = result;
        unitpricedisp.value = result;
        if (e.target != e.currentTarget) {
            e.preventDefault();
        }
        e.stopPropagation();
    }, false);
};
function getTotalCost() {
    var litresPumped = document.querySelector("#litres_pumped").value;
    var unitPrice = document.querySelector("#unit_price").value;
    var discountRate = document.querySelector("#discount_rate").value;
    var cashDiscountAllowed = document.querySelector("#cash_discount_allowed").value;
    return (litresPumped * unitPrice) - (discountRate * litresPumped);
}

