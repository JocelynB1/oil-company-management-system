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
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PaymentModesExport implements \Maatwebsite\Excel\Concerns\FromCollection ,\Maatwebsite\Excel\Concerns\WithHeadings
{
    public function collection()
    {
        return \App\PaymentMode::all();
    }
    public function headings(): array
    {
     return [
         "ID",
         "Payment Mode",
         "Modified By",
         "Entry By",
         "Created At",
         "Updated At"
        ];
    }
}