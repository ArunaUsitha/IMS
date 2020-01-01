<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{Route('dashboard')}}">{{ env('APP_NAME') }}</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{Route('dashboard')}}">IMS</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">System Management</li>
            <li class="nav-item dropdown {{(request()->is('/*') || request()->is('dashboard')) ? 'active' :''}}">
                <a href="{{Route('dashboard')}}" class="nav-link"><i class="fas fa-fire"></i><span>Dashboard</span></a>
            </li>


            <li class="nav-item dropdown {{(request()->is('user*')) ? 'active' :''}}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-users"></i><span>User Management</span></a>
                <ul class="dropdown-menu">
                    @can('read',Auth::user())<li><a class="nav-link" href="{{Route('user.overview')}}">Overview</a></li>@endcan
                        @can('create',Auth::user())<li><a class="nav-link" href="{{Route('user.create')}}">New User</a></li>@endcan
                </ul>
            </li>

            <li class="nav-item dropdown {{(request()->is('sales*')) ? 'active' :''}}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-store"></i><span>Sales Management</span></a>
                <ul class="dropdown-menu">
                    @can('create',Auth::user())<li><a class="nav-link" href="{{Route('sales.newSalesOrder')}}">New Sales Order</a></li>@endcan
                    @can('create',Auth::user())<li><a class="nav-link" href="{{Route('sales.customerCreate')}}">Register New Customer</a></li>@endcan
                    @can('read',Auth::user())<li><a class="nav-link" href="{{Route('sales.customerOverview')}}">Customer overview</a></li>@endcan
                </ul>
            </li>

            <li class="nav-item dropdown {{(request()->is('stock*')) ? 'active' :''}}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-warehouse"></i><span>Stock Management</span></a>
                <ul class="dropdown-menu">
                    @can('read',Auth::user())<li><a class="nav-link" href="{{Route('stock.viewStock')}}">View Stock</a></li>@endcan
                </ul>
            </li>

            <li class="nav-item dropdown {{(request()->is('supplier*')) ? 'active' :''}}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-parachute-box"></i><span>Supplier Management</span></a>
                <ul class="dropdown-menu">
                    @can('read',Auth::user())<li><a class="nav-link" href="{{Route('supplier.overview')}}">Overview</a></li>@endcan
                    @can('create',Auth::user())<li><a class="nav-link" href="{{Route('supplier.create')}}">New Supplier</a></li>@endcan
{{--                    @can('create',Auth::user())<li><a class="nav-link" href="{{Route('supplier.assignItems')}}">Assign Items</a></li>@endcan--}}
                </ul>
            </li>

            <li class="nav-item dropdown {{(request()->is('product*')) ? 'active' :''}}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-box-open"></i><span>Product Management</span></a>
                <ul class="dropdown-menu">
                    @can('read',Auth::user())<li><a class="nav-link" href="{{Route('product.overview')}}">Overview</a></li>@endcan
                    @can('create',Auth::user())<li><a class="nav-link" href="{{Route('product.create')}}">Add New Product</a></li>@endcan
                    @can('read',Auth::user())<li><a class="nav-link" href="{{Route('product.warrantyManagementOverview')}}">Manage Warranties</a></li>@endcan
                </ul>
            </li>

            <li class="nav-item dropdown {{(request()->is('purchase*')) ? 'active' :''}}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-cart-arrow-down"></i><span>Purchase Management</span></a>
                <ul class="dropdown-menu">
                    @can('create',Auth::user())<li><a class="nav-link" href="{{Route('purchase.create')}}">New Purchase Order</a></li>@endcan
                    @can('create',Auth::user())<li><a class="nav-link" href="{{Route('purchase.GRNCreate')}}">Insert New GRN</a></li>@endcan
                </ul>
            </li>

            <li class="nav-item dropdown {{(request()->is('reports*')) ? 'active' :''}}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-file-contract"></i><span>Reports</span></a>
            </li>

            <li class="nav-item dropdown {{(request()->is('settings*')) ? 'active' :''}}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-cogs"></i><span>System Settings</span></a>
            </li>

        </ul>



    </aside>
</div>
