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
                <a href="{{Route('dashboard')}}" class="nav-link">
                    <i class="fas fa-fire"></i><span>Dashboard</span></a>
            </li>

            @canany('view_users','create_user')
                <li class="nav-item dropdown {{(request()->is('user*')) ? 'active' :''}}">
                    <a href="#" class="nav-link has-dropdown"><i
                                class="fas fa-users"></i><span>User Management</span></a>
                    <ul class="dropdown-menu">
                        @can('view_users')
                            <li><a class="nav-link" href="{{Route('user.overview')}}">Overview</a></li>
                        @endcan
                        @can('create_user')
                            <li><a class="nav-link" href="{{Route('user.create')}}">New User</a></li>
                        @endcan
                    </ul>
                </li>
            @endcanany

            @canany('create_sales_order','register_customer','view_customer')
                <li class="nav-item dropdown {{(request()->is('sales*')) ? 'active' :''}}">
                    <a href="#" class="nav-link has-dropdown"><i class="fas fa-store"></i><span>Sales Management</span></a>
                    <ul class="dropdown-menu">
                        @can('create_sales_order')
                            <li><a class="nav-link" href="{{Route('sales.salesOrdersOverview')}}">Overview</a></li>
                        @endcan
                        @can('create_sales_order')
                            <li><a class="nav-link" href="{{Route('sales.newSalesOrder')}}">New Sales Order</a></li>
                        @endcan
                        @can('create_sales_order')
                            <li><a class="nav-link" href="{{Route('sales.createNewSalesQuotation')}}">New Sales
                                    Quotation</a>
                            </li>
                        @endcan
                        @can('register_customer')
                            <li><a class="nav-link" href="{{Route('sales.customerCreate')}}">Register New Customer</a>
                            </li>
                        @endcan
                        @can('view_customer')
                            <li><a class="nav-link" href="{{Route('sales.customerOverview')}}">Customer overview</a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcanany


            @canany('view_stock')
                <li class="nav-item dropdown {{(request()->is('stock*')) ? 'active' :''}}">
                    <a href="#" class="nav-link has-dropdown"><i
                                class="fas fa-warehouse"></i><span>Stock Management</span></a>
                    <ul class="dropdown-menu">
                        @can('view_stock')
                            <li><a class="nav-link" href="{{Route('stock.viewStock')}}">View Stock</a></li>
                        @endcan
                    </ul>
                </li>
            @endcanany


            @canany('view_suppliers','register_suppliers','stock_assignment')
                <li class="nav-item dropdown {{(request()->is('supplier*')) ? 'active' :''}}">
                    <a href="#" class="nav-link has-dropdown"><i
                                class="fas fa-parachute-box"></i><span>Supplier Management</span></a>
                    <ul class="dropdown-menu">
                        @can('view_suppliers')
                            <li><a class="nav-link" href="{{Route('supplier.overview')}}">Overview</a></li>
                        @endcan
                        @can('register_suppliers')
                            <li><a class="nav-link" href="{{Route('supplier.create')}}">New Supplier</a></li>
                        @endcan
                        @can('stock_assignment')
{{--                            <li><a class="nav-link" href="{{Route('supplier.assignItems')}}">Assign Items</a></li>--}}
                        @endcan
                        @can('view_order_history')
                            <li><a class="nav-link" href="{{Route('supplier.viewOrderHistory')}}">View order history</a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcanany


            @canany('view_products','add_product','manage_warranties')
                <li class="nav-item dropdown {{(request()->is('product*')) ? 'active' :''}}">
                    <a href="#" class="nav-link has-dropdown"><i
                                class="fas fa-box-open"></i><span>Product Management</span></a>
                    <ul class="dropdown-menu">
                        @can('view_products')
                            <li><a class="nav-link" href="{{Route('product.overview')}}">Overview</a></li>
                        @endcan
                        @can('add_product')
                            <li><a class="nav-link" href="{{Route('product.create')}}">Add New Product</a></li>
                        @endcan
{{--                        @canany('manage_warranties')--}}
{{--                            <li><a class="nav-link" href="{{Route('product.warrantyManagementOverview')}}">Manage--}}
{{--                                    Warranties</a>--}}
{{--                            </li>--}}
{{--                        @endcan--}}
                    </ul>
                </li>
            @endcanany

            @canany('create_purchase_order','add_stock')
                <li class="nav-item dropdown {{(request()->is('purchase*')) ? 'active' :''}}">
                    <a href="#" class="nav-link has-dropdown"><i class="fas fa-cart-arrow-down"></i><span>Purchase Management</span></a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="{{Route('purchase.overview')}}">Overview</a></li>
                        @can('create_purchase_order')
                            <li><a class="nav-link" href="{{Route('purchase.create')}}">New Purchase Order</a></li>
                        @endcan
                        @can('add_stock')
                            <li><a class="nav-link" href="{{Route('purchase.GRNCreate')}}">Insert New GRN</a></li>
                        @endcan
                    </ul>
                </li>
            @endcanany

            @canany('view_reports')
                <li class="nav-item dropdown {{(request()->is('reports*')) ? 'active' :''}}">
                    @can('view_reports')
                        <a href="{{Route('reports.overview')}}" class="nav-link "><i
                                    class="fas fa-file-contract"></i><span>Reports</span></a>
                    @endcan
                </li>
            @endcanany


            @canany('role_management')
                <li class="nav-item dropdown {{(request()->is('settings*')) ? 'active' :''}}">
                    <a href="#" class="nav-link has-dropdown"><i
                                class="fas fa-cogs"></i><span>System Settings</span></a>
                    <ul class="dropdown-menu">
                        @can('role_management')
                            <li><a class="nav-link" href="{{Route('settings.userAdministrationOverview')}}">Role
                                    Management</a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcanany

        </ul>


    </aside>
</div>
