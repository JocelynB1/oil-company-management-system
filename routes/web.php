<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', 'HomeController@index')->name('home');

Auth::routes();

Route::group(['middleware' => ['auth']], function () {
    Route::get('reports/displayOtherExpensePaymentDetailsReport', 'DisplayRecordsController@displayOtherExpensePaymentDetailsReport')->name('reports.otherExpensePaymentDetailsReport');
    Route::get('reports/displayBankStatementDetailsReport', 'DisplayRecordsController@displayBankStatementDetailsReport')->name('reports.bankStatementDetailsReport');
    Route::get('reports/displayBankStatementReport', 'DisplayRecordsController@displayBankStatementReport')->name('reports.bankStatementReport');
    Route::get('reports/displayOtherExpensePaymentSummaryReport', 'DisplayRecordsController@displayOtherExpensePaymentSummaryReport')->name('reports.otherExpensePaymentSummaryReport');
    Route::get('reports/displayDailyCashTransactionReport', 'DisplayRecordsController@displayDailyCashTransactionReport')->name('reports.dailyCashTransactionReport');
    Route::get('reports/displayInactiveCustomersReport', 'DisplayRecordsController@displayInactiveCustomersReport')->name('reports.inactiveCustomersReport');
    Route::get('reports/displayActiveCustomersReport', 'DisplayRecordsController@displayActiveCustomersReport')->name('reports.activeCustomersReport');
    Route::get('reports/displayCostOfGoodsPurchased', 'DisplayRecordsController@displayCostOfGoodsPurchased')->name('reports.costOfGoodsPurchased');
    Route::get('reports/displayCreditorsReport', 'DisplayRecordsController@displayCreditorsReport')->name('reports.creditorsReport');
    Route::get('reports/displayDebtorsReport', 'DisplayRecordsController@displayDebtorsReport')->name('reports.debtorsReport');
    Route::get('reports/displaySuppliersStatementReport', 'DisplayRecordsController@displaySuppliersStatementReport')->name('reports.suppliersStatementReport');
    Route::get('reports/displaySupplierAccountReport', 'DisplayRecordsController@displaySupplierAccountReport')->name('reports.suppliersAccountReport');
    Route::get('reports/displayCustomersStatementReport', 'DisplayRecordsController@displayCustomersStatementReport')->name('reports.customersStatementReport');
    Route::get('reports/displayCustomersAccountReport', 'DisplayRecordsController@displayCustomersAccountReport')->name('reports.customersAccountReport');
    Route::get('reports/dailySalesReport', 'DisplayRecordsController@displayDailySalesReport')->name('reports.dailySalesReport');
      
    
    Route::get('getTransactionDateRange', 'AjaxController@getTransactionDateRange')->name("getTransactionDateRange");
    Route::get('getSupplierNameByProductType/{producttype}', 'AjaxController@getSupplierNameByProductType')->name("getSupplierNameByProductType");
    Route::get('getAccountNumberFromBankName/{bankname}', 'AjaxController@getAccountNumberFromBankName')->name("getAccountNumberFromBankName");
    Route::get('getCustomerCurrentBalance/{customerNumber}', 'AjaxController@getCustomerCurrentBalance')->name("getCustomerCurrentBalance");
    Route::get('getSupplierCurrentBalance/{supplierNumber}', 'AjaxController@getSupplierCurrentBalance')->name("getSupplierCurrentBalance");
    Route::get('getExpensePaymentDateRangeByCategory/{expenseRange}', 'AjaxController@getExpensePaymentDateRangeByCategory')->name("getExpensePaymentDateRangeByCategory");
    Route::get('getExpensePaymentDateRange', 'AjaxController@getExpensePaymentDateRange')->name("getExpensePaymentDateRange");
    Route::get('getTransactionDateRangeOfBanks/{bankname}', 'AjaxController@getTransactionDateRangeOfBanks')->name("getTransactionDateRangeOfBanks");
    Route::get('getTransactionDateRangeOfSupplier/{supplierNumber}', 'AjaxController@getTransactionDateRangeOfSupplier')->name("getTransactionDateRangeOfSupplier");
    Route::get('getTransactionDateRangeOfCustomer/{customerNumber}', 'AjaxController@getTransactionDateRangeOfCustomer')->name("getTransactionDateRangeOfCustomer");
    Route::get('getDailySalesRecord', 'AjaxController@getDailySalesRecord')->name("getDailySalesRecord");
    Route::get('getSumOfSupplierProducts/{supplier}', 'AjaxController@getSumOfSupplierProducts')->name('getSumOfSupplierProducts');
    Route::get('getCustomerIdFromName/{name}', 'AjaxController@getCustomerIdFromName')->name('getCustomerIdFromName');
    Route::get('getGuestNameAndId', 'AjaxController@getGuestNameAndId')->name("getGuestNameAndId");
    Route::get('getEmployeeNameAndId', 'AjaxController@getEmployeeNameAndId')->name("getEmployeeNameAndId");
    Route::get('getSupplierNameAndId', 'AjaxController@getSupplierNameAndId')->name("getSupplierNameAndId");
    Route::get('getCustomerNameAndId', 'AjaxController@getCustomerNameAndId')->name("getCustomerNameAndId");
    Route::get('getProductSalesPerDate', 'AjaxController@getProductSalesPerDate')->name("getProductSalesPerDate");
    Route::get('getOutstandingInventory', 'AjaxController@getOutstandingInventory')->name("getOutstandingInventory");
    Route::get('getProductSalesFromTotalLitres', 'AjaxController@getProductSalesFromTotalLitres')->name("getProductSalesFromTotalLitres");
    Route::get('getProductSalesPerType', 'AjaxController@getProductSalesPerType')->name("getProductSalesPerType");
    Route::get('getSalesRate/{productType}', 'AjaxController@getSalesRate');
    Route::get('getSupplierDetailsFromSupplierNumber/{supplier_number}', 'AjaxController@getSupplierDetailsFromSupplierNumber')->name("getSupplierDetailsFromSupplierNumber");

    Route::delete('destroyTransactions/{transaction}', 'DestroyController@destroyTransactions');
    Route::delete('destroyDeposits/{deposit}', 'DestroyController@destroyDeposits');
    Route::delete('destroyExpensePayments/{expensepayment}', 'DestroyController@destroyExpensePayments');
    Route::delete('destroyExpenses/{expense}', 'DestroyController@destroyExpenses');
    Route::delete('destroyInventories/{inventory}', 'DestroyController@destroyInventories');
    Route::delete('destroyPaymentModes/{paymentmode}', 'DestroyController@destroyPaymentModes');
    Route::delete('destroyProducts/{product}', 'DestroyController@destroyProducts');
    Route::delete('destroyPurchases/{purchase}', 'DestroyController@destroyPurchases');
    Route::delete('destroyRefunds/{refund}', 'DestroyController@destroyRefunds');
    Route::delete('destroySales/{sale}', 'DestroyController@destroySales');
    Route::delete('destroySalesRates/{salerates}', 'DestroyController@destroySalesRates');
    Route::delete('destroyStatuses/{status}', 'DestroyController@destroyStatuses');
    Route::delete('destroySuppliers/{z}', 'DestroyController@destroySuppliers');
    Route::delete('destroyTransactionCodes/{transcode}', 'DestroyController@destroyTransactionCodes');
    Route::delete('destroyWithdrawals/{withdrawal}', 'DestroyController@destroyWithdrawals');


    Route::get('editTransactions/{transaction}', 'EditController@editTransactions');
    Route::get('editDeposits/{deposit}', 'EditController@editDeposits');
    Route::get('editExpensePayments/{expensepayment}', 'EditController@editExpensePayments');
    Route::get('editExpenses/{expense}', 'EditController@editExpenses');
    Route::get('editInventories/{inventory}', 'EditController@editInventories');
    Route::get('editPaymentModes/{paymentmode}', 'EditController@editPaymentModes');
    Route::get('editProducts/{product}', 'EditController@editProducts');
    Route::get('editPurchases/{purchase}', 'EditController@editPurchases');
    Route::get('editRefunds/{refund}', 'EditController@editRefunds');
    Route::get('editSales/{sale}', 'EditController@editSales');
    Route::get('editSalesRates/{salesrate}', 'EditController@editSalesRates');
    Route::get('editStatuses/{status}', 'EditController@editStatuses');
    Route::get('editSuppliers/{supplier}', 'EditController@editSuppliers');
    Route::get('editTransactionCodes/{transcode}', 'EditController@editTransactionCodes');
    Route::get('editWithdrawals/{wwithdrawal}', 'EditController@editWithdrawals');


    Route::patch('updateTransactions/{transactions}', 'UpdateController@updateTransactions');
    Route::patch('updateExpensePayments/{expensepayment}', 'UpdateController@updateExpensePayments');
    Route::patch('updateExpenses/{expenses}', 'UpdateController@updateExpenses');
    Route::patch('updateDeposits/{deposit}', 'UpdateController@updateDeposits');
    Route::patch('updateInventories/{inventory}', 'UpdateController@updateInventories');
    Route::patch('updatePaymentModes/{paymentmode}', 'UpdateController@updatePaymentModes');
    Route::patch('updateProducts/{product}', 'UpdateController@updateProducts');
    Route::patch('updatePurchases/{purchase}', 'UpdateController@updatePurchases');
    Route::patch('updateRefunds/{refund}', 'UpdateController@updateRefunds');
    Route::patch('updateSales/{sale}', 'UpdateController@updateSales');
    Route::patch('updateSalesRates/{salerate}', 'UpdateController@updateSalesRates');
    Route::patch('updateSuppliers/{supplier}', 'UpdateController@updateSuppliers');
    Route::patch('updateTransactionCodes/{transcode}', 'UpdateController@updateTransactionCodes');
    Route::patch('updateWithdrawals/{withdrawal}', 'UpdateController@updateWithdrawals');


    Route::get('exportCostOfGoodsPurchased', 'ExcelController@exportCostOfGoodsPurchased');
    Route::get('exportBankAccounts', 'ExcelController@exportBankAccounts');
    Route::get('exportBanks', 'ExcelController@exportBanks');
    Route::get('exportGuests', 'ExcelController@exportGuests');
    Route::get('exportEmployees', 'ExcelController@exportEmployees');
    Route::get('exportCustomers', 'ExcelController@exportCustomers');
    Route::get('exportDeposits', 'ExcelController@exportDeposits');
    Route::get('exportExpensePayments', 'ExcelController@exportExpensePayments');
    Route::get('exportExpenses', 'ExcelController@exportExpenses');
    Route::get('exportInventories', 'ExcelController@exportInventories');
    Route::get('exportPaymentModes', 'ExcelController@exportPaymentModes');
    Route::get('exportProducts', 'ExcelController@exportProducts');
    Route::get('exportPurchases', 'ExcelController@exportPurchases');
    Route::get('exportRefunds', 'ExcelController@exportRefunds');
    Route::get('exportSales', 'ExcelController@exportSales');
    Route::get('exportSalesRates', 'ExcelController@exportSalesRates');
    Route::get('exportStatuses', 'ExcelController@exportStatuses');
    Route::get('exportSuppliers', 'ExcelController@exportSuppliers');
    Route::get('exportTransactions', 'ExcelController@exportTransactions');
    Route::get('exportTransCodes', 'ExcelController@exportTransCodes');
    Route::get('exportWithdrawals', 'ExcelController@exportWithdrawals');













    Route::get('displayrecords/exportFromView', 'ExcelController@exportBankAccountsFromView');



    Route::get('displayrecords/invoices', 'DisplayRecordsController@displayInvoices')->name('displayrecords.invoices');
    Route::get('displayrecords/accountantsales', 'DisplayRecordsController@displayAccountantSales')->name('displayrecords.accountantsales');
    Route::get('displayrecords/transactions', 'DisplayRecordsController@displayTransactions')->name('displayrecords.transactions');
    Route::get('displayrecords/withdrawals', 'DisplayRecordsController@displayWithdrawals')->name('displayrecords.withdrawals');
    Route::get('displayrecords/transcodes', 'DisplayRecordsController@displayTransCodes')->name('displayrecords.transcodes');
    Route::get('displayrecords/supplier', 'DisplayRecordsController@displaySuppliers')->name('displayrecords.suppliers');
    Route::get('displayrecords/statuses', 'DisplayRecordsController@displayStatuses')->name('displayrecords.statuses');
    Route::get('displayrecords/salesrates', 'DisplayRecordsController@displaySalesRates')->name('displayrecords.salesrates');
    Route::get('displayrecords/refunds', 'DisplayRecordsController@displayRefunds')->name('displayrecords.refunds');
    Route::get('displayrecords/sales', 'DisplayRecordsController@displaySales')->name('displayrecords.sales');
    Route::get('displayrecords/purchases', 'DisplayRecordsController@displayPurchases')->name('displayrecords.purchases');
    Route::get('displayrecords/products', 'DisplayRecordsController@displayProducts')->name('displayrecords.products');
    Route::get('displayrecords/paymentmodes', 'DisplayRecordsController@displayPaymentModes')->name('displayrecords.paymentmodes');
    Route::get('displayrecords/inventories', 'DisplayRecordsController@displayInventories')->name('displayrecords.inventories');
    Route::get('displayrecords/expensepayments', 'DisplayRecordsController@displayExpensePayments')->name('displayrecords.expensepayments');
    Route::get('displayrecords/expenses', 'DisplayRecordsController@displayExpenses')->name('displayrecords.expenses');
    Route::get('displayrecords/deposits', 'DisplayRecordsController@displayDeposits')->name('displayrecords.deposits');
    Route::get('displayrecords/guests', 'DisplayRecordsController@displayGuests')->name('displayrecords.guests');
    Route::get('displayrecords/employees', 'DisplayRecordsController@displayEmployees')->name('displayrecords.employees');
    Route::get('displayrecords/customers', 'DisplayRecordsController@displayCustomers')->name('displayrecords.customers');
    Route::get('displayrecords/bankaccounts', 'DisplayRecordsController@displayBankAccounts')->name('displayrecords.bankaccounts');
    Route::get('displayrecords/banks', 'DisplayRecordsController@displayBanks')->name('displayrecords.banks');
    Route::resource("invoices", "InvoiceController");
    Route::resource("currentcashbalances", "CurrentCashBalanceController");
    Route::resource('customerpayments', 'CustomerPaymentController');
    Route::resource('manualposting', 'ManualPostingController');
    Route::any('accountantsales/search', 'AccountantSalesController@search')->name('accountantsales.search');
    Route::resource('accountantsales', 'AccountantSalesController');
    Route::any('outputmanagersales/search', 'OutputManagerSalesController@search')->name('outputmanagersales.search');
    Route::resource('outputmanagersales', 'OutputManagerSalesController');
    Route::any('refunds/search', 'RefundController@search')->name('refunds.search');
    Route::resource('refunds', "RefundController");
    Route::any('createnewusers/search', 'CreateNewUsersController@search')->name('createnewusers.search');
    Route::resource('createnewusers', "CreateNewUsersController");
    Route::get('/home', 'HomeController@index')->name('home');
    Route::any('sales/search', 'SalesController@search')->name('banks.search');
    Route::resource('sales', "SalesController");
    Route::any('paymentMode/search', 'PaymentModeController@search')->name('paymentMode.search');
    Route::resource('paymentMode', "PaymentModeController");
    Route::any('product/search', 'ProductController@search')->name('product.search');
    Route::resource('product', "ProductController");
    Route::any('suppliers/search', 'SupplierController@search')->name('suppliers.search');
    Route::resource('suppliers', 'SupplierController');
    Route::any('customers/search', 'CustomerController@search')->name('customers.search');
    Route::resource('banktransfers', 'BankTransfersController');
    Route::resource('custombalances', 'CustomBalanceController');
    Route::resource('customers', 'CustomerController');
    Route::resource('guests', 'GuestController');
    Route::resource('employees', 'WorkerController');
    Route::any('banks/table', 'BankController@table')->name('banks.table');
    Route::any('banks/search', 'BankController@search')->name('banks.search');
    Route::resource('banks', 'BankController');
    Route::any('bankAccounts/search', 'BankAccountsController@search')->name('bankAccounts.search');
    Route::resource("bankAccounts", "BankAccountsController");
    Route::any('transcodes/search', 'TransCodeController@search')->name('transcodes.search');
    Route::resource("transcodes", "TransCodeController");
    Route::any('inventory/search', 'InventoryController@search')->name('inventory.search');
    Route::resource('inventory', 'InventoryController');
    Route::any('salesrate/search', 'SalesRateController@search')->name('salesrate.search');
    Route::resource('salesrate', 'SalesRateController');
    Route::any('sales/search', 'SalesController@search')->name('sales.search');
    Route::resource('sales', 'SalesController');
    Route::resource('tasks', 'TasksController');
    Route::any('withdrawals/search', 'WithdrawalsController@search')->name('withdrawals.search');
    Route::resource('withdrawals', 'WithdrawalsController');
    Route::any('status/search', 'StatusController@search')->name('status.search');
    Route::resource('status', 'StatusController');
    Route::any('deposits/search', 'DepositController@search')->name('deposits.search');
    Route::resource('deposits', 'DepositController');
    Route::any('expenses/search', 'ExpenseController@search')->name('expenses.search');
    Route::resource('expenses', 'ExpenseController');
    Route::any('expensepayments/search', 'ExpensePaymentsController@search')->name('expensepayments.search');
    Route::resource('expensepayments', 'ExpensePaymentsController');
    Route::any('purchases/search', 'PurchaseController@search')->name('purchases.search');
    Route::resource('purchases', 'PurchaseController');
});
