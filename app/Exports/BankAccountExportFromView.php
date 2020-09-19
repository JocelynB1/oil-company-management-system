<?php
namespace App\Exports;
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
//use Excel;
//use Maatwebsite\Excel\Facades\Excel;
//use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class BankAccountExportFromView implements \Maatwebsite\Excel\Concerns\FromView
{
    public function view(): \Illuminate\Contracts\View\View
        {
        return view('displayrecords.bankaccounts', [
            'bankaccounts' => \App\BankAccount::all()
        ]);
    }

}