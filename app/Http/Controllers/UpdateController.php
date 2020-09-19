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

class UpdateController extends Controller
{
    private $confirmationMessage;
    public function __construct(){

        $confirmationMessage="Record successfully updated!";
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    protected function updateRecord(Request $request,$model){
        $input=$request->all();
        $model->update($input);

    }
    protected function displayConfirmationAndRedirect($confirmationMessage=null){
       if($confirmationMessage==null){
           $confirmationMessage=$this->confirmationMessage;
       }
        Session::flash('flash_message', "{$confirmationMessage}");
        return redirect()->back();
    }
    protected function processUpdate(Request $request,$model,$confirmationMessage=null){
        $this->updateRecord($request,$model);
        $this->displayConfirmationAndRedirect($confirmationMessage);
    }
    public function updateDeposits(Request $request, $id)
    {
        $model = Deposit::findOrFail($id);
        $this->validate($request,[
            'transaction_date'=>'required',
            'bank_name'=>'required',
            'account_number'=>'required',
            'transaction_code'=>'required',
            'amount'=>'required',
            'narration'=>'required',
            'created_by'=>'required'
        ]);
        $this->processUpdate($request,$model);
    }

     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateExpensePayments(Request $request, $id)
    {
        $model = ExpensePayment::findOrFail($id);
        
        $this->validate($request,[
            'transaction_date'=>'required',
            'expense_category'=>'required',
            'invoice_number'=>'required',
            'amount'=>'required|numeric',
            'narration'=>'required',
            'created_by'=>'required',
            'payment_to'=>'required',
            'bank_name'=>'required',
            'payment_mode'=>'required'
        ]);
       $this->processUpdate($request,$model);

        }
         /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
        public function updateExpenses(Request $request, $id)
        {
            $model = ExpensePayment::findOrFail($id);
            $this->validate($request,[
                'expense_category'=>'required|unique:expenses,expense_category'
              ]);
           $this->processUpdate($request,$model);

    
            return redirect()->back();
        }
         /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateInventories(Request $request, $id)
    {
        $inventory = Inventory::findOrFail($id);
        $this->validate($request,[
            'supplier_name'=>'required',
            'truck_number'=>'required',
            'driver_name'=>'required',
            'driver_phone'=>'required',
            'litres_loaded'=>'required|numeric',
            'created_by'=>'required',
            'modified_by'=>'required'
        ]);
        $input=$request->all();
        $inventory->update($input);

        Session::flash('flash_message', 'Record updated!');

        return redirect()->back();
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePaymentModes(Request $request, $id)
    {
        $model = PaymentMode::findOrFail($id);
        $this->validate($request,[
            'payment_mode'=>'required',
            'payment_mode'=>'unique:payment_modes,payment_mode',
            'created_by'=>'required',
            'modified_by'=>'required'
        ]);
        $input=$request->all();
        $model->update($input);

        Session::flash('flash_message', 'Record successfully updated!');

        return redirect()->back();
 
    }
/**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateProducts(Request $request, $id)
    {
        $model = Product::findOrFail($id);
        
        $this->validate($request,[
            'product_type'=>'required',
            'product_type'=>'unique:products,product_type',
            'created_by'=>'required',
            'modified_by'=>'required'
        ]);
        $input=$request->all();
        $model->update($input);

        Session::flash('flash_message', 'Record successfully added!');

        return redirect()->back();
     }
       /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePurchases(Request $request, $id)
    {
        $purchases = Purchase::findOrFail($id);
        $this->validate($request,[
            'supplier_name'=>'required',
            'product_type'=>'required',
            'truck_number'=>'required',
            'driver_name'=>'required',
            'litres_loaded'=>'required|numeric',
            'shortages_in_litres'=>'required',
            'net_loading_in_litres'=>'required',
            'price_per_litre'=>'required|numeric',
            'total_cost'=>'required|numeric',
            'amount_paid'=>'required|numeric',
            'balance'=>'required|numeric',
            'payment_mode'=>'required',
            'bank_name'=>'required',
            'cheque_number'=>'required',
            'narration'=>'required',
            'transaction_code'=>'required',
            'transaction_date'=>'required'
        ]);
        $input=$request->all();
        $purchases->update($input);

        Session::flash('flash_message', 'Record successfully Updated!');

        return redirect()->back();
    }
     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateRefunds(Request $request, $id)
    {
        $Refund = Refund::findOrFail($id);
        $this->validate($request,[
            'transaction_date'=>'required',
            'customer_name'=>'required',
            'account_number'=>'required',
            'refund_amount'=>'required|numeric',
            'payment_mode'=>'required',
            'created_by'=>'required',
            'transaction_code'=>'required',
            'approval_status'=>'required'
        ]);
        $input=$request->all();
        $Refund->update($input);

        Session::flash('flash_message', 'Record successfully added!');

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateSales(Request $request, $id)
    {
         
        $Sale = Sale::findOrFail($id);
        $this->validate($request,[
            'sales_date'=>'required',
            'customer_name'=>'required',
            'customer_number'=>'required',
            'litres_pumped'=>'required',
            'product_type'=>'required',
            'shortages'=>'required',
            'unit_price'=>'required|numeric',
            'supplier_name'=>'required',
            'stage_reached'=>'required',
            'payment_mode'=>'required',
            'bank_name'=>'required',
            'description'=>'required',
            'discount_rate'=>'required',
            'cash_discount_allowed'=>'required',
            'amount_paid'=>'required',
            'balance'=>'required',
            'transaction_code'=>'required'
           ]);
           $request->total_cost=$request->litres_pumped*$request->unit_price
           -($request->discount_rate*$request->litres_pumped)-$request->cash_discount_allowed;

           $input=$request->all();
                 $Sale->update($input);

        Session::flash('flash_message', 'Record successfully updated!');

        return redirect()->back();
    }
/**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateSalesRates(Request $request, $id)
    {
        $SalesRate = SalesRate::findOrFail($id);
        $this->validate($request,[
            'selling_rate'=>'required|numeric',
            'product_type'=>'required',
            'created_by'=>'required',
            'modified_by'=>'required'
        ]);
     
        $input=$request->all();
        $SalesRate->update($input);

        Session::flash('flash_message', 'Record successfully updated!');

        return redirect()->back();

    }
/**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateStatuses(Request $request, $id)
    {
        $model = Status::findOrFail($id);
        
        $this->validate($request,[
            'description'=>'required',
            'created_by'=>'required'
        ]);
        $input=$request->all();
        $model->update($input);

        Session::flash('flash_message', 'Record successfully updated!');

        return redirect()->back();
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateSuppliers(Request $request, $id)
    {
        $model = Supplier::findOrFail($id);
        $this->validate($request,[
            'supplier_number'=>'required',
            'supplier_name'=>'required',
            'company_name'=>'required',
            'phone_number'=>'required',
            'created_by'=>'required',
            'modified_by'=>'required',
        ]);
        $input=$request->all();
        $model->update($input);
        Session::flash('flash_message', 'Record successfully updated!');

        return redirect()->back();


    }
       /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateTransactionCodes(Request $request, $id)
    {
        $model = TransCode::findOrFail($id);
     
        $this->validate($request,[
            'transaction_code'=>'required',
            'transaction_code'=>'unique:transaction_codes,transaction_code',
            'transaction_description'=>'required',
            'created_by'=>'required'
        ]);
        $input=$request->all();
        $model->update($input);

        Session::flash('flash_message', 'Record successfully added!');

        return redirect()->back();
       

    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateWithdrawals(Request $request, $id)
    {
        $model =Withdrawal::findOrFail($id);
        
        $this->validate($request,[
            'transaction_date'=>'required',
            'bank_name'=>'required',
            'account_number'=>'required',
            'transaction_code'=>'required',
            'amount'=>'required|numeric',    
            'narration'=>'required',
            'created_by'=>'required'    
     
        ]);
        $input=$request->all();
        $model->update($input);

        Session::flash('flash_message', 'Record successfully updated!');

        return redirect()->back();
    }
 /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateTransactions(Request $request, $id)
    {
        $model =Transaction::findOrFail($id);
        
        $this->validate($request,[
            
            "trn_ref_no"=>"Reference Number",
            "transaction_date"=>"Transaction Date",
            "product_type"=>"Product Type",
            "liters"=>"Liters",
            "rate"=>"Rate",
            "total_cost"=>"Total Cost",
            "amount_paid"=>"Amount Paid",
            "balance"=>"Balance",
            "narration"=>"Narration",
            "transaction_code"=>"Transaction code",
            "customer_name"=>"Customer Name",
            "shortages"=>"Shortages",
            "supplier_name"=>"Supplier Name",
            "unit_price"=>"Unit Price",
            "payment_mode"=>"Payment Mode",
            "bank_name"=>"Bank Name",
            "cheque_number"=>"Cheque Number",
            "payment_status"=>"Payment Status",
            "discount_rate"=>"Discount Rate",
            "cash_discount_allowed"=>"Cash Discount Allowed",
            "approval_status"=>"Approval Status",
            "approval_date"=>"Approval Date",
            "created_by"=>"Created By",
            "created_at"=>"Created At",
            "updated_at"=>"Updated At"     
        ]);
        $input=$request->all();
        $model->update($input);

        Session::flash('flash_message', 'Record successfully updated!');

        return redirect()->back();
    }


}