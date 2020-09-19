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

class DestroyController extends Controller
{
        /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyDeposits($id)
    {
        $deposits = Deposit::findOrFail($id);

        $deposits->delete();
    
        Session::flash('flash_message', 'Record successfully deleted!');
    
        return redirect()->back();

    }
    public function destroyExpensePayments($id)
    {
        
        $expensepayments = ExpensePayment::findOrFail($id);

        $expensepayments->delete();
    
        Session::flash('flash_message', 'Record successfully deleted!');
    
        return redirect()->back();

    }
      /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyExpenses($id)
    {
        $expenses = Expense::findOrFail($id);

        $expenses->delete();
    
        Session::flash('flash_message', 'Record successfully deleted!');
    
        return redirect()->back();

    }
  /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyInventories($id)
    {
        $inventory = Inventory::findOrFail($id);

        $inventory->delete();
    
        Session::flash('flash_message', 'Inventory successfully deleted!');
    
        return redirect()->back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyPaymentModes($id)
    {
        $paymentMode = PaymentMode::findOrFail($id);

        $paymentMode->delete();
    
        Session::flash('flash_message', 'Record successfully deleted!');
    
        return redirect()->back();
    }
     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyProducts($id)
    {
        $product = Product::findOrFail($id);

        $product->delete();
    
        Session::flash('flash_message', 'Record successfully deleted!');
    
        return redirect()->back();
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyPurchases($id)
    {
        $purchases = Purchase::findOrFail($id);

        $purchases->delete();
    
        Session::flash('flash_message', 'Record successfully deleted!');
    
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyRefunds($id)
    {
        $refunds = Refund::findOrFail($id);

        $refunds->delete();
    
        Session::flash('flash_message', 'Record successfully deleted!');
    
        return redirect()->back();
    }
       /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroySales($id)
    {
        $sale = Sale::findOrFail($id);

        $sale->delete();
    
        Session::flash('flash_message', 'Record successfully deleted!');
    
        return redirect()->back();
    }
 
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroySalesRates($id)
    {
        $salesrate = SalesRate::findOrFail($id);

        $salesrate->delete();
    
        Session::flash('flash_message', 'Record successfully deleted!');
    
        return redirect()->back();
    }
    public function destroyStatuses($id)
    {
        $status = Status::findOrFail($id);

        $status->delete();
    
        Session::flash('flash_message', 'Record successfully deleted!');
    
        return redirect()->back();

    }

/**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroySuppliers($id)
    {
        $supplier = Supplier::findOrFail($id);

        $supplier->delete();
    
        Session::flash('flash_message', 'Record successfully deleted!');
    
        return redirect()->back();
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyTransactionCodes($id)
    {
        $transcodes = TransCode::findOrFail($id);

        $transcodes->delete();
    
        Session::flash('flash_message', 'Record successfully deleted!');
    
        return redirect()->back();
  
    }
      /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyWithdrawals($id)
    {

        $withdrawals = Withdrawal::findOrFail($id);

        $withdrawals->delete();
    
        Session::flash('flash_message', 'Record successfully deleted!');
    
        return redirect()->back();
    
    }
 /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyTransactions($id)
    {

        $transactions = Transaction::findOrFail($id);

        $transactions->delete();
    
        Session::flash('flash_message', 'Record successfully deleted!');
    
        return redirect()->back();
    
    }
  
}
