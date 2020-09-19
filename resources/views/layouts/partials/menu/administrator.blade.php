
<li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Inventory
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="{{ route('inventory.create') }}">Add Stock</a>
          <div class="dropdown-divider"></div>
      
        </div>
      </li>

<li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Sales Rate
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="{{ route('salesrate.create') }}">Add Daily Rate</a>
          <div class="dropdown-divider"></div>
      
        </div>
      </li>

<li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Accounts
        </a> 
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="{{ route('displayrecords.accountantsales') }}">Accept Customer Payment</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="{{ route('deposits.create') }}">Add Bank Deposit</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="{{ route('expensepayments.create') }}">Other Expense Payment</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="{{ route('purchases.create') }}">Supplier Payment</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="{{ route('withdrawals.create') }}">Withdrawal At Bank</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="{{ route('refunds.create') }}">Refunds</a>
          <div class="dropdown-divider"></div>
          <!--
          <a class="dropdown-item" href="{{ route('manualposting.create') }}">Manual Posting</a>
          <div class="dropdown-divider"></div> !-->
          <a class="dropdown-item" href="{{ route('customerpayments.create') }}">Customer Payment</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="{{ route('invoices.create') }}">Create Invoice</a>
          <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="{{ route('displayrecords.invoices') }}">Process Invoices</a>
          <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{ route('custombalances.create') }}">Add Custom Balance</a>
          <div class="dropdown-divider"></div>
      <a class="dropdown-item" href="{{ route('banktransfers.create') }}">Bank Transfer</a>
          <div class="dropdown-divider"></div>
   
        </div>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
   Output Manager Sales 
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="{{ route('outputmanagersales.create') }}">Process Sales</a>
          <div class="dropdown-divider"></div>
        </div>
      </li>

      
      <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Display records 
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="{{ route('displayrecords.banks') }}">Display Bank Records</a>
          <div class="dropdown-divider"></div>         
            <a class="dropdown-item" href="{{ route('displayrecords.bankaccounts') }}">Display Bank Account Records</a>          
          <div class="dropdown-divider"></div>         
            <a class="dropdown-item" href="{{ route('displayrecords.customers') }}">Display Customer Records</a>                    
          <div class="dropdown-divider"></div>   
          <a class="dropdown-item" href="{{ route('displayrecords.employees') }}">Display Staff Records</a>                    
          <div class="dropdown-divider"></div> 
         <!--  <a class="dropdown-item" href="{{ route('displayrecords.guests') }}">Display Guest Records</a>                    
          <div class="dropdown-divider"></div> !-->     
            <a class="dropdown-item" href="{{ route('displayrecords.deposits') }}">Display Deposit Records</a>                            
          <div class="dropdown-divider"></div>         
            <a class="dropdown-item" href="{{ route('displayrecords.expenses') }}">Display Expense Records</a>                            
          <div class="dropdown-divider"></div>         
            <a class="dropdown-item" href="{{ route('displayrecords.expensepayments') }}">Display Expense Payments Records</a>                            
          <div class="dropdown-divider"></div>         
            <a class="dropdown-item" href="{{ route('displayrecords.inventories') }}">Display Stock Records</a>                            
          <div class="dropdown-divider"></div>         
            <a class="dropdown-item" href="{{ route('displayrecords.paymentmodes') }}">Display Payment Modes</a>                            
          <div class="dropdown-divider"></div>         
            <a class="dropdown-item" href="{{ route('displayrecords.products') }}">Display Product Records</a>                            
          <div class="dropdown-divider"></div>         
            <a class="dropdown-item" href="{{ route('displayrecords.purchases') }}">Display Purchase Records</a>                            
          <div class="dropdown-divider"></div>         
            <a class="dropdown-item" href="{{ route('displayrecords.refunds') }}">Display Refund Records</a>                                        
          <div class="dropdown-divider"></div>         
            <a class="dropdown-item" href="{{ route('displayrecords.sales') }}">Display Sale Records</a>                                        
          <div class="dropdown-divider"></div>         
            <a class="dropdown-item" href="{{ route('displayrecords.salesrates') }}">Display Sale Rate Records</a>                                        
          <div class="dropdown-divider"></div>         
            <a class="dropdown-item" href="{{ route('displayrecords.statuses') }}">Display Status Records</a>                                        
          <div class="dropdown-divider"></div>         
            <a class="dropdown-item" href="{{ route('displayrecords.suppliers') }}">Display Supplier Records</a>                                        
          <div class="dropdown-divider"></div>         
            <a class="dropdown-item" href="{{ route('displayrecords.transcodes') }}">Display Transaction Code Records</a>                                        
          <div class="dropdown-divider"></div>         
            <a class="dropdown-item" href="{{ route('displayrecords.withdrawals') }}">Display Withdrawal Records</a>                                        
          <div class="dropdown-divider"></div>         
            <a class="dropdown-item" href="{{ route('displayrecords.transactions') }}">Display Transaction Records</a>                                        
            <div class="dropdown-divider"></div>
        
          </div>
        </li>

<li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Set Up 
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="{{ route('banks.create') }}">Add Banks</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="{{ route('bankAccounts.create') }}">Add Bank Accounts</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="{{ route('currentcashbalances.create') }}">Add Current Cash Balance</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="{{ route('customers.create') }}">Add Customers</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="{{ route('employees.create') }}">Add Other Users</a>
          <div class="dropdown-divider"></div>
       <!--   <a class="dropdown-item" href="{{ route('guests.create') }}">Add Guests</a>
          <div class="dropdown-divider"></div> !-->
          <a class="dropdown-item" href="{{ route('product.create') }}">Add Product</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="{{ route('suppliers.create') }}">Add Suppliers</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="{{ route('transcodes.create') }}">Add Transaction Codes</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="{{ route('paymentMode.create') }}">Add Payment Modes</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="{{ route('status.create') }}">Add Payment Status</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="{{ route('expenses.create') }}">Add Expenses Category</a>
          <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{ route('custombalances.create') }}">Add Custom Balance</a>
          <div class="dropdown-divider"></div>
        </div>
      </li>
      
<li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Reports
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="{{ route('reports.dailySalesReport') }}">Daily Sales Report</a>          
          <div class="dropdown-divider"></div>          
          <a class="dropdown-item" href="{{ route('reports.customersStatementReport') }}">Customer Statement Report</a>          
          <div class="dropdown-divider"></div>          
          <a class="dropdown-item" href="{{ route('reports.suppliersStatementReport') }}">Supplier Statement Report</a>          
          <div class="dropdown-divider"></div>         
          <a class="dropdown-item" href="{{ route('reports.customersAccountReport') }}">Customers Account Report</a>          
          <div class="dropdown-divider"></div>          
          <a class="dropdown-item" href="{{ route('reports.suppliersAccountReport') }}">Supplier Account Report</a>          
          <div class="dropdown-divider"></div>         
          <a class="dropdown-item" href="{{ route('reports.debtorsReport') }}">Debtors Report</a>          
          <div class="dropdown-divider"></div>         
          <a class="dropdown-item" href="{{ route('reports.creditorsReport') }}">Creditors Report</a>          
          <div class="dropdown-divider"></div>  
               <a class="dropdown-item" href="{{ route('displayrecords.inventories') }}">Display Stock Records</a>                            
          <div class="dropdown-divider"></div>  
          <!--        
          <a class="dropdown-item" href="{{ route('reports.costOfGoodsPurchased') }}">Cost Of Goods Purchased</a>          
          <div class="dropdown-divider"></div>    
          <a class="dropdown-item" href="{{ route('reports.activeCustomersReport') }}">Active Customers Report</a>
          <div class="dropdown-divider"></div>          
          <a class="dropdown-item" href="{{ route('reports.inactiveCustomersReport') }}">Inactive Customers Report</a>
          <div class="dropdown-divider"></div>   
           !-->      
          
           <a class="dropdown-item" href="{{ route('reports.dailyCashTransactionReport') }}">Daily Cash Transaction Report</a>                                        
            <div class="dropdown-divider"></div>            
               <a class="dropdown-item" href="{{ route('reports.otherExpensePaymentSummaryReport') }}">Other Expense Payment Summary Report</a>                                        
            <div class="dropdown-divider"></div>             
               <a class="dropdown-item" href="{{ route('reports.otherExpensePaymentDetailsReport') }}">Other Expense Payment Details Report</a>                                        
            <div class="dropdown-divider"></div>             
               <a class="dropdown-item" href="{{ route('reports.bankStatementReport') }}">Bank Statement Report</a>                                        
            <div class="dropdown-divider"></div>             
             <a class="dropdown-item" href="{{ route('reports.bankStatementDetailsReport') }}">Bank Statement Summary Report</a>                                        
            <div class="dropdown-divider"></div>          
        </div>
      </li>
  
 
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            {{ Auth::user()->name }} <span class="caret"></span>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="{{ route('createnewusers.create') }}">        Create New User</a>
            <a class="dropdown-item" href="{{ route('logout') }}"
               onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                Logout
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </li>