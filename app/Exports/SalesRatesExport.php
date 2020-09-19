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

class SalesRatesExport implements \Maatwebsite\Excel\Concerns\FromCollection ,\Maatwebsite\Excel\Concerns\WithHeadings
{
    public function collection()
    {
        return \App\SalesRate::all();
    }
    public function headings(): array
    {
     return [
        "ID",
        "Selling Rate",
        "Product Type",
        "Entry By",
        "Modified By",
        "Created At",
        "Updated At"
        
      ];
    }
}