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

class PurchasesExport implements \Maatwebsite\Excel\Concerns\FromCollection ,\Maatwebsite\Excel\Concerns\WithHeadings
{
    public function collection()
    {
        return \App\Purchase::all();
    }
    public function headings(): array
    {
     return [
        "ID",
        "Supplier Name",
        "Product Type",
        "Truck Number",
        "Driver Name",
        "Litres Loaded",
        "Shortages In Litres",
        "Net Loading In Litres",
        "Price Per Litre",
        "Total Cost",
        "Amount Paid",
        "Balance",
        "Payment Mode",
        "Name Of Bank",
        "Cheque Number",
        "Narration",
        "Transaction Code",
        "Transaction Date",
        "Created At",
        "Updated At"
        
       ];
    }
}