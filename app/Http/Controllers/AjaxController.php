<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AjaxController extends Controller
{
    private function getRandomColors()
    {
        $hash = '#';
        $head = array("9", "A", "B", "C", "D", "E", "F");
        for ($i = 0; $i < 6; $i++) {
            $hash .= $head[array_rand($head, 1)];
        }

        return substr($hash, 0, 7);
    }

    public function getSalesRate()
    {
        $supplierId = \App\SalesRate::where('product_type', '=', $request->product_type)->get();
        $salesrates = \App\SalesRate::all()->toJson();
        $customers = \App\Customer::all()->toJson();
    }

    public function getCustomerIdFromName($name)
    {
        //$bankaccount = \App\Customer::findOrFail($name);

        $resultRows = \DB::table('customers')
            ->where('customer_name', '=', $name)
            ->get(["customer_number"]);
        return response()->json($resultRows);
    }
    public function getDailySalesRecord()
    {
        $transactionDates = \DB::table('transactions')
            ->select('transaction_date')
            ->distinct()
            ->orderBy('transaction_date', 'asc')->get();
        $resultRows = [];
        for ($i = 0; $i < count($transactionDates); $i++) {
            $resultRows[$transactionDates[$i]->transaction_date] = \DB::table('transactions')
                ->where('transaction_date', '=', $transactionDates[$i]->transaction_date)
                ->get();
        }

        return response()->json($resultRows);
    }

    public function getCustomerNameAndId()
    {
        $resultRows = \DB::table('customers')
            ->get(["customer_name", "customer_number"]);
        return response()->json($resultRows);
    }
    public function getSupplierDetailsFromSupplierNumber($supplierNumber)
    {
        $resultRows = \DB::table('inventories')
            ->where('supplier_number', '=', $supplierNumber)
            ->where('litres_loaded', '>', 0)
            ->get([
                "supplier_name",
                "truck_number",
                "driver_name",
                "litres_loaded"
            ]);
        return response()->json($resultRows);
    }
    public function getSupplierNameAndId()
    {
        $resultRows = \DB::table('suppliers')
            ->get(["supplier_name", "supplier_number"]);
        return response()->json($resultRows);
    }
    public function getEmployeeNameAndId()
    {
        $resultRows = \DB::table('workers')
        ->where("type", "=", "staff")
            ->get(["employee_name"]);
        return response()->json($resultRows);
    }
    public function getGuestNameAndId()
    {
        $resultRows = \DB::table('workers')
            ->where("type", "=", "nonStaff")
            ->get(["employee_name"]);
        return response()->json($resultRows);
    }
    public function getOutstandingInventory()
    {
        //bar chart
        $resultRows = array();
        $bank_list = \App\Sale::pluck('product_type', "product_type");
        foreach ($bank_list as $key => $value) {
            $resultRows[$key] = \DB::table('sales')
                ->where('stage_reached', '=', 'waiting_for_accountant')
                ->where('product_type', $key)->sum('litres_pumped');
        }
        $newResultRows = array();
        $resultLength = count($resultRows) - 2;
        $i = 0;
        foreach ($resultRows as $key => $value) {
            $newResultRows[$i] = ["product_type" => $key, "litres_pumped" => $value, "color" => $this->getRandomColors()];
            $i++;
        }

        return response()->json($newResultRows);
    }

    public function getProductSalesPerDate()
    {
        //pie chart
        $salesDates = \DB::table('sales')
            ->select('sales_date')
            ->distinct()
            ->orderBy('sales_date', 'asc')->get();
        // $salesDates=array();


        $products = \DB::table('sales')->select('product_type')->distinct()->get();


        $productsLength = count($products);
        $salesDatesLength = count($salesDates);

        for ($j = 0; $j < $productsLength; $j++) {
            $resultRows = [];

            for ($i = 0; $i < $salesDatesLength; $i++) {
                $productSumPerDate = \DB::table('sales')
                    ->where("sales_date", "=", $salesDates[$i]->sales_date)
                    ->where("product_type", "=", $products[$j]->product_type)
                    ->sum("litres_pumped");
                $resultRows[] = [
                    "product_type" => $products[$j]->product_type,
                    "sales_date" => $salesDates[$i]->sales_date,
                    "litres_pumped" => $productSumPerDate,
                    "color" => $this->getRandomColors()
                ];
            }
            $newResultRows[] = $resultRows;
        }

        // $a=\App\Sale::all()->orderBy("sales_date","asc")->get();
        //$b=$a->orderBy("sales_date");
        // ->map(function ($row) {
        //   return $row->sum('litres_pumped');
        //});
        //   $resultRows=array();
        /*
          $bank_list = \App\Sale::pluck( 'product_type',"product_type");
          foreach ($bank_list as $key => $value) {
              $resultRows[$key]= \DB::table('sales')
              ->where('product_type', $key)
              ->groupBy("sales_date")
              ->sum('litres_pumped')->get();

          }
          $newResultRows=array();
          $resultLength=count($resultRows)-2;
          $i=0;
          foreach ($resultRows as $key => $value) {

          $newResultRows[$i]=["product_type"=>$key,"litres_pumped"=>$value,"color"=>$this->getRandomColors()];
            $i++;
    }
           */
        return response()->json($newResultRows);
    }
    public function getSumOfSupplierProducts($suppplier)
    {
        //pie chart
        $supplier = "";
        $suppliers = \DB::table('inventories')
            ->select('supplier_name')
            ->distinct()
            ->get();

        $products = \DB::table('inventories')->select('product_type')->distinct()->get();
        $productsLength = count($products);

        $resultRows1 = \DB::table('inventories')->where('supplier_number', $suppplier)->get()->toArray();
        $supplierName = $resultRows1[0]->supplier_name;
        //->sum('litres_loaded');


        $resultRows = [];

        for ($i = 0; $i < $productsLength; $i++) {
            $productSum = \DB::table('inventories')
                ->where("supplier_number", "=", $suppplier)
                ->where("product_type", "=", $products[$i]->product_type)
                ->sum("litres_loaded");
            $resultRows[] = [
                "product_type" => $products[$i]->product_type,
                "supplier_name" => $supplierName,
                "litres_loaded" => $productSum

            ];
        }
        $newResultRows[] = $resultRows;
  


            
        //              $resultRows=array();
        //     $bank_list = \App\TotalLitres::pluck( 'product_type',"product_type");
        //     foreach ($bank_list as $key => $value) {
        //         $resultRows[$key]= \DB::table('total_litres')->where('product_type', $key)->sum('total_litres');
            
        //     }
        //     $newResultRows=array();
        //     $resultLength=count($resultRows)-2;
        //     $i=0;
        //     foreach ($resultRows as $key => $value) {
        //      $newResultRows[$i]=["product_type"=>$key,"total_litres"=>$value,"color"=>$this->getRandomColors()];
        //       $i++;
        // }

        return response()->json($newResultRows);
    }
    public function getProductSalesFromTotalLitres()
    {
        //pie chart

        $resultRows = array();
        $bank_list = \App\TotalLitres::pluck('product_type', "product_type");
        foreach ($bank_list as $key => $value) {
            $resultRows[$key] = \DB::table('total_litres')->where('product_type', $key)->sum('total_litres');
        }
        $newResultRows = array();
        $resultLength = count($resultRows) - 2;
        $i = 0;
        foreach ($resultRows as $key => $value) {
            $newResultRows[$i] = ["product_type" => $key, "total_litres" => $value, "color" => $this->getRandomColors()];
            $i++;
        }

        return response()->json($newResultRows);
    }
    public function getProductSalesPerType()
    {
        //pie chart

        $resultRows = array();
        $bank_list = \App\Sale::pluck('product_type', "product_type");
        foreach ($bank_list as $key => $value) {
            $resultRows[$key] = \DB::table('sales')->where('product_type', $key)->sum('litres_pumped');
        }
        $newResultRows = array();
        $resultLength = count($resultRows) - 2;
        $i = 0;
        foreach ($resultRows as $key => $value) {
            $newResultRows[$i] = ["product_type" => $key, "litres_pumped" => $value, "color" => $this->getRandomColors()];
            $i++;
        }

        return response()->json($newResultRows);
    }
    
    public function getTransactionDateRange()
    {
        $newResultRows = \DB::table('transactions')
            ->select('transaction_date')
            ->orderBy('transaction_date', 'asc')
            ->distinct()
            ->get();

        return response()->json($newResultRows);
    }
    public function getTransactionDateRangeOfCustomer($customerNumber)
    {
        $newResultRows = \DB::table('transactions')
            ->select('transaction_date')
            ->where('account_number', $customerNumber)
            ->orderBy('transaction_date', 'asc')
            ->distinct()
            ->get();

        return response()->json($newResultRows);
    }

    public function getTransactionDateRangeOfSupplier($supplierNumber)
    {
        $newResultRows = \DB::table('transactions')
            ->select('transaction_date')
            ->where('account_number', $supplierNumber)
            ->orderBy('transaction_date', 'asc')
            ->distinct()
            ->get();

        return response()->json($newResultRows);
    }
    public function getTransactionDateRangeOfBanks($bankname)
    {
        if ($bankname=="null") {
            $newResultRows = \DB::table('transactions')
            ->select('transaction_date')
            ->orderBy('transaction_date', 'asc')
            ->distinct()
            ->get();
        } else {
            $newResultRows = \DB::table('transactions')
            ->select('transaction_date')
            ->where('bank_name', "=", $bankname)
            ->orderBy('transaction_date', 'asc')
            ->distinct()
            ->get();
        }
      
        return response()->json($newResultRows);
    }

    public function getExpensePaymentDateRange()
    {
        $newResultRows = \DB::table('expense_payments')
            ->select('transaction_date')
            ->orderBy('transaction_date', 'asc')
            ->distinct()
            ->get();

        return response()->json($newResultRows);
    }

    public function getAccountNumberFromBankName($bankname)
    {
        $newResultRows = \DB::table('bank_accounts')
            ->select('account_number')
            ->where('bank_name', '=', $bankname)
            ->distinct()
            ->get();

        return response()->json($newResultRows);
    }
    public function getSupplierNameByProductType($productType)
    {
        $newResultRows=[];

        $arr = \DB::table('inventories')
            ->select('supplier_number')
            ->where('product_type', '=', $productType)
            ->distinct()
            ->get();
        $arr2=[];
        foreach ($arr as $key => $value) {
            $arr2[]=$value->supplier_number;
        }
     
        $newResultRows = \DB::table('suppliers')
                ->select("supplier_number", "supplier_name")
                ->whereIn('supplier_number', $arr2)
                ->distinct()
                ->get();
        
           
        

        return response(($newResultRows->toJson()));
    }

    public function getExpensePaymentDateRangeByCategory($expenseCategory)
    {
        if ($expenseCategory=="All") {
            $newResultRows = \DB::table('expense_payments')
                ->select('transaction_date')
                ->where('expense_category', '!=', "")
                ->orderBy('transaction_date', 'asc')
                ->distinct()
                ->get();
        } else {
            $newResultRows = \DB::table('expense_payments')
            ->select('transaction_date')
            ->where('expense_category', '=', $expenseCategory)
            ->orderBy('transaction_date', 'asc')
            ->distinct()
            ->get();
        }

        return response()->json($newResultRows);
    }
    public function getIncomeAndExpenses()
    {
        //bar chart
    }
    public function getSupplierCurrentBalance($supplierNumber)
    {
        $transactions = \DB::table('transactions')
                ->where('account_number', '=', $supplierNumber)
                ->orderby('created_at', 'asc')
                ->get();
        
        $supplierAccounts = [];

        $bal = 0;
        foreach ($transactions as $key => $value) {
            if ((int)$value->unit_price != 0) {
                $bal += ($value->liters * (int)$value->unit_price) - $value->amount_paid;
            } else {
                $bal += ($value->liters * $value->supplier_rate) - $value->amount_paid;
            }
          
            if ($value->transaction_code == "DOB") {
                $bal += $value->balance;
                $bal -= $value->amount_paid;
            }
            if ($value->product_type == "Invoice Generated") {
                $bal += $value->balance;
                $cost = $value->total_cost;
                $supplierAccount = [
                "supplier_name" => $value->supplier_name,
                "transaction_date" => $value->transaction_date,
                "product_type" => $value->product_type,
                "liters" => $value->liters,
                "unit_price" => $value->unit_price,
                "cost" => $cost,
                "amount_paid" => $value->amount_paid,
                "balance" => $bal
            ];
            } else {
                $supplierAccount = [
                "supplier_name" => $value->supplier_name,
                "transaction_date" => $value->transaction_date,
                "product_type" => $value->product_type,
                "liters" => $value->liters,
                "unit_price" => $value->unit_price,
                "cost" => $value->liters * $value->unit_price,
                "amount_paid" => $value->amount_paid,
                "balance" => $bal
            ];
            }
            $supplierAccounts[] = $supplierAccount;
        }
        $lastElementIndex = count($supplierAccounts) - 1;

        if (!empty($supplierAccounts)) {
            $supplierAccounts = $supplierAccounts[$lastElementIndex];
        }
       
        return response()->json($supplierAccounts);
    }
    public function getCustomerCurrentBalance($accountNumber)
    {
        $transactions = \DB::table('transactions')
            ->where('account_number', '=', $accountNumber)
            ->orderby('created_at', 'asc')
            ->get();

        $customerAccounts = [];

        $bal = 0;
        foreach ($transactions as $key => $value) {
            $bal += ($value->liters * $value->unit_price) - $value->amount_paid;
        
            if ($value->transaction_code == "DOB") {
                $bal += $value->balance;
                $bal -= $value->amount_paid;
            }
            $customerAccount = [
                "customer_name" => $value->supplier_name,
                "transaction_date" => $value->transaction_date,
                "product_type" => $value->product_type,
                "narration" => $value->narration,
                "liters" => $value->liters,
                "unit_price" => $value->unit_price,
                "cost" => $value->liters * $value->unit_price,
                "amount_paid" => $value->amount_paid,
                "balance" => $bal
            ];
            $customerAccounts[] = $customerAccount;
        }
        $lastElementIndex = count($customerAccounts) - 1;

        if (!empty($customerAccounts)) {
            $customerAccounts = $customerAccounts[$lastElementIndex];
        }
        return response()->json($customerAccounts);
    }
    public function getInventoryPerSuppliers()
    {
        //bar char
        $resultRows = \DB::table('inventories')
            ->groupBy("supplier_name")
            ->sum("litres_loaded");
        dd($resultRows);
    }
}
