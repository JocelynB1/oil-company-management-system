<?php

namespace App\Http\Controllers;

use App\Bank;
use App\BankAccount;
use App\Customer;
use App\Worker;
use App\Deposit;
use App\Expense;
use App\ExpensePayment;
use App\Inventory;
use App\PaymentMode;
use App\Product;
use App\Purchase;
use App\Sale;
use App\Refund;
use App\SalesRate;
use App\Status;
use App\Supplier;
use App\Guest;
use App\TransCode;
use App\Withdrawal;
use App\Transaction;
use App\Repayment;
use Carbon\Carbon;
use App\Paginators\DailySalesReportPaginator;

use Session;


use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class DisplayRecordsController extends Controller
{
    private $numOfRows;

    public function __construct()
    {
        $numOfRows = 25;
    }

    protected function getField(array $columns, $dbModel)
    {
        foreach ($columns as $column) {
            if (request()->has($column)) {
                $dbModel = $dbModel->where($column, request($column));
            }
        }
        return $dbModel;
    }
    protected function getQueries(array $columns)
    {
        $queries = [];

        foreach ($columns as $column) {
            if (request()->has($column)) {
                $queries[$column] = request($column);
            }
        }
        return $queries;
    }
    protected function getSortCondition(array $queries)
    {
        if (request()->has('sort')) {
            $queries['sort'] = request('sort');
        }
        return $queries;
    }
    protected function setOrderByCondition($dbModel, $fieldName)
    {
        if (request()->has('sort')) {
            $dbModel = $dbModel->orderBy("{$fieldName}", request('sort'));
        }

        return $dbModel;
    }
    protected function paginateModel($dbModel, $orderByColumn)
    {
        $dbModel = $dbModel->paginate($this->numOfRows)->appends(
            [
                "{$orderByColumn}" => request("{$orderByColumn}"),
                "sort" => request("sort"),
            ]
        );
        return $dbModel;
    }


    public function buildPaginatedTable($dbModel, $columns, $orderByColumn)
    {
        if (null != request("field")) {
            $field = request("field");
            $query = request("query");
            if (null != request("dateQuery")) {
                $query = request("dateQuery");
                if (null != request("dateQueryEnd")) {
                    $endQuery = request("dateQueryEnd");
                    $dbModel = $dbModel->whereBetween($field, [$query, $endQuery]);
                }
            } else {
                $operators = array(
                    "<", ">", "<=", ">=", "=", "==", "<>", "!=", "AND", "and", "BETWEEN", "between", "OR", "or", "In", "in", "NOT", "not", "is null", "IS NULL",
                    "is not null", "IS NOT NULL"
                );

                $operatorNotFound = true;
                foreach ($operators as $key => $value) {
                    if (strpos($query, $value) !== false) {
                        $array = explode($value, $query);

                        $dbModel = $dbModel->where($field, $value, $array[1]);
                        $operatorNotFound = false;
                    }
                }
                if ($operatorNotFound) {
                    $dbModel = $dbModel->where($field, 'LIKE', '%' . $query . '%');
                }
            }
            $orderByColumn = $field;

            $dbModel = $this->getField($columns, $dbModel);
            $dbModel = $this->setOrderByCondition($dbModel, $orderByColumn);
            $dbModel = $this->paginateModel($dbModel, $orderByColumn);
        } else {
            $dbModel = $this->getField($columns, $dbModel);
            $dbModel = $this->setOrderByCondition($dbModel, $orderByColumn);
            $dbModel = $this->paginateModel($dbModel, $orderByColumn);
        }
        return $dbModel;
    }
    public function displayBanks()
    {
        $banks = new Bank;
        $columns = [
            "bank_name"
        ];
        $orderByColumn = "bank_name";
        $banks = $this->buildPaginatedTable($banks, $columns, $orderByColumn);
        return view("displayrecords.banks", compact("banks"));
    }
    public function displayBankAccounts()
    {
        $bankaccounts = new BankAccount;
        $columns = [
            "bank_name", "date_of_last_transaction", "created_at", "updated_by"
        ];
        $orderByColumn = "bank_name";
        $bankaccounts = $this->buildPaginatedTable($bankaccounts, $columns, $orderByColumn);
        return view("displayrecords.bankaccounts", compact("bankaccounts"));
    }
    public function displayCustomers()
    {
        $customers = new Customer;
        $columns = [
            "customer_number", "customer_name", "company_name", "created_by", "modified_by"
        ];
        $orderByColumn = "company_name";
        $customers = $this->buildPaginatedTable($customers, $columns, $orderByColumn);
        return view("displayrecords.customers", compact("customers"));
    }
    public function displayEmployees()
    {
        $employees = new Worker;
        $columns = [
            "type",
            "employee_name",
            "created_by",
            "modified_by"
        ];
        $orderByColumn = "employee_name";
        $employees = $this->buildPaginatedTable($employees, $columns, $orderByColumn);
        return view("displayrecords.employees", compact("employees"));
    }
    public function displayGuests()
    {
        $guests = new Guest;
        $columns = [
            "guest_number",
            "guest_name",
            "created_by",
            "modified_by"
        ];
        $orderByColumn = "guest_name";
        $guests = $this->buildPaginatedTable($guests, $columns, $orderByColumn);
        return view("displayrecords.guests", compact("guests"));
    }
    public function displayDeposits()
    {
        $deposits = new Deposit;
        $columns = [
            "transaction_date", "bank_name", "account_number", "transaction_code", "transaction_code", "amount", "narration", "created_by"
        ];
        $orderByColumn = "transaction_date";
        $deposits = $this->buildPaginatedTable($deposits, $columns, $orderByColumn);

        return view("displayrecords.deposits", compact("deposits"));
    }
    public function displayExpenses()
    {
        $expenses = new Expense;
        $columns = [
            "expense_category", "created_by", "created_at", "updated_at"
        ];
        $orderByColumn = "expense_category";
        $expenses = $this->buildPaginatedTable($expenses, $columns, $orderByColumn);

        return view("displayrecords.expenses", compact("expenses"));
    }
    public function displayExpensePayments()
    {
        $expensepayments = new ExpensePayment;
        $columns = [
            "expense_category", "transaction_date",
            "invoice_number", "amount",
            "narration", "payment_to",
            "payment_mode", "bank_name",
            "created_by", "created_at", "updated_at"
        ];
        $orderByColumn = "expense_category";
        $expensepayments = $this->buildPaginatedTable($expensepayments, $columns, $orderByColumn);

        return view("displayrecords.expensepayments", compact("expensepayments"));
    }
    public function displayInventories()
    {
        $inventories = new Inventory;
        $inventories = $inventories::where("litres_loaded", ">", 0);

        $columns = [
            "supplier_name", "truck_number",
            "driver_name", "driver_phone",
            "product_type", "litres_loaded",
            "supplier_rate",
            "modified_by", "created_by",
            "created_at", "updated_at"
        ];
        $orderByColumn = "supplier_name";
        $inventories = $this->buildPaginatedTable($inventories, $columns, $orderByColumn);


        return view("displayrecords.inventories", compact("inventories"));
    }
    public function displayPaymentModes()
    {
        $paymentmodes = new PaymentMode;
        $columns = [
            "payment_mode",
            "modified_by", "created_by",
            "created_at", "updated_at"
        ];
        $orderByColumn = "payment_mode";
        $paymentmodes = $this->buildPaginatedTable($paymentmodes, $columns, $orderByColumn);
        return view("displayrecords.paymentmodes", compact("paymentmodes"));
    }
    public function displayProducts()
    {
        $products = new Product;
        $columns = [
            "product_type", "created_by",
            "modified_by", "created_at",
            "updated_at"
        ];
        $orderByColumn = "product_type";
        $products = $this->buildPaginatedTable($products, $columns, $orderByColumn);


        return view("displayrecords.products", compact("products"));
    }
    public function displayPurchases()
    {
        $purchases = new Purchase;
        $columns = [
            "supplier_name", "type_of_purchase",
            "truck_number", "driver_name",
            "litres_loaded", "shortages_in_litres",
            "net_loading_in_litres", "total_cost",
            "amount_paid", "balance",
            "payment_mode", "bank_name",
            "cheque_number", "narration",
            "transaction_code", "transaction_date",
            "created_at", "updated_at"
        ];
        $orderByColumn = "supplier_name";
        $purchases = $this->buildPaginatedTable($purchases, $columns, $orderByColumn);

        return view("displayrecords.purchases", compact("purchases"));
    }
    public function displaySales()
    {
        $sales = new Sale;
        $columns = [
            "sales_date", "customer_name",
            "customer_number", "litres_pumped",
            "product_type", "shortages",
            "unit_price", "payment_mode",
            "bank_name", "supplier_name",
            "description", "discount_rate",
            "cash_discount_allowed", "total_cost",
            "amount_paid", "balance",
            "transaction_code", "stage_reached",
            "created_at", "updated_at"
        ];
        $orderByColumn = "sales_date";
        $sales = $this->buildPaginatedTable($sales, $columns, $orderByColumn);

        return view("displayrecords.sales", compact("sales"));
    }

    public function displayRefunds()
    {
        $refunds = new Refund;
        $columns = [
            "transaction_date", "customer_name",
            "account_number", "refund_amount",
            "payment_mode", "created_by",
            "transaction_code", "approval_status",
            "created_at", "updated_at"

        ];
        $orderByColumn = "transaction_date";
        $refunds = $this->buildPaginatedTable($refunds, $columns, $orderByColumn);

        return view("displayrecords.refunds", compact("refunds"));
    }


    public function displaySalesRates()
    {
        $salesrates = new SalesRate;
        $columns = [
            "selling_rate", "product_type",
            "created_by", "modified_by",
            "created_at", "updated_at"

        ];
        $orderByColumn = "updated_at";
        $salesrates = $this->buildPaginatedTable($salesrates, $columns, $orderByColumn);

        return view("displayrecords.salesrates", compact("salesrates"));
    }
    public function displayStatuses()
    {
        $statuses = new Status;
        $columns = [
            "description", "created_by",
            "created_at", "updated_at"

        ];
        $orderByColumn = "description";
        $statuses = $this->buildPaginatedTable($statuses, $columns, $orderByColumn);

        return view("displayrecords.statuses", compact("statuses"));
    }
    public function displaySuppliers()
    {
        $suppliers = new Supplier;
        $columns = [
            "supplier_number", "supplier_name",
            "company_name", "phone_number",
            "created_by", "modified_by",
            "created_at", "updated_at"

        ];
        $orderByColumn = "supplier_name";
        $suppliers = $this->buildPaginatedTable($suppliers, $columns, $orderByColumn);

        return view("displayrecords.suppliers", compact("suppliers"));
    }
    public function displayTransCodes()
    {
        $transcodes = new TransCode;
        $columns = [
            "transaction_code", "transaction_description",
            "created_by", "created_at",
            "updated_at"

        ];
        $orderByColumn = "transaction_description";
        $transcodes = $this->buildPaginatedTable($transcodes, $columns, $orderByColumn);

        return view("displayrecords.transcodes", compact("transcodes"));
    }
    public function displayWithdrawals()
    {
        $withdrawals = new Withdrawal;

        $columns = [
            "transaction_date", "bank_name",
            "account_number", "transaction_code",
            "amount", "narration",
            "created_by", "created_at",
            "updated_at"

        ];
        $orderByColumn = "transaction_date";
        $withdrawals = $this->buildPaginatedTable($withdrawals, $columns, $orderByColumn);

        return view("displayrecords.withdrawals", compact("withdrawals"));
    }
    public function displayTransactions()
    {
        $transactions = new Transaction;

        $columns = [
            "trn_ref_no",
            "transaction_date",
            "product_type",
            "liters",
            "selling_rate",
            "total_cost",
            "amount_paid",
            "balance",
            "narration",
            "transaction_code",
            "customer_name",
            "shortages",
            "supplier_name",
            "unit_price",
            "payment_mode",
            "bank_name",
            "cheque_number",
            "payment_status",
            "discount_rate",
            "cash_discount_allowed",
            "approval_status",
            "approval_date",
            "approved_by",
            "created_at",
            "updated_at"



        ];
        $orderByColumn = "transaction_date";
        $transactions = $this->buildPaginatedTable($transactions, $columns, $orderByColumn);

        return view("displayrecords.transactions", compact("transactions"));
    }
    public function displayAccountantSales()
    {
        if (!isset($_REQUEST["query"])) {
            $_REQUEST["query"] = "stage_reached";
        }
        if (!isset($_REQUEST["field"])) {
            $_REQUEST["field"] = "waiting_for_accountant";
        }


        $flagedSalesRows = Sale::where('stage_reached', '=', 'waiting_for_accountant')->paginate(25);

        if (empty($flagedSalesRows[0])) {
            Session::flash('flash_message', 'No records found!  Waiting for the Output Manager to start sales.');
            return view('displayrecords.accountantsales');
        }

        $sales = new Sale;
        $columns = [
            "sales_date", "customer_name",
            "customer_number", "litres_pumped",
            "product_type", "shortages",
            "unit_price", "payment_mode",
            "bank_name", "supplier_name",
            "description", "discount_rate",
            "cash_discount_allowed", "total_cost",
            "amount_paid", "balance",
            "transaction_code", "stage_reached",
            "created_at", "updated_at"
        ];
        $request = new \Symfony\Component\HttpFoundation\Request;
        $request->request->add(["field", "stage_reached"]);
        $request->request->add(["query", "waiting_for_accountant"]);
        $orderByColumn = "sales_date";
        // $request->put("field","stage_reached");
        // $request->put("query","waiting_for_accountant");
        $sales = $this->buildPaginatedTable($sales, $columns, $orderByColumn);

        $sales = Sale::where('stage_reached', '=', 'waiting_for_accountant')->paginate(25);

        if (!empty($sales[0])) {
            return view('displayrecords.accountantsales')->with(['sales' => $sales]);
        }
        Session::flash('flash_message', 'No records found!  Waiting for the Output Manager to start sales.');
        return view('displayrecords.accountantsales')->with(['sales' => $sales]);

       
        // return view("displayrecords.accountantsales",compact("sales"));
    }
    public function displayInvoices()
    {
        if (!isset($_REQUEST["query"])) {
            $_REQUEST["query"] = "posted_from";
        }
        if (!isset($_REQUEST["field"])) {
            $_REQUEST["field"] = "InvoicesStart";
        }


        $flagedSalesRows = Transaction::where('posted_from', '=', 'InvoicesStart')->paginate(25);

        if (empty($flagedSalesRows[0])) {
            Session::flash('flash_message', 'No Invoices found!');
            return view('displayrecords.invoices');
        }

        $sales = new Transaction;
        $columns = [
            "sales_date", "customer_name",
            "customer_number", "litres_pumped",
            "product_type", "shortages",
            "unit_price", "payment_mode",
            "bank_name", "supplier_name",
            "description", "discount_rate",
            "cash_discount_allowed", "total_cost",
            "amount_paid", "balance",
            "transaction_code", "stage_reached",
            "created_at", "updated_at"
        ];
        $request = new \Symfony\Component\HttpFoundation\Request;
        $request->request->add(["field", "stage_reached"]);
        $request->request->add(["query", "InvoicesStart"]);
        $orderByColumn = "sales_date";
        // $request->put("field","stage_reached");
        // $request->put("query","waiting_for_accountant");
        $sales = $this->buildPaginatedTable($sales, $columns, $orderByColumn);

        $sales = Transaction::where('posted_from', '=', 'InvoicesStart')->paginate(25);

        if (!empty($sales[0])) {
            return view('displayrecords.invoices')->with(['sales' => $sales]);
        }
        Session::flash('flash_message', 'No invoices found!');
        return view('displayrecords.invoices')->with(['sales' => $sales]);

       
        // return view("displayrecords.accountantsales",compact("sales"));
    }

    public function displayDailySalesReport()
    {
        if (request()->has('dateQuery')) {
            $date = request('dateQuery');
        } else {
            $date = date("Y-m-d");
        }
        if (request()->has('product_type')) {
            $productType = request('product_type');
        } else {
            $productType = "AGO";
        }

        
        if (request()->has('dateQuery')) {
            $date = request('dateQuery');
        }
      

        if ($productType == "ALL") {
            if (request()->has('dateQueryEnd')) {
                $endDate = request('dateQueryEnd');
                $transactions = \DB::table('transactions')
                    ->whereBetween('transaction_date', [$date, $endDate])
                    ->where('posted_from', '=', "AcceptPayment")
                    ->orderby('created_at', 'asc')
                    ->get();
            } else {
                $transactions = \DB::table('transactions')
                ->where('transaction_date', '=', $date)
                ->where('posted_from', '=', "AcceptPayment")
                ->get();
            }
            $inventory = \DB::table('inventories')
                ->where('litres_loaded', '>', 0)
                ->where('transaction_date', '=', $date)
                ->get();
            $openingStock = \DB::table('inventories')
                ->where('transaction_date', '=', Carbon::yesterday())
                ->sum("litres_loaded");
        } else {
            if (request()->has('dateQueryEnd')) {
                $endDate = request('dateQueryEnd');
                $transactions = \DB::table('transactions')
                    ->whereBetween('transaction_date', [$date, $endDate])
                    ->where('product_type', '=', $productType)
                    ->where('posted_from', '=', "AcceptPayment")
                    ->orderby('created_at', 'asc')
                    ->get();
            } else {
                $transactions = \DB::table('transactions')
                ->where('transaction_date', '=', $date)
                ->where('product_type', '=', $productType)
                ->where('posted_from', '=', "AcceptPayment")
                ->get();
            }
            $inventory = \DB::table('inventories')
                ->where('litres_loaded', '>', 0)
                ->where('product_type', '=', $productType)
                ->where('transaction_date', '=', $date)
                ->get();
            $openingStock = \DB::table('inventories')
                ->where('transaction_date', '=', Carbon::yesterday())
                ->where('product_type', '=', $productType)
                ->sum("litres_loaded");
        }
        $page = \Illuminate\Support\facades\Input::get('page', 1);
        $perPage = 25;
        $offset = ($page * $perPage) - $perPage;
        if (!empty($transactions)) {
            $transactions = collect($transactions);
        } else {
            $transactions = [];
            $transactions = collect($transactions);
        }

        $transactions = new LengthAwarePaginator(
            array_slice(
                $transactions->toArray(),
                $offset,
                $perPage,
                true
            ),
            count($transactions),
            $perPage,
            $page,
            [
                'path' => request()->url(),
                'query' => request()->query()
            ]
        );

        return view("reports.dailySalesReport")->with([
            "transactions" => $transactions,
            "inventory" => $inventory,
            "openingStock" => $openingStock,
            "productType" => $productType
        ]);
    }

    public function displayCustomersAccountReport(Request $request)
    {
        if (request()->has('account_number')) {
            $accountNumber = request('account_number');
        } else {
            $accountNumber = "";
        }

        $customers = \DB::table('customers')
            ->select("customer_number")
            ->distinct()
            ->get();


        $customerAccounts = [];
        $currentBalCustAccounts = [];

        foreach ($customers as $key => $value) {
            $transactions = \DB::table('transactions')
                ->where('account_number', '=', $value->customer_number)
                ->orderby('created_at', 'asc')
                ->get();
            $bal = 0;
            $totalAmountPaid = 0;
            $totalLiters = 0;
            $totalCost = 0;


            foreach ($transactions as $key => $value) {
                $bal += (($value->liters * $value->unit_price)
                    - ($value->discount_rate * $value->liters)
                    - $value->cash_discount_allowed) - $value->amount_paid;
           
                //$bal += ($value->liters * $value->unit_price) - $value->amount_paid;
                if ($value->transaction_code == "DOB") {
                    $bal += $value->balance;
                    $bal -= $value->amount_paid;
                }

                $totalAmountPaid += $value->amount_paid;
                $totalLiters += $value->liters;
                $totalCost += ($value->liters * $value->unit_price) - ($value->discount_rate * $value->liters) - $value->cash_discount_allowed;

                if ($value->narration=="Debt Opening Balance") {
                    $bal += $value->total_cost;
                    $totalCost += $value->total_cost;

                }

                $customerAccount = [
                    "transaction_date" => $value->transaction_date,
                    "customer_number" => $value->account_number,
                    "customer_name" => $value->customer_name,
                    "liters" => $totalLiters,
                    "cost" => $totalCost,
                    "amount_paid" => $totalAmountPaid,
                    "balance" => $bal
                ];
                $customerAccounts[] = $customerAccount;
            }
            $lastElementIndex = count($customerAccounts) - 1;

            if (!empty($customerAccounts) && count($transactions) != 0) {
                $currentBalCustAccounts[] = $customerAccounts[$lastElementIndex];
            }
        }

        $keys = [
            "LAST TRANSACTION DATE",
            "CUSTOMER NUMBER",
            "CUSTOMER NAME",
            "TOTAL LITERS",
            "TOTAL COST",
            "TOTAL AMOUNT PAID",
            "BALANCE"
        ];



        if (request()->has('export')) {
            $headers = [
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="export.csv"',
                'Expires' => '0',
                'Pragma' => 'public'
            ];
            $fileName = "export.csv";
            $output = fopen(storage_path($fileName), 'w') or die("Can't open php://output");
            fputcsv($output, $keys);
            foreach ($currentBalCustAccounts as $key => $value) {
                fputcsv($output, $value);
            }
            fclose($output) or die("Can't close php://output");
            return response()->download(storage_path('export.csv'), 'export.csv', ['header' => $headers]);
        }

        $page = \Illuminate\Support\facades\Input::get('page', 1);
        $perPage = 25;
        $offset = ($page * $perPage) - $perPage;
        if (!empty($currentBalCustAccounts)) {
            $currentBalCustAccounts = collect($currentBalCustAccounts);
        } else {
            $currentBalCustAccounts = [];
            $currentBalCustAccounts = collect($currentBalCustAccounts);
        }

        $currentBalCustAccounts = new LengthAwarePaginator(
            array_slice(
                $currentBalCustAccounts->toArray(),
                $offset,
                $perPage,
                true
            ),
            count($currentBalCustAccounts),
            $perPage,
            $page,
            [
                'path' => $request->url(),
                'query' => $request->query()
            ]
        );

        return view("reports.customersAccountReport")->with([

            "customerAccounts" => $currentBalCustAccounts
        ]);
    }

    public function displayCustomersStatementReport(Request $request)
    {
        $accountNumber = "";

        if (request()->has('account_number')) {
            $accountNumber = request('account_number');
        }
        if (request()->has('customer_number')) {
            $accountNumber = request('customer_number');
        }
        if (request()->has('dateQuery')) {
            $date = request('dateQuery');
        }
        if (request()->has('dateQueryEnd')) {
            $endDate = request('dateQueryEnd');
            $transactions = \DB::table('transactions')
                ->where('account_number', '=', $accountNumber)
                ->whereBetween('transaction_date', [$date, $endDate])
                ->orderby('created_at', 'asc')
                ->get();
        } else {
            $transactions = \DB::table('transactions')
                ->where('account_number', '=', $accountNumber)
                ->orderby('created_at', 'asc')
                ->get();
        }


        $customerAccounts = [];

        $bal = 0;
        foreach ($transactions as $key => $value) {
            
            $bal+= (($value->liters * $value->unit_price)
            -($value->discount_rate*$value->liters)
            -$value->cash_discount_allowed)- $value->amount_paid;
            if ($value->transaction_code == "DOB") {
                $bal += $value->balance;
                $bal -= $value->amount_paid;
            }
            if ($value->product_type == "Invoice Generated") {
                $bal += $value->balance;
                $bal -= $value->amount_paid;
            }

            if ($value->product_type == "Invoice Paid") {
                $bal += $value->balance;
                $bal -= $value->amount_paid;
            }
            if($value->narration=="Debt Opening Balance"){
                $bal += $value->total_cost;

        $customerAccount = [
                "trn_ref_no"=>$value->trn_ref_no,
                "customer_name" => $value->customer_name,
                "transaction_date" => $value->transaction_date,
                "bank_name" => $value->bank_name,
                "discount_rate" => $value->discount_rate,
                "cash_discount_allowed" => $value->cash_discount_allowed,
                "payment_mode" => $value->payment_mode,
                "payment_status" => $value->payment_status,
                "supplier_rate" => $value->supplier_rate,
                "narration" => $value->narration,
                "liters" => $value->liters,
                "unit_price" => $value->unit_price,
                "cost" => $value->total_cost,
                "amount_paid" => $value->amount_paid,
                "balance" => $bal
            ];

}else{
        $customerAccount = [
                "trn_ref_no"=>$value->trn_ref_no,
                "customer_name" => $value->customer_name,
                "transaction_date" => $value->transaction_date,
                "bank_name" => $value->bank_name,
                "discount_rate" => $value->discount_rate,
                "cash_discount_allowed" => $value->cash_discount_allowed,
                "payment_mode" => $value->payment_mode,
                "payment_status" => $value->payment_status,
                "supplier_rate" => $value->supplier_rate,
                "narration" => $value->narration,
                "liters" => $value->liters,
                "unit_price" => $value->unit_price,
                "cost" => $value->liters * $value->unit_price,
                "amount_paid" => $value->amount_paid,
                "balance" => $bal
            ];

}
            $customerAccounts[] = $customerAccount;
        }

        $keys = [
            "customer_name",
            "transaction_date",
            "trn_ref_no",
            "bank_name",
            "discount_rate",
            "cash_discount_allowed",
            "payment_mode",
            "payment_status",
            "supplier_rate",
            "narration",
            "liters",
            "unit_price",
            "cost",
            "amount_paid",
            "balance"
        ];


        if (request()->has('export')) {
            $headers = [
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="export.csv"',
                'Expires' => '0',
                'Pragma' => 'public'
            ];
            $fileName = "export.csv";
            $output = fopen(storage_path($fileName), 'w') or die("Can't open php://output");
            fputcsv($output, $keys);
            foreach ($customerAccounts as $key => $value) {
                fputcsv($output, $value);
            }
            fclose($output) or die("Can't close php://output");
            return response()->download(storage_path('export.csv'), 'export.csv', ['header' => $headers]);
        }


        $page = \Illuminate\Support\facades\Input::get('page', 1);
        $perPage = 25;
        $offset = ($page * $perPage) - $perPage;
        if (!empty($customerAccounts)) {
            $customerAccounts = collect($customerAccounts);
        } else {
            $customerAccounts = [];
            $customerAccounts = collect($customerAccounts);
        }

        $customerAccounts = new LengthAwarePaginator(
            array_slice(
                $customerAccounts->toArray(),
                $offset,
                $perPage,
                true
            ),
            count($customerAccounts),
            $perPage,
            $page,
            [
                'path' => $request->url(),
                'query' => $request->query()
            ]
        );
        return view("reports.customersStatementReport")->with([

            "customerAccounts" => $customerAccounts
        ]);
    }
    public function displaySupplierAccountReport(Request $request)
    {
        if (request()->has('account_number')) {
            $accountNumber = request('account_number');
        } else {
            $accountNumber = "";
        }

        $suppliers = \DB::table('suppliers')
            ->select("supplier_number")
            ->distinct()
            ->get();

        $currentBalSupplierAccounts = [];
        $supplierAccounts = [];

        foreach ($suppliers as $key => $value) {
            $transactions = \DB::table('transactions')
                ->where('account_number', '=', $value->supplier_number)
                ->orderby('created_at', 'asc')
                ->get();
            $bal = 0;
            $totalAmountPaid = 0;
            $totalLiters = 0;
            $totalCost = 0;



            foreach ($transactions as $key => $value) {
                if ($value->unit_price != 0) {
                    $bal += ($value->liters * $value->unit_price) - $value->amount_paid;
                } else {
                    $bal += ($value->liters * $value->supplier_rate) - $value->amount_paid;
                }

                if ($value->transaction_code == "DOB") {
                    $bal += $value->balance;
                    $bal -= $value->amount_paid;
                }
                if ($value->product_type == "Invoice Generated") {
                    $bal += $value->balance;
                    $totalCost = $value->total_cost;
//                    $cost = $value->total_cost;
                    
                }

                if ($value->product_type == "Invoice Paid") {
                    $totalCost = $value->total_cost;
                  //  $cost = $value->total_cost;
                    
                }
              if ($value->narration=="Debt Opening Balance") {
        $bal += $value->total_cost;
        $totalCost += $value->total_cost;
    }

                $totalAmountPaid += $value->amount_paid;
                $totalLiters += $value->liters;
                $totalCost +=$value->total_cost;
                //($value->liters * $value->unit_price) - ($value->discount_rate * $value->liters) - $value->cash_discount_allowed;

                $supplierAccount = [
                    "transaction_date" => $value->transaction_date,
                    "supplier_number" => $value->account_number,
                    "supplier_name" => $value->supplier_name,
                    "liters" => $totalLiters,
                    "cost" => $totalCost,
                    "amount_paid" => $totalAmountPaid,
                    "balance" => $bal
                ];
                $supplierAccounts[] = $supplierAccount;
            }
            $lastElementIndex = count($supplierAccounts) - 1;

            if (!empty($supplierAccounts) && count($transactions) != 0) {
                $currentBalSupplierAccounts[] = $supplierAccounts[$lastElementIndex];
            }
        }
        $keys = [
            "LAST TRANSACTION DATE",
            "SUPPLIER NUMBER",
            "SUPPLIER NAME",
            "TOTAL LITERS SUPPLIED",
            "TOTAL COST",
            "TOTAL AMOUNT PAID",
            "BALANCE"
        ];


        if (request()->has('export')) {
            $headers = [
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="export.csv"',
                'Expires' => '0',
                'Pragma' => 'public'
            ];
            $fileName = "export.csv";
            $output = fopen(storage_path($fileName), 'w') or die("Can't open php://output");
            fputcsv($output, $keys);
            foreach ($currentBalSupplierAccounts as $key => $value) {
                fputcsv($output, $value);
            }
            fclose($output) or die("Can't close php://output");
            return response()->download(storage_path('export.csv'), 'export.csv', ['header' => $headers]);
        }


        $page = \Illuminate\Support\facades\Input::get('page', 1);
        $perPage = 25;
        $offset = ($page * $perPage) - $perPage;
        if (!empty($currentBalSupplierAccounts)) {
            $currentBalSupplierAccounts = collect($currentBalSupplierAccounts);
        } else {
            $currentBalSupplierAccounts = [];
            $currentBalSupplierAccounts = collect($currentBalSupplierAccounts);
        }

        $currentBalSupplierAccounts = new LengthAwarePaginator(
            array_slice(
                $currentBalSupplierAccounts->toArray(),
                $offset,
                $perPage,
                true
            ),
            count($currentBalSupplierAccounts),
            $perPage,
            $page,
            [
                'path' => $request->url(),
                'query' => $request->query()
            ]
        );

        return view("reports.suppliersAccountReport")->with([

            "supplierAccounts" => $currentBalSupplierAccounts
        ]);
    }
    public function displaySuppliersStatementReport(Request $request)
    {
        $accountNumber = "";

        if (request()->has('account_number')) {
            $accountNumber = request('account_number');
        }
        if (request()->has('supplier_number')) {
            $accountNumber = request('supplier_number');
        }
        if (request()->has('dateQuery')) {
            $date = request('dateQuery');
        }
        if (request()->has('dateQueryEnd')) {
            $endDate = request('dateQueryEnd');
            $transactions = \DB::table('transactions')
                ->where('account_number', '=', $accountNumber)
                ->whereBetween('transaction_date', [$date, $endDate])
                ->orderby('created_at', 'asc')
                ->get();
        } else {
            $transactions = \DB::table('transactions')
                ->where('account_number', '=', $accountNumber)
                ->orderby('created_at', 'asc')
                ->get();
        }




        $supplierAccounts = [];

        $bal = 0;
        foreach ($transactions as $key => $value) {
            if ($value->unit_price != 0) {
                $bal += ($value->liters * $value->unit_price) - $value->amount_paid;
            } else {
                $bal += ($value->liters * $value->supplier_rate) - $value->amount_paid;
            }
            if ($value->transaction_code == "DOB") {
                $bal += $value->balance;
                $bal -= $value->amount_paid;
            }
            if ($value->narration == "shortage") {
                $value->liters = $value->shortages;
            }
            
            if ($value->posted_from == "Inventory") {
                $cost = $value->total_cost;
            } else {
                $cost = $value->liters * $value->unit_price;
            }
            if ($value->product_type == "Invoice Generated") {
                $bal += $value->balance;
                $cost = $value->total_cost;
            }

            if ($value->product_type == "Invoice Paid") {
                $cost = $value->total_cost;
            }
                     if ($value->narration=="Debt Opening Balance") {
             $bal += $value->total_cost;
             $cost += $value->total_cost;
         }

            $supplierAccount = [
                "supplier_name" => $value->supplier_name,
                "transaction_date" => $value->transaction_date,
                "narration" => $value->narration,
                "product_type" => $value->product_type,
                "liters" => $value->liters,
                "unit_price" => $value->unit_price,
                "supplier_rate" => $value->supplier_rate,
                "payment_mode" => $value->payment_mode,
                "cost" => $cost,
                "cheque_number" => $value->cheque_number,
                "bank_name" => $value->bank_name,
                "amount_paid" => $value->amount_paid,
                "balance" => $bal
            ];
            $supplierAccounts[] = $supplierAccount;
        }

        $keys = [
            "supplier_name",
            "transaction_date",
            "narration",
            "product_type",
            "liters",
            "unit_price",
            "supplier_rate",
            "cost",
            "payment_mode",
            "cheque_number",
            "bank_name",
            "amount_paid",
            "balance",
        ];


        if (request()->has('export')) {
            $headers = [
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="export.csv"',
                'Expires' => '0',
                'Pragma' => 'public'
            ];
            $fileName = "export.csv";
            $output = fopen(storage_path($fileName), 'w') or die("Can't open php://output");
            fputcsv($output, $keys);
            foreach ($supplierAccounts as $key => $value) {
                fputcsv($output, $value);
            }
            fclose($output) or die("Can't close php://output");
            return response()->download(storage_path('export.csv'), 'export.csv', ['header' => $headers]);
        }



        $page = \Illuminate\Support\facades\Input::get('page', 1);
        $perPage = 25;
        $offset = ($page * $perPage) - $perPage;

        if (!empty($supplierAccounts)) {
            $supplierAccounts = collect($supplierAccounts);
        } else {
            $supplierAccounts = [];
            $supplierAccounts = collect($supplierAccounts);
        }
        $supplierAccounts = new LengthAwarePaginator(
            array_slice(
                $supplierAccounts->toArray(),
                $offset,
                $perPage,
                true
            ),
            count($supplierAccounts),
            $perPage,
            $page,
            [
                'path' => $request->url(),
                'query' => $request->query()
            ]
        );


        return view("reports.suppliersStatementReport")->with([

            "supplierAccounts" => $supplierAccounts
        ]);
    }
    public function displayDebtorsReport(Request $request)
    {
        $customers = \DB::table('customers')
            ->select("customer_number")
            ->distinct()
            ->get();
        $postiveBalanceCustAccounts = [];
        foreach ($customers as $key => $value) {
            $transactions = \DB::table('transactions')
                ->where('account_number', '=', $value->customer_number)
                ->orderby('created_at', 'asc')
                ->get();
            $bal = 0;
            $customerAccounts = [];
            foreach ($transactions as $key => $value) {
                $bal += (($value->liters * $value->unit_price)
                    - ($value->discount_rate * $value->liters)
                    - $value->cash_discount_allowed) 
                    - $value->amount_paid;
   //           $bal += ($value->liters * $value->unit_price) - $value->amount_paid;
                if ($value->transaction_code == "DOB") {
                    $bal += $value->balance;
                    $bal -= $value->amount_paid;
                }
                if ($value->product_type == "Invoice Generated") {
                    $bal += $value->balance;
                    $bal -= $value->amount_paid;
                }

                if ($value->product_type == "Invoice Paid") {
                    $bal += $value->balance;
                    $bal -= $value->amount_paid;
                }
//new
                if ($value->narration == "Debt Opening Balance") {
                    $bal += $value->total_cost;
                }
                        //
                    
                $customerAccount = [
                    "transaction_date" => $value->transaction_date,
                    "customer_number" => $value->account_number,
                    "customer_name" => $value->customer_name,
                    "balance" => $bal
                ];
                $customerAccounts[] = $customerAccount;
            }


            $lastElementIndex = count($customerAccounts) - 1;

            if (!empty($customerAccounts) && $customerAccounts[$lastElementIndex]['balance'] > 0) {
                $postiveBalanceCustAccounts[] = $customerAccounts[$lastElementIndex];
            }
        }



        $page = \Illuminate\Support\facades\Input::get('page', 1);
        $perPage = 25;
        $offset = ($page * $perPage) - $perPage;
        if (!empty($postiveBalanceCustAccounts)) {
            $postiveBalanceCustAccounts = collect($postiveBalanceCustAccounts);
        } else {
            $postiveBalanceCustAccounts = [];
            $postiveBalanceCustAccounts = collect($postiveBalanceCustAccounts);
        }

        $custAccss = new LengthAwarePaginator(
            array_slice(
                $postiveBalanceCustAccounts->toArray(),
                $offset,
                $perPage,
                true
            ),
            count($postiveBalanceCustAccounts),
            $perPage,
            $page,
            [
                'path' => $request->url(),
                'query' => $request->query()
            ]
        );


        $keys = [
            "LAST TRANSACTION DATE",
            "CUSTOMER NAME",
            "CUSTOMER NUMBER",
            "BALANCE"
        ];

        if (request()->has('export')) {
            $headers = [
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="export.csv"',
                'Expires' => '0',
                'Pragma' => 'public'
            ];
            $fileName = "export.csv";
            $output = fopen(storage_path($fileName), 'w') or die("Can't open php://output");
            fputcsv($output, $keys);
            foreach ($postiveBalanceCustAccounts as $key => $value) {
                fputcsv($output, $value);
            }
            fclose($output) or die("Can't close php://output");
            return response()->download(storage_path('export.csv'), 'export.csv', ['header' => $headers]);
        }



        return view("reports.debtorsReport", compact("custAccss"));
    }
    public function displayCreditorsReport(Request $request)
    {
        $customers = \DB::table('suppliers')
            ->select("supplier_number")
            ->distinct()
            ->get();
        $postiveBalanceCustAccounts = [];
        foreach ($customers as $key => $value) {
            $transactions = \DB::table('transactions')
                ->where('account_number', '=', $value->supplier_number)
                ->orderby('created_at', 'asc')
                ->get();
            $bal = 0;
            $customerAccounts = [];

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
                if ($value->transaction_code == "INV") {
                    $bal += $value->balance;
                    $bal -= $value->amount_paid;
                }


                $customerAccount = [
                    "transaction_date" => $value->transaction_date,
                    "supplier_name" => $value->supplier_name,
                    "supplier_number" => $value->account_number,
                    "balance" => $bal
                ];
                $customerAccounts[] = $customerAccount;
            }

            $lastElementIndex = count($customerAccounts) - 1;

            if (!empty($customerAccounts) && $customerAccounts[$lastElementIndex]['balance'] > 0) {
                $postiveBalanceCustAccounts[] = $customerAccounts[$lastElementIndex];
            }
        }

        $keys = [
            "LAST TRANSACTION DATE",
            "SUPPLIER NAME",
            "SUPPLIER NUMBER",
            "BALANCE"
        ];


        if (request()->has('export')) {
            $headers = [
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="export.csv"',
                'Expires' => '0',
                'Pragma' => 'public'
            ];
            $fileName = "export.csv";
            $output = fopen(storage_path($fileName), 'w') or die("Can't open php://output");
            fputcsv($output, $keys);
            foreach ($postiveBalanceCustAccounts as $key => $value) {
                fputcsv($output, $value);
            }
            fclose($output) or die("Can't close php://output");
            return response()->download(storage_path('export.csv'), 'export.csv', ['header' => $headers]);
        }



        $page = \Illuminate\Support\facades\Input::get('page', 1);
        $perPage = 25;
        $offset = ($page * $perPage) - $perPage;
        if (!empty($postiveBalanceCustAccounts)) {
            $postiveBalanceCustAccounts = collect($postiveBalanceCustAccounts);
        } else {
            $postiveBalanceCustAccounts = [];
            $postiveBalanceCustAccounts = collect($postiveBalanceCustAccounts);
        }

        $custAccss = new LengthAwarePaginator(
            array_slice(
                $postiveBalanceCustAccounts->toArray(),
                $offset,
                $perPage,
                true
            ),
            count($postiveBalanceCustAccounts),
            $perPage,
            $page,
            [
                'path' => $request->url(),
                'query' => $request->query()
            ]
        );

        return view("reports.creditorsReport", compact("custAccss"));
    }
    public function displayCostOfGoodsPurchased(Request $request)
    {
        $suppliers = \DB::table('suppliers')
            ->select("supplier_number")
            ->distinct()
            ->get();
        $supplierPayments = [];

        foreach ($suppliers as $key => $value) {
            $purchases = \DB::table('purchases')
                ->where('supplier_number', '=', $value->supplier_number)
                ->orderby('created_at', 'asc')
                ->get();
            //   $bal = 0;
            $totalCost = 0;
            $supplierPayment = [];
            foreach ($purchases as $key => $value) {
                //     $bal += $value->balance;
                $totalCost += $value->total_cost;
                $supplierPayment = [
                    "transaction_date" => $value->transaction_date,
                    "supplier_name" => $value->supplier_name,
                    "litres_loaded" => $value->litres_loaded,
                    "product_type" => $value->product_type,
                    "shortages_in_litres" => $value->shortages_in_litres,
                    "net_loading_in_litres" => $value->net_loading_in_litres,
                    "price_per_litre" => $value->price_per_litre,
                    "amount" => $value->total_cost,
                    "total_cost" => ""

                ];

                $supplierPayments[] = $supplierPayment;
            }
            if (!empty($supplierPayments)) {
                $lastElementIndex = count($supplierPayments) - 1;
                $supplierPayments[$lastElementIndex] = [
                    "transaction_date" => $supplierPayments[$lastElementIndex]['transaction_date'],
                    "supplier_name" => $supplierPayments[$lastElementIndex]['supplier_name'],
                    "litres_loaded" => $supplierPayments[$lastElementIndex]['litres_loaded'],
                    "product_type" => $supplierPayments[$lastElementIndex]['product_type'],
                    "shortages_in_litres" => $supplierPayments[$lastElementIndex]['shortages_in_litres'],
                    "net_loading_in_litres" => $supplierPayments[$lastElementIndex]['net_loading_in_litres'],
                    "price_per_litre" => $supplierPayments[$lastElementIndex]['price_per_litre'],
                    "amount" => $supplierPayments[$lastElementIndex]['amount'],
                    "total_cost" => $totalCost

                ];
            }
        }
        $keys = [
            "transaction_date",
            "supplier_name",
            "litres_loaded",
            "product_type",
            "shortages_in_litres",
            "net_loading_in_litres",
            "price_per_litre",
            "amount",
            "total_cost"
        ];


        if (request()->has('export')) {
            $headers = [
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="export.csv"',
                'Expires' => '0',
                'Pragma' => 'public'
            ];
            $fileName = "export.csv";
            $output = fopen(storage_path($fileName), 'w') or die("Can't open php://output");
            fputcsv($output, $keys);
            foreach ($supplierPayments as $key => $value) {
                fputcsv($output, $value);
            }
            fclose($output) or die("Can't close php://output");
            return response()->download(storage_path('export.csv'), 'export.csv', ['header' => $headers]);
        }



        $page = \Illuminate\Support\facades\Input::get('page', 1);
        $perPage = 25;
        $offset = ($page * $perPage) - $perPage;
        if (!empty($supplierPayments)) {
            $supplierPayments = collect($supplierPayments);
        } else {
            $supplierAccounts = [];
            $supplierPayments = collect($supplierPayments);
        }
        $supplierPayments = new LengthAwarePaginator(
            array_slice(
                $supplierPayments->toArray(),
                $offset,
                $perPage,
                true
            ),
            count($supplierPayments),
            $perPage,
            $page,
            [
                'path' => $request->url(),
                'query' => $request->query()
            ]
        );

        return view("reports.costOfGoodsPurchased", compact("supplierPayments"));
    }
    public function displayActiveCustomersReport(Request $request)
    {
        $customers = \DB::table('customers')
            ->select("customer_number")
            ->distinct()
            ->get();

        $activeCustomers = [];

        foreach ($customers as $key => $value) {
            $transactions = \DB::table('transactions')
                ->where('account_number', '=', $value->customer_number)
                ->orderby('created_at', 'desc')
                ->get();
            $bal = 0;
            $customerAccounts = [];

            foreach ($transactions as $key => $value) {
                $bal += ($value->liters * $value->unit_price) - $value->amount_paid;
                if ($value->transaction_code == "DOB") {
                    $bal += $value->balance;
                    $bal -= $value->amount_paid;
                }
                $customerAccount = [
                    "customer_name" => $value->customer_name,
                    "transaction_date" => $value->transaction_date,
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
                $today = Carbon::today();
                $monthsPassed = $today->diffInMonths($customerAccounts[$lastElementIndex]['transaction_date']);
                if ($monthsPassed < 6) {
                    $activeCustomers[] = $customerAccounts[$lastElementIndex];
                }
            }
        }

        $keys = [
            "customer_name",
            "transaction_date",
            "narration",
            "liters",
            "unit_price",
            "cost",
            "amount_paid",
            "balance"
        ];


        if (request()->has('export')) {
            $headers = [
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="export.csv"',
                'Expires' => '0',
                'Pragma' => 'public'
            ];
            $fileName = "export.csv";
            $output = fopen(storage_path($fileName), 'w') or die("Can't open php://output");
            fputcsv($output, $keys);
            foreach ($activeCustomers as $key => $value) {
                fputcsv($output, $value);
            }
            fclose($output) or die("Can't close php://output");
            return response()->download(storage_path('export.csv'), 'export.csv', ['header' => $headers]);
        }


        $page = \Illuminate\Support\facades\Input::get('page', 1);
        $perPage = 25;
        $offset = ($page * $perPage) - $perPage;
        if (!empty($activeCustomers)) {
            $activeCustomers = collect($activeCustomers);
        } else {
            $activeCustomers = [];
            $activeCustomers = collect($activeCustomers);
        }

        $activeCustomers = new LengthAwarePaginator(
            array_slice(
                $activeCustomers->toArray(),
                $offset,
                $perPage,
                true
            ),
            count($activeCustomers),
            $perPage,
            $page,
            [
                'path' => $request->url(),
                'query' => $request->query()
            ]
        );
        return view("reports.activeCustomersReport")->with([

            "customerAccounts" => $activeCustomers
        ]);
    }


    public function displayInactiveCustomersReport(Request $request)
    {
        $customers = \DB::table('customers')
            ->select("customer_number")
            ->distinct()
            ->get();

        $customerAccounts = [];
        $inactiveCustomers = [];

        foreach ($customers as $key => $value) {
            $transactions = \DB::table('transactions')
                ->where('account_number', '=', $value->customer_number)
                ->orderby('created_at', 'desc')
                ->get();
            $bal = 0;
            $inactiveCustomers = [];

            foreach ($transactions as $key => $value) {
                //  if($value->posted_from!="AddNewBankAccount"){}
                $bal += ($value->liters * $value->unit_price) - $value->amount_paid;
                if ($value->transaction_code == "DOB") {
                    $bal += $value->balance;
                    $bal -= $value->amount_paid;
                }

                $customerAccount = [
                    "customer_name" => $value->customer_name,
                    "transaction_date" => $value->transaction_date,
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
                $today = Carbon::today();
                $monthsPassed = $today->diffInMonths($customerAccounts[$lastElementIndex]['transaction_date']);
                if ($monthsPassed >= 6) {
                    $inactiveCustomers[] = $customerAccounts[$lastElementIndex];
                }
            }
        }

        $keys = [
            "customer_name",
            "transaction_date",
            "narration",
            "liters",
            "unit_price",
            "cost",
            "amount_paid",
            "balance"
        ];


        if (request()->has('export')) {
            $headers = [
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="export.csv"',
                'Expires' => '0',
                'Pragma' => 'public'
            ];
            $fileName = "export.csv";
            $output = fopen(storage_path($fileName), 'w') or die("Can't open php://output");
            fputcsv($output, $keys);
            foreach ($inactiveCustomers as $key => $value) {
                fputcsv($output, $value);
            }
            fclose($output) or die("Can't close php://output");
            return response()->download(storage_path('export.csv'), 'export.csv', ['header' => $headers]);
        }


        $page = \Illuminate\Support\facades\Input::get('page', 1);
        $perPage = 25;
        $offset = ($page * $perPage) - $perPage;
        $inactiveCustomers = collect($inactiveCustomers);

        $inactiveCustomers = new LengthAwarePaginator(
            array_slice(
                $inactiveCustomers->toArray(),
                $offset,
                $perPage,
                true
            ),
            count($inactiveCustomers),
            $perPage,
            $page,
            [
                'path' => $request->url(),
                'query' => $request->query()
            ]
        );
        return view("reports.inactiveCustomersReport")->with([

            "customerAccounts" => $inactiveCustomers
        ]);
    }
    public function displayDailyCashTransactionReport(Request $request)
    {
        $accountNumber = "";

        $customers = \DB::table('transactions')
            ->select("account_number")
            ->distinct()
            ->get();


        if (request()->has('dateQuery')) {
            $date = request('dateQuery');
        }
        foreach ($customers as $key => $value) {
            if (request()->has('dateQueryEnd')) {
                $endDate = request('dateQueryEnd');
                $transactions = \DB::table('transactions')
                    ->whereBetween('transaction_date', [$date, $endDate])
                    ->orderby('created_at', 'asc')
                    ->get();
            } else {
                $transactions = \DB::table('transactions')
                    ->orderby('created_at', 'asc')
                    ->get();
            }
            $customerAccounts = [];

            $r = Repayment::all();
            $lr = $r->pop();
            if (!isset($lr)) {
                $bal = 0;
            } else {
                $bal = $lr->current_balance;
                $customerAccount = [
                                "transaction_date" => $lr->transaction_date,
                                "name" => "Current Cash Balance",
                                "payment_mode" => "N\A",
                                "payment_status" => "N\A",
                                "bank_name" => "N\A",
                                "narration"=>"Current Cash Balance",
                                "amount_paid" =>0,
                                "balance" => $bal
                            ];
                $customerAccounts[] = $customerAccount;
            }

             

            foreach ($transactions as $key => $value) {
                //$bal += ($value->liters * $value->unit_price) - $value->amount_paid;

                if ($value->narration != "shortage") {
                    $name = "";
                    if ($value->customer_name != "") {
                        $name = $value->customer_name;
                    }
                    if ($value->supplier_name != "") {
                        $name = $value->supplier_name;
                    }
                    if ($value->posted_from == "CustomerPayment") {
                        if ($value->payment_mode == "Cash") {
                            $bal += $value->amount_paid;

                            $customerAccount = [
                                "transaction_date" => $value->transaction_date,
                                "name" => $name,
                                "payment_mode" => $value->payment_mode,
                                "payment_status" => $value->payment_status,
                                "bank_name" => $value->bank_name,
                                "narration"=>$value->narration,
                                "amount_paid" => $value->amount_paid,
                                "balance" => $bal
                            ];
                            $customerAccounts[] = $customerAccount;
                        }
                    }
                    if ($value->posted_from == "AcceptPayment") {
                        $name = "";
                        if ($value->customer_name != "") {
                            $name = $value->customer_name;
                        }
                        if ($value->supplier_name != "") {
                            $name = $value->supplier_name;
                        }
                        if ($value->payment_mode == "Cash") {
                            $bal += $value->amount_paid;

                            $customerAccount = [
                                "transaction_date" => $value->transaction_date,
                                "name" => $name,
                                "payment_mode" => $value->payment_mode,
                                "payment_status" => $value->payment_status,
                                "bank_name" => $value->bank_name,
                                "narration"=>$value->narration,
                                "amount_paid" => $value->amount_paid,
                                "balance" => $bal
                            ];
                            $customerAccounts[] = $customerAccount;
                        }
                    }
                    if ($value->posted_from == "Withdrawal") {
                        $name = $value->bank_name;
                        $bal += $value->amount_paid;

                        $customerAccount = [
                            "transaction_date" => $value->transaction_date,
                            "name" => $name,
                            "payment_mode" => "Withdrawal",
                            "payment_status" => $value->payment_status,
                            "bank_name" => $value->bank_name,
                            "narration"=>$value->narration,
                            "amount_paid" => $value->amount_paid,
                            "balance" => $bal
                        ];
                        $customerAccounts[] = $customerAccount;
                    }
                    if ($value->posted_from == "OtherExpensePayment") {
                        $bal -= $value->amount_paid;
                        $name = "";
                        if ($value->customer_name != "") {
                            $name = $value->customer_name;
                        }
                        if ($value->supplier_name != "") {
                            $name = $value->supplier_name;
                        }
         
                        $customerAccount = [
                            "transaction_date" => $value->transaction_date,
                            "name" => $name,
                            "payment_mode" => $value->payment_mode,
                            "payment_status" => $value->payment_status,
                            "bank_name" => $value->bank_name,
                            "narration"=>$value->narration,
                            "amount_paid" => $value->amount_paid,
                            "balance" => $bal
                        ];
                        $customerAccounts[] = $customerAccount;
                    }
                    if ($value->posted_from == "InvoicesEnd" && $value->payment_mode == "Cash") {
                        $bal -= $value->amount_paid;
                        $name = "";
                        if ($value->customer_name != "") {
                            $name = $value->customer_name;
                        }
                        if ($value->supplier_name != "") {
                            $name = $value->supplier_name;
                        }
         
                        $customerAccount = [
                            "transaction_date" => $value->transaction_date,
                            "name" => $name,
                            "payment_mode" => $value->payment_mode,
                            "payment_status" => $value->payment_status,
                            "bank_name" => $value->bank_name,
                            "narration"=>$value->narration,
                            "amount_paid" => $value->amount_paid,
                            "balance" => $bal
                        ];
                        $customerAccounts[] = $customerAccount;
                    }
           
                    if ($value->posted_from == "Deposit") {
                        $bal -= $value->amount_paid;
                        $name = $value->bank_name;

         
                        $customerAccount = [
                            "transaction_date" => $value->transaction_date,
                            "name" => $name,
                            "payment_mode" => "Deposit",
                            "payment_status" => $value->payment_status,
                            "bank_name" => $value->bank_name,
                            "narration"=>$value->narration,
                            "amount_paid" => $value->amount_paid,
                            "balance" => $bal
                        ];
                        $customerAccounts[] = $customerAccount;
                    }
                    if ($value->posted_from == "SupplierPayment") {
                        $name = "";
                        if ($value->customer_name != "") {
                            $name = $value->customer_name;
                        }
                        if ($value->supplier_name != "") {
                            $name = $value->supplier_name;
                        }
                        if ($value->payment_mode == "Cash") {
                            $bal -= $value->amount_paid;
                            $customerAccount = [
                                "transaction_date" => $value->transaction_date,
                                "name" => $name,
                                "payment_mode" => $value->payment_mode,
                                "payment_status" => $value->payment_status,
                                "bank_name" => $value->bank_name,
                                "narration"=>$value->narration,
                                "amount_paid" => $value->amount_paid,
                                "balance" => $bal
                            ];
                            $customerAccounts[] = $customerAccount;
                        }
                    }
                    if ($value->posted_from == "Refunds") {
                        $name = "";
                        if ($value->customer_name != "") {
                            $name = $value->customer_name;
                        }
                        if ($value->supplier_name != "") {
                            $name = $value->supplier_name;
                        }
                        if ($value->payment_mode == "Cash") {
                            $bal -= $value->amount_paid;
                            $customerAccount = [
                                "transaction_date" => $value->transaction_date,
                                "name" => $name,
                                "payment_mode" => $value->payment_mode,
                                "payment_status" => $value->payment_status,
                                "bank_name" => $value->bank_name,
                                "narration"=>$value->narration,
                                "amount_paid" => $value->amount_paid,
                                "balance" => $bal
                            ];
                            $customerAccounts[] = $customerAccount;
                        }
                    }
                }
            }
        }
        $keys = [
            "transaction_date",
            "name",
            "payment_mode",
            "payment_status",
            "bank_name",
            "narration",
            "amount",
            "balance"
        ];


        if (request()->has('export')) {
            $headers = [
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="export.csv"',
                'Expires' => '0',
                'Pragma' => 'public'
            ];
            $fileName = "export.csv";
            $output = fopen(storage_path($fileName), 'w') or die("Can't open php://output");
            fputcsv($output, $keys);
            foreach ($customerAccounts as $key => $value) {
                fputcsv($output, $value);
            }
            fclose($output) or die("Can't close php://output");
            return response()->download(storage_path('export.csv'), 'export.csv', ['header' => $headers]);
        }


        $page = \Illuminate\Support\facades\Input::get('page', 1);
        $perPage = 25;
        $offset = ($page * $perPage) - $perPage;
        if (!empty($customerAccounts)) {
            $customerAccounts = collect($customerAccounts);
        } else {
            $customerAccounts = [];
            $customerAccounts = collect($customerAccounts);
        }

        $customerAccounts = new LengthAwarePaginator(
            array_slice(
                $customerAccounts->toArray(),
                $offset,
                $perPage,
                true
            ),
            count($customerAccounts),
            $perPage,
            $page,
            [
                'path' => $request->url(),
                'query' => $request->query()
            ]
        );
        return view("reports.dailyCashTransactionReport")->with([

            "customerAccounts" => $customerAccounts
        ]);
    }
    public function displayOtherExpensePaymentSummaryReport(Request $request)
    {
        if (request()->has('dateQuery')) {
            $date = request('dateQuery');
        }

        $expenses = \DB::table('expenses')
            ->select("expense_category")
            ->distinct()
            ->get();

        $expensePayments = [];
        $total = 0;
        foreach ($expenses as $key => $value) {
            if (request()->has('dateQueryEnd')) {
                $endDate = request('dateQueryEnd');
                $transactions = \DB::table('transactions')
                    ->where("expense_category", "=", $value->expense_category)
                    ->whereBetween('transaction_date', [$date, $endDate])
                    ->orderby('created_at', 'asc')
                    ->get();
            } else {
                $transactions = \DB::table('transactions')
                    ->where("expense_category", "=", $value->expense_category)
                    ->orderby('created_at', 'asc')
                    ->get();
            }
            $sum = $transactions->sum("amount_paid");
            $total += $sum;
            $expensePayment = [
                "expense_category" => $value->expense_category,
                "amount_paid" => $sum
            ];
            $expensePayments[] = $expensePayment;
        }


        $keys = [
            "expense_category",
            "amount"
        ];


        if (request()->has('export')) {
            $headers = [
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="export.csv"',
                'Expires' => '0',
                'Pragma' => 'public'
            ];
            $fileName = "export.csv";
            $output = fopen(storage_path($fileName), 'w') or die("Can't open php://output");
            fputcsv($output, $keys);
            foreach ($expensePayments as $key => $value) {
                fputcsv($output, $value);
            }
            fclose($output) or die("Can't close php://output");
            return response()->download(storage_path('export.csv'), 'export.csv', ['header' => $headers]);
        }



        $page = \Illuminate\Support\facades\Input::get('page', 1);
        $perPage = 25;
        $offset = ($page * $perPage) - $perPage;

        if (!empty($expensePayments)) {
            $expensePayments = collect($expensePayments);
        } else {
            $expensePayments = [];
            $expensePayments = collect($expensePayments);
        }
        $expensePayments = new LengthAwarePaginator(
            array_slice(
                $expensePayments->toArray(),
                $offset,
                $perPage,
                true
            ),
            count($expensePayments),
            $perPage,
            $page,
            [
                'path' => $request->url(),
                'query' => $request->query()
            ]
        );


        return view("reports.otherExpensePaymentSummaryReport")->with([

            "expensePayments" => $expensePayments,
            "total" => $total
        ]);
    }
    public function displayOtherExpensePaymentDetailsReport(Request $request)
    {
        if (request()->has('dateQuery')) {
            $date = request('dateQuery');
        }
        if (request()->has('expense_category')) {
            $expenseCategory = request('expense_category');
        }
        $expenses = \DB::table('transactions')
            ->select("expense_category")
            ->distinct()
            ->get();
        $expensePayments = [];

        if (!request()->has('expense_category')) {
            $transactions = [];
        } elseif (request()->has('dateQueryEnd')) {
            $endDate = request('dateQueryEnd');
            $transactions = \DB::table('transactions')
                ->where("expense_category", "=", $expenseCategory)
                ->whereBetween('transaction_date', [$date, $endDate])
                ->orderby('created_at', 'asc')
                ->get();
        } else {
            $transactions = \DB::table('transactions')
                ->where("expense_category", "=", $expenseCategory)
                ->orderby('created_at', 'asc')
                ->get();
        }

        if ((request('expense_category') == "All" || request('expense_category') == "")  && !request()->has('dateQueryEnd')) {
            $transactions = \DB::table('transactions')
                ->where("expense_category", "!=", "")
                ->orderby('created_at', 'asc')
                ->get();
        }
        
        if ((request('expense_category')=="All"|| request('expense_category') == "") && request()->has('dateQueryEnd')) {
            $endDate = request('dateQueryEnd');
            $transactions = \DB::table('transactions')
                ->where("expense_category", "!=", "")
                ->whereBetween('transaction_date', [$date, $endDate])
                ->orderby('created_at', 'asc')
                ->get();
        }
        foreach ($transactions as $key => $value) {
            $name = "";
            if ($value->customer_name != "") {
                $name = $value->customer_name;
            }
            if ($value->supplier_name != "") {
                $name = $value->supplier_name;
            }
            $expensePayment = [
                "transaction_date" => $value->transaction_date,
                "expense_category" => $value->expense_category,
                "narration" => $value->narration,
                "payment_mode" => $value->payment_mode,
                "bank_name" => $value->bank_name,
                "name"=>$name,
                "account_number" => $value->account_number,
                "invoice_number" => $value->invoice_number,
                "cheque_number" => $value->cheque_number,
                "amount_paid" => $value->amount_paid

            ];
            $expensePayments[] = $expensePayment;
        }

        $keys = [
            "transaction date",
            "expense_category",
            "narration",
            "payment_mode",
            "bank_name",
            "name",
            "account_number",
            "invoice_number",
            "cheque_number",
            "amount"
        ];


        if (request()->has('export')) {
            $headers = [
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="export.csv"',
                'Expires' => '0',
                'Pragma' => 'public'
            ];
            $fileName = "export.csv";
            $output = fopen(storage_path($fileName), 'w') or die("Can't open php://output");
            fputcsv($output, $keys);
            foreach ($expensePayments as $key => $value) {
                fputcsv($output, $value);
            }
            fclose($output) or die("Can't close php://output");
            return response()->download(storage_path('export.csv'), 'export.csv', ['header' => $headers]);
        }



        $page = \Illuminate\Support\facades\Input::get('page', 1);
        $perPage = 25;
        $offset = ($page * $perPage) - $perPage;

        if (!empty($expensePayments)) {
            $expensePayments = collect($expensePayments);
        } else {
            $expensePayments = [];
            $expensePayments = collect($expensePayments);
        }
        $expensePayments = new LengthAwarePaginator(
            array_slice(
                $expensePayments->toArray(),
                $offset,
                $perPage,
                true
            ),
            count($expensePayments),
            $perPage,
            $page,
            [
                'path' => $request->url(),
                'query' => $request->query()
            ]
        );


        return view("reports.otherExpensePaymentDetailsReport")->with([

            "expensePayments" => $expensePayments
        ]);
    }

    public function displayBankStatementReport(Request $request)
    {
        if (request()->has('dateQuery')) {
            $date = request('dateQuery');
        }

        $banks = \DB::table('bank_accounts')
            ->select("bank_name")
            ->distinct()
            ->get();


        $bankTransactions = [];
        $bankBal = 0;
        $transactions = [];
        if (request()->has('bank_name') && request('bank_name') != "") {
            $bankname = request('bank_name');

            if (request()->has('dateQueryEnd')) {
                $endDate = request('dateQueryEnd');
                $transactions = \DB::table('transactions')
                    ->where("bank_name", "=", $bankname)
                    ->whereBetween('transaction_date', [$date, $endDate])
                    ->orderby('created_at', 'asc')
                    ->get();
            } else {
                $transactions = \DB::table('transactions')
                    ->where("bank_name", "=", $bankname)
                    ->orderby('created_at', 'asc')
                    ->get();
            }
        }

        foreach ($transactions as $key => $value) {
            $name = "";
            if ($value->narration != "shortage" && $value->narration != "Stock Supplied") {
                if ($value->narration == "Current Balance Forward") {
                    $bankBal += $value->amount_paid;
                }
                $amount = 0;
                switch ($value->posted_from) {
                    case "AddNewBankAccount":
                        $name = $value->bank_name;
                        $bankBal += $value->balance;
                        $bankTransaction = [
                            "transaction_date" => $value->transaction_date,
                            "bank_name" => $value->bank_name,
                            "cheque_number" => $value->cheque_number,
                            "narration" => $value->narration,
                            "customer_name" => $name,
                            "amount" => $value->amount_paid,
                            "balance" => $bankBal
                        ];
                        $bankTransactions[] = $bankTransaction;
                        break;
                    case "AcceptPayment":
                        $name = $value->customer_name;
                        $bankBal += $value->amount_paid;
                        $bankTransaction = [
                            "transaction_date" => $value->transaction_date,
                            "bank_name" => $value->bank_name,
                            "cheque_number" => $value->cheque_number,
                            "narration" => $value->narration,
                            "customer_name" => $name,
                            "amount" => $value->amount_paid,
                            "balance" => $bankBal
                        ];
                        $bankTransactions[] = $bankTransaction;
                        break;
                    case "CustomerPayment":
                        $name = $value->customer_name;
                        $bankBal += $value->amount_paid;
                        $bankTransaction = [
                            "transaction_date" => $value->transaction_date,
                            "bank_name" => $value->bank_name,
                            "cheque_number" => $value->cheque_number,
                            "narration" => $value->narration,
                            "customer_name" => $name,
                            "amount" => $value->amount_paid,
                            "balance" => $bankBal
                        ];
                        $bankTransactions[] = $bankTransaction;
                        break;
                    case "Deposit":
                        $name = $value->bank_name;
                        $bankBal += $value->amount_paid;
                        $bankTransaction = [
                            "transaction_date" => $value->transaction_date,
                            "bank_name" => $value->bank_name,
                            "cheque_number" => $value->cheque_number,
                            "narration" => $value->narration,
                            "customer_name" => $name,
                            "amount" => $value->amount_paid,
                            "balance" => $bankBal
                        ];
                        $bankTransactions[] = $bankTransaction;
                        break;
                    case "SupplierPayment":
                        $name = $value->supplier_name;
                        $bankBal -= $value->amount_paid;
                        $bankTransaction = [
                            "transaction_date" => $value->transaction_date,
                            "bank_name" => $value->bank_name,
                            "cheque_number" => $value->cheque_number,
                            "narration" => $value->narration,
                            "customer_name" => $name,
                            "amount" => $value->amount_paid,
                            "balance" => $bankBal
                        ];
                        $bankTransactions[] = $bankTransaction;
                        break;
                            case "InvoicesEnd":
                        $name = $value->supplier_name;
                        $bankBal -= $value->amount_paid;
                        $bankTransaction = [
                            "transaction_date" => $value->transaction_date,
                            "bank_name" => $value->bank_name,
                            "cheque_number" => $value->cheque_number,
                            "narration" => $value->narration,
                            "customer_name" => $name,
                            "amount" => $value->amount_paid,
                            "balance" => $bankBal
                        ];
                        $bankTransactions[] = $bankTransaction;
                        break;
                
                    case "Withdrawal":
                        $name = $value->bank_name;
                        $bankBal -= $value->amount_paid;
                        $bankTransaction = [
                            "transaction_date" => $value->transaction_date,
                            "bank_name" => $value->bank_name,
                            "cheque_number" => $value->cheque_number,
                            "narration" => $value->narration,
                            "customer_name" => $name,
                            "amount" => $value->amount_paid,
                            "balance" => $bankBal
                        ];
                        $bankTransactions[] = $bankTransaction;
                        break;
                                case "BankTransfer":
                        $name = $value->bank_name;
                        $bankBal += $value->amount_paid;
                        $bankTransaction = [
                            "transaction_date" => $value->transaction_date,
                            "bank_name" => $value->bank_name,
                            "cheque_number" => $value->cheque_number,
                            "narration" => $value->narration,
                            "customer_name" => $name,
                            "amount" => $value->amount_paid,
                            "balance" => $bankBal
                        ];
                        $bankTransactions[] = $bankTransaction;
                        break;
                        case "Refunds":
                        $name = $value->bank_name;
                        $bankBal -= $value->amount_paid;
                        $bankTransaction = [
                            "transaction_date" => $value->transaction_date,
                            "bank_name" => $value->bank_name,
                            "cheque_number" => $value->cheque_number,
                            "narration" => $value->narration,
                            "customer_name" => $name,
                            "amount" => $value->amount_paid,
                            "balance" => $bankBal
                        ];
                        $bankTransactions[] = $bankTransaction;
                        break;
                    default:
                        break;

                }
            }
        }

        $keys = [
            "DATE",
            "BANK NAME",
            "CHEQUE NUMBER",
            "NARRATION",
            "ACCOUNT NAME",
            "AMOUNT",
            "BALANCE"
        ];


        if (request()->has('export')) {
            $headers = [
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="export.csv"',
                'Expires' => '0',
                'Pragma' => 'public'
            ];
            $fileName = "export.csv";
            $output = fopen(storage_path($fileName), 'w') or die("Can't open php://output");
            fputcsv($output, $keys);
            foreach ($bankTransactions as $key => $value) {
                fputcsv($output, $value);
            }
            fclose($output) or die("Can't close php://output");
            return response()->download(storage_path('export.csv'), 'export.csv', ['header' => $headers]);
        }



        $page = \Illuminate\Support\facades\Input::get('page', 1);
        $perPage = 25;
        $offset = ($page * $perPage) - $perPage;

        if (!empty($bankTransactions)) {
            $bankTransactions = collect($bankTransactions);
        } else {
            $bankTransactions = [];
            $bankTransactions = collect($bankTransactions);
        }
        $bankTransactions = new LengthAwarePaginator(
            array_slice(
                $bankTransactions->toArray(),
                $offset,
                $perPage,
                true
            ),
            count($bankTransactions),
            $perPage,
            $page,
            [
                'path' => $request->url(),
                'query' => $request->query()
            ]
        );


        return view("reports.bankStatementReport")->with([

            "bankTransactions" => $bankTransactions
        ]);
    }
    public function displayBankStatementDetailsReport(Request $request)
    {
        $banks = \DB::table('bank_accounts')
            ->select("bank_name")
            ->distinct()
            ->get();

        $bankTransactions = [];
        

        foreach ($banks as $key => $value) {
            $transactions = \DB::table('transactions')
                ->where("bank_name", "=", $value->bank_name)
                ->orderby('created_at', 'asc')
                ->get();
            $bankBal = 0;
            $bankTrans = [];

            foreach ($transactions as $key => $value) {
                $name = "";
                if ($value->narration != "shortage" && $value->narration != "Stock Supplied") {
                    if ($value->narration == "Current Balance Forward") {
                        $bankBal += $value->amount_paid;
                    }

                    $amount = 0;
                    switch ($value->posted_from) {
                        case "AddNewBankAccount":
                            $name = $value->bank_name;
                            $bankBal += $value->balance;
                            $bankTransaction = [
                                "transaction_date" => $value->transaction_date,
                                "bank_name" => $value->bank_name,
                                "balance" => $bankBal
                            ];
                            $bankTrans[] = $bankTransaction;
                            break;
                        case "AcceptPayment":
                            $name = $value->customer_name;
                            $bankBal += $value->amount_paid;
                            $bankTransaction = [
                                "transaction_date" => $value->transaction_date,
                                "bank_name" => $value->bank_name,
                                "balance" => $bankBal
                            ];
                            $bankTrans[] = $bankTransaction;
                            break;
                        case "CustomerPayment":
                            $name = $value->customer_name;
                            $bankBal += $value->amount_paid;
                            $bankTransaction = [
                                "transaction_date" => $value->transaction_date,
                                "bank_name" => $value->bank_name,
                                "balance" => $bankBal
                            ];
                            $bankTrans[] = $bankTransaction;
                            break;
                        case "Deposit":
                            $name = $value->bank_name;
                            $bankBal += $value->amount_paid;
                            $bankTransaction = [
                                "transaction_date" => $value->transaction_date,
                                "bank_name" => $value->bank_name,
                                "balance" => $bankBal
                            ];
                            $bankTrans[] = $bankTransaction;
                            break;
                        case "SupplierPayment":
                            $name = $value->supplier_name;
                            $bankBal -= $value->amount_paid;
                            $bankTransaction = [
                                "transaction_date" => $value->transaction_date,
                                "bank_name" => $value->bank_name,
                                "balance" => $bankBal
                            ];
                            $bankTrans[] = $bankTransaction;
                            break;
                        case "Withdrawal":
                            $name = $value->bank_name;
                            $bankBal -= $value->amount_paid;
                            $bankTransaction = [
                                "transaction_date" => $value->transaction_date,
                                "bank_name" => $value->bank_name,
                                "balance" => $bankBal
                            ];
                            $bankTrans[] = $bankTransaction;
                            break;
                             case "BankTransfer":
                        $name = $value->bank_name;
                        $bankBal += $value->amount_paid;
                        $bankTransaction = [
                            "transaction_date" => $value->transaction_date,
                            "bank_name" => $value->bank_name,
                            "balance" => $bankBal
                        ];
                        $bankTrans[] = $bankTransaction;
                        break;
                      case "Refunds":
                        $name = $value->bank_name;
                        $bankBal -= $value->amount_paid;
                        $bankTransaction = [
                            "transaction_date" => $value->transaction_date,
                            "bank_name" => $value->bank_name,
                            "balance" => $bankBal
                        ];
                        $bankTrans[] = $bankTransaction;
                        break;
                        default:
                            break;


                    }
                }
            }
            if (!empty($bankTrans)) {
                $lastElementIndex = count($bankTrans) - 1;
                $bankTransactions[] = $bankTrans[$lastElementIndex];
            }
        }
        $keys = [
            "LAST TRANSACTION DATE",
            "BANK NAME",
            "CURRENT BALANCE"
        ];
        if (request()->has('export')) {
            $headers = [
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="export.csv"',
                'Expires' => '0',
                'Pragma' => 'public'
            ];
            $fileName = "export.csv";
            $output = fopen(storage_path($fileName), 'w') or die("Can't open php://output");
            fputcsv($output, $keys);
            foreach ($bankTransactions as $key => $value) {
                fputcsv($output, $value);
            }
            fclose($output) or die("Can't close php://output");
            return response()->download(storage_path('export.csv'), 'export.csv', ['header' => $headers]);
        }



        $page = \Illuminate\Support\facades\Input::get('page', 1);
        $perPage = 25;
        $offset = ($page * $perPage) - $perPage;

        if (!empty($bankTransactions)) {
            $bankTransactions = collect($bankTransactions);
        } else {
            $bankTransactions = [];
            $bankTransactions = collect($bankTransactions);
        }
        $bankTransactions = new LengthAwarePaginator(
            array_slice(
                $bankTransactions->toArray(),
                $offset,
                $perPage,
                true
            ),
            count($bankTransactions),
            $perPage,
            $page,
            [
                'path' => $request->url(),
                'query' => $request->query()
            ]
        );


        return view("reports.bankStatementDetailsReport")->with([

            "bankTransactions" => $bankTransactions
        ]);
    }
}
