
        <div class="top_block">
            <div class="pull-right">
                <p>Welcome to <span>Merchants Hub</span></p>
            </div>
        </div>

        <nav class="menu navbar navbar-default">
            <div class="">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                      <a class="logo navbar-brand" href="{{ url('/admin') }}"><img src="{{url()}}/images/logo.png" alt=""></a>
                </div>
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse no-padding" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav">


                            <li >
                                <a style="padding-left: 0" href="{{ url('/admin') }}">
                                    <i class="fa fa-tachometer"></i>Dashboard
                                </a>
                            </li>

                            @if(Auth::user()->get()->hasRole('merchant'))
                                <li>
                                    <a href="{{ route('admin.merchant-items.index') }}"><i class="fa fa-th"></i>Items
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.ordered-items.index') }}"><i class="fa fa-bar-chart"></i>Sales
                                    </a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-book"></i> Reports</a>
                                </li>
                            @endif


                            @if(Auth::user()->get()->hasRole(['admin', 'manager']))
                            <li>
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-th"></i> Items
                                 <span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                       <li><a href="{{ route('admin.items.create') }}">Add Item</a></li>
                                        <li>
                                        <a href="{{ route('admin.items.index') }}">
                                        Manage Item</a>
                                        </li>
                                        <li>
                                            <a href="{{ url('admin/item/stock-management') }}">
                                               Stock Management</a>
                                        </li>
                                        <li>
                                            <a href="{{ url('admin/item/no-size') }}">
                                                No Size</a>
                                        </li>
                                    </ul>
                            </li>
                            @endif
                            
                             @if(Auth::user()->get()->hasRole('admin'))
                                <li>
                                   <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-bar-chart"></i> Sales
                                      <span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="{{ route('admin.orders.index') }}">
                                                Orders
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('admin.invoices.index') }}">
                                                Invoices
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('admin.shipments.index') }}">
                                                Shipments
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                @endif


                                @if(Auth::user()->get()->hasRole('admin'))
                                <li>
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cogs"></i> Setup
                                        <span class="caret"></span></a>
                                    <ul class="dropdown-menu">


                                        <li>
                                            <a href="{{ route('admin.stores.index') }}">Stores</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('admin.customers.index') }}">Customers</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('admin.users.index') }}">Users</a>
                                        </li>

                                        <li>
                                            <a href="{{ route('admin.events.index') }}">Events</a>
                                        </li>
                                    </ul>
                                </li>
                                @endif

                                @if(Auth::user()->get()->hasRole('manager'))
                                <li>
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cogs"></i> Setup
                                        <span class="caret"></span></a>
                                    <ul class="dropdown-menu">

                                        <li>
                                            <a href="{{ route('admin.stores.index') }}">Stores</a>
                                        </li>
                                    </ul>
                                </li>
                                @endif

                                @if(Auth::user()->get()->hasRole('admin'))
                                <li>
                                    <a href="{{ route('admin.coupons.index') }}">
                                        <i class="fa fa-tags"></i> Coupons
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('admin.news.index') }}">
                                         <i class="fa fa-newspaper-o"></i> News
                                    </a>
                                </li>

                                <li>
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-book"></i> Reports
                                        <span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="{{ url('admin/reports/sales') }}">
                                                Sales
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ url('admin/reports/orders') }}">
                                                Orders
                                            </a>
                                        </li>

                                    </ul>
                                </li>

                            @endif

                        </ul>


                        <ul class="nav navbar-nav navbar-right">
                            <li>
                                <ul class="nav navbar-nav navbar-right">
                                    @if (Auth::user()->guest())
                                        <li><a href="{{ url('/auth/login') }}">Login</a></li>
                                    @else
                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="caret"></span>
                                                <i class="fa fa-user"></i> {{Auth::user()->get()->name}}
                                            </a>
                                            <ul class="dropdown-menu" role="menu">
                                                <li><a href="{{ url('/auth/logout') }}">Logout</a></li>
                                                <li><a href="{{ route('admin_change_password') }}">Change Password</a></li>
                                            </ul>
                                        </li>
                                    @endif
                                </ul>

                            </li>
                        </ul>
                    </div>
                    <!-- /.navbar-collapse -->

                </div>
                <!-- /.container-fluid -->
        </nav>