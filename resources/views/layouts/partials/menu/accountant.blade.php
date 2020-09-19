<li><a class="nav-link" href="{{ route('sales.index') }}">Sales</a></li>
<li><a class="nav-link" href="{{ route('paymentMode.create') }}">Payment Modes</a></li>
<li><a class="nav-link" href="{{ route('product.create') }}">Product</a></li>
<li><a class="nav-link" href="{{ route('suppliers.create') }}">Supliers</a></li>
<li><a class="nav-link" href="{{ route('customers.create') }}">Customers</a></li>
<li><a class="nav-link" href="{{ route('banks.create') }}">Banks</a></li>
<li><a class="nav-link" href="{{ route('bankAccounts.create') }}">Bank Accounts</a></li>
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        {{ Auth::user()->name }} <span class="caret"></span>
    </a>
    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
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