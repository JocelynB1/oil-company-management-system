<?php

namespace App\Http\Controllers;

use App\Bank;
use App\BankAccount;
use App\Customer;
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
use App\TransCode;
use App\Withdrawal;
use App\Transaction;
use App\Worker;
use App\Guest;
//use Excel;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Contracts\View\View;
use App\Exports\BankAccountsExport;
use App\Exports\EmployeesExport;
use App\Exports\GuestExport;
use App\Exports\BanksExport;
use App\Exports\SalesExport;
use App\Exports\DepositsExport;
use App\Exports\CustomersExport;
use App\Exports\ExpensePaymentsExport;
use App\Exports\BankAccountExportFromView;
use App\Exports\ExpensesExport;
use App\Exports\InventoriesExport;
use App\Exports\PaymentModesExport;
use App\Exports\ProductsExport;
use App\Exports\PurchasesExport;
use App\Exports\RefundsExport;
use App\Exports\SalesRatesExport;
use App\Exports\StatusesExport;
use App\Exports\SuppliersExport;
use App\Exports\TransCodesExport;
use App\Exports\TransactionsExport;
use App\Exports\WithdrawalsExport;
use App\Exports\CostOfGoodsPurchasedExport;
use App\Exports\BankStatementExport;


use Session;


use Illuminate\Http\Request;

class ExcelController extends Controller
{
    public function exportBankAccountsFromView()
    {
        return Excel::download(new BankAccountExportFromView, 'bankaccounts.xlsx');
    }
    /**
     * export a file in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function exportBankAccounts()
    {
        $format=request("format");
        return Excel::download(new BankAccountsExport, 'bankaccounts.'.$format);
    }
    /**
      * export a file in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @return \Illuminate\Http\Response
      */
    public function exportSales()
    {
        $format=request("format");
        return Excel::download(new SalesExport, 'sales.'.$format);
    }
    /**
         * export a file in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
    public function exportBanks()
    {
        $format=request("format");
        return Excel::download(new BanksExport, 'banks.'.$format);
    }
    /**
     * export a file in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function exportCustomers()
    {
        $format=request("format");
        return Excel::download(new CustomersExport, 'customers.'.$format);
    }
    /**
     * export a file in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function exportEmployees()
    {
        $format=request("format");
        return Excel::download(new EmployeesExport, 'employees.'.$format);
    }
    /**
     * export a file in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function exportGuests()
    {
        $format=request("format");
        return Excel::download(new GuestExport, 'guests.'.$format);
    }
    /**
     * export a file in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function exportDeposits()
    {
        $format=request("format");
        return Excel::download(new DepositsExport, 'deposits.'.$format);
    }
    /**
     * export a file in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function exportExpensePayments()
    {
        $format=request("format");
        return Excel::download(new ExpensePaymentsExport, 'expensepayments.'.$format);
    }
    /**
     * export a file in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function exportExpenses()
    {
        $format=request("format");
        return Excel::download(new ExpensesExport, 'expenses.'.$format);
    }
    /**
     * export a file in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function exportInventories()
    {
        $format=request("format");
        return Excel::download(new InventoriesExport, 'inventories.'.$format);
    }
    /**
     * export a file in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function exportPaymentModes()
    {
        $format=request("format");
        return Excel::download(new PaymentModesExport, 'paymentmodes.'.$format);
    }
    /**
     * export a file in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function exportProducts()
    {
        $format=request("format");
        return Excel::download(new ProductsExport, 'products.'.$format);
    }
    /**
     * export a file in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function exportPurchases()
    {
        $format=request("format");
        return Excel::download(new PurchasesExport, 'purchases.'.$format);
    }
    /**
     * export a file in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function exportRefunds()
    {
        $format=request("format");
        return Excel::download(new RefundsExport, 'refunds.'.$format);
    }
    /**
     * export a file in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function exportSalesRates()
    {
        $format=request("format");
        return Excel::download(new SalesRatesExport, 'salesrates.'.$format);
    }
    /**
     * export a file in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function exportStatuses()
    {
        $format=request("format");
        return Excel::download(new StatusesExport, 'statuses.'.$format);
    }
    /**
     * export a file in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function exportSuppliers()
    {
        $format=request("format");
        return Excel::download(new SuppliersExport, 'suppliers.'.$format);
    }
    /**
     * export a file in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function exportTransactions()
    {
        $format=request("format");
        return Excel::download(new TransactionsExport, 'transactions.'.$format);
    }
    /**
     * export a file in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function exportTransCodes()
    {
        $format=request("format");
        return Excel::download(new TransCodesExport, 'transcodes.'.$format);
    }
    /**
     * export a file in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function exportWithdrawals()
    {
        $format=request("format");
        return Excel::download(new WithdrawalsExport, 'withdrawals.'.$format);
    }
    /**
     * export a file in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function exportCostOfGoodsPurchased()
    {
        $format = request("format");
        return Excel::download(new CostOfGoodsPurchasedExport, 'supplierPayments.' . $format);
    }
    /**
     * export a file in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function exportBankStatement()
    {
        $format = request("format");
        return Excel::download(new BankStatementExport, 'bankTransactions.' . $format);
    }
}
