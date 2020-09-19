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

use Session;

use Illuminate\Http\Request;

class EditController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editDeposits($id)
    {
        $deposits = Deposit::findOrFail($id);

//        Session::flash('Model Message', 'Record successfully deleted!');
  //      Session::overlay('Model Message');
        return view('deposits.edit')->with(['deposits'=>$deposits]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editExpensePayments($id)
    {
        $expensepayments = ExpensePayment::findOrFail($id);

        return view('expensepayments.edit')->with(['expensepayments'=>$expensepayments]);
    }
     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editExpenses($id)
    {
        $expenses = Expense::findOrFail($id);

        return view('expenses.edit')->with(['expenses'=>$expenses]);
    }
 /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editInventories($id)
    {
        
        $inventory = Inventory::findOrFail($id);

        return view('inventory.edit')->with(['inventory'=>$inventory]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editPaymentModes($id)
    {
        $paymentMode = PaymentMode::findOrFail($id);

        return view('paymentMode.edit')->with(['paymentMode'=>$paymentMode]);

    }
/**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editProducts($id)
    {
        $product = Product::findOrFail($id);

        return view('product.edit')->with(['product'=>$product]);

    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editPurchases($id)
    {
        $purchases = Purchase::findOrFail($id);

        return view('purchases.edit')->with(['purchases'=>$purchases]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editRefunds($id)
    {
        $refunds = Refund::findOrFail($id);

        return view('refunds.edit')->with(['refunds'=>$refunds]);
    }
/**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editSales($id)
    {
        
        $accountantsales = Sale::findOrFail($id);

        return view('accountantsales.edit')->with(['accountantsales'=>$accountantsales]);	
    }
/**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editSalesRates($id)
    {
        $salesrate = SalesRate::findOrFail($id);

        return view('salesrate.edit')->with(['salesrate'=>$salesrate]);

    }
     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editStatuses($id)
    {
        $status = Status::findOrFail($id);

        return view('status.edit')->with(['status'=>$status]);

    }
/**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editSuppliers($id)
    {
        $supplier = Supplier::findOrFail($id);

        return view('suppliers.edit')->with(['supplier'=>$supplier]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editTransactionCodes($id)
    {
        $transcodes = TransCode::findOrFail($id);

        return view('transcodes.edit')->with(['transcodes'=>$transcodes]);
  
    }

   /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editWithdrawals($id)
    {
        $withdrawals = Withdrawal::findOrFail($id);

        return view('withdrawals.edit')->with(['withdrawals'=>$withdrawals]);

    }


   /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editTransactions($id)
    {
        $transactions = Transaction::findOrFail($id);

        return view('transactions.edit')->with(['transactions'=>$transactions]);

    }

}
