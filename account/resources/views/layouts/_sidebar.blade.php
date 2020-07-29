<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{ asset('img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{ config('app.name', 'Laravel') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link {{ Request::is('home') ? "active" : "" }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                @can('isAdmin')
                    <li class="nav-item">
                        <a href="{{ route('user.index') }}" class="nav-link {{ Request::is('user*') ? "active" : "" }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>User Management</p>
                        </a>
                    </li>
                @endcan
                <li class="nav-item">
                    <a href="{{ route('company.index') }}" class="nav-link {{ Request::is('company*') ? "active" : "" }}">
                        <i class="nav-icon far fa-building"></i>
                        <p>Company Management</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('category.index') }}" class="nav-link {{ Request::is('category*') ? "active" : "" }}">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>Company Category</p>
                    </a>
                </li>
                <li class="nav-item has-tree-view {{ Request::is('invoice*') ? "menu-open" : "" }}">
                    <a href="#" class="nav-link {{ Request::is('invoice*') ? "active" : "" }}">
                        <i class="nav-icon fas fa-file-invoice"></i>
                        <p>
                            Invoice Wise Entry
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('sales.index') }}" class="nav-link {{ Request::is('invoice/sales*') ? "active" : "" }}">
                                <i class="nav-icon fas fa-chart-pie"></i>
                                <p>Sales Entry</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('purchase.index') }}" class="nav-link {{ Request::is('invoice/purchase*') ? "active" : "" }}">
                                <i class="nav-icon fas fa-chart-bar"></i>
                                <p>Purchase Entry</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-tree-view {{ Request::is('ledger*') ? "menu-open" : "" }}">
                    <a href="#" class="nav-link {{ Request::is('ledger*') ? "active" : "" }}">
                        <i class="nav-icon fas fa-book"></i>
                        <p>
                            Ledger Operation
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('account.index') }}" class="nav-link {{ Request::is('ledger/account*') ? "active" : "" }}">
                                <i class="nav-icon fas fa-user"></i>
                                <p>Ledger Account</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('entry.index') }}" class="nav-link {{ Request::is('ledger/entry*') ? "active" : "" }}">
                                <i class="nav-icon fas fa-book-open"></i>
                                <p>Ledger Entry</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-tree-view {{ Request::is('journal*') ? "menu-open" : "" }}">
                    <a href="#" class="nav-link {{ Request::is('journal*') ? "active" : "" }}">
                        <i class="nav-icon far fa-bookmark"></i>
                        <p>
                            Journal Voucher Entry
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('receipt.index') }}" class="nav-link {{ Request::is('journal/receipt*') ? "active" : "" }}">
                                <i class="nav-icon fas fa-receipt"></i>
                                <p>Receipt Entry</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link {{ Request::is('journal/payment*') ? "active" : "" }}">
                                <i class="nav-icon fas fa-file-invoice-dollar"></i>
                                <p>Payment Entry</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
    <!-- /.sidebar -->
</aside>