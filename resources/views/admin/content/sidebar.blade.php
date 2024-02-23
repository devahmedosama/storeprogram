<!-- Side Nav START -->
<div class="side-nav">
    <div class="side-nav-inner">
        <ul class="side-nav-menu scrollable">
            <li class="nav-item ">
                <a  href="{{ URL::to('admin') }}">
                    <span class="icon-holder">
                        <i class="anticon anticon-dashboard"></i>
                    </span>
                    <span class="title">{{ trans('home.DashBoard') }} </span>
                </a>
            </li>
            @if(auth()->user()->type == 0)
                <li class="nav-item ">
                    <a  href="{{ URL::to('admin/supliers') }}">
                        <span class="icon-holder">
                            <i class="anticon anticon-dashboard"></i>
                        </span>
                        <span class="title">{{ trans('home.Suppliers') }} </span>
                    </a>
                </li>
                <li class="nav-item ">
                    <a  href="{{ URL::to('admin/sales-men') }}">
                        <span class="icon-holder">
                            <i class="anticon anticon-dashboard"></i>
                        </span>
                        <span class="title">{{ trans('home.Sales Men') }} </span>
                    </a>
                </li>
                <li class="nav-item ">
                    <a  href="{{ URL::to('admin/products') }}">
                        <span class="icon-holder">
                            <i class="anticon anticon-dashboard"></i>
                        </span>
                        <span class="title">{{ trans('home.Products') }} </span>
                    </a>
                </li>
                <li class="nav-item ">
                    <a  href="{{ URL::to('admin/stores') }}">
                        <span class="icon-holder">
                            <i class="anticon anticon-dashboard"></i>
                        </span>
                        <span class="title">{{ trans('home.Stores') }} </span>
                    </a>
                </li>
            @endif
            @if(auth()->user()->type < 2)
            <li class="nav-item ">
                <a  href="{{ URL::to('admin/purchases') }}">
                    <span class="icon-holder">
                        <i class="anticon anticon-dashboard"></i>
                    </span>
                    <span class="title">{{ trans('home.Purchases') }} </span>
                </a>
            </li>
            <li class="nav-item ">
                <a  href="{{ URL::to('admin/recives') }}">
                    <span class="icon-holder">
                        <i class="anticon anticon-dashboard"></i>
                    </span>
                    <span class="title">{{ trans('home.Recives') }} </span>
                </a>
            </li>
            <li class="nav-item ">
                <a  href="{{ URL::to('admin/sales-bills') }}">
                    <span class="icon-holder">
                        <i class="anticon anticon-dashboard"></i>
                    </span>
                    <span class="title">{{ trans('home.Sales Bills') }} </span>
                </a>
            </li>
            <li class="nav-item ">
                <a  href="{{ URL::to('admin/stock-movements') }}">
                    <span class="icon-holder">
                        <i class="anticon anticon-dashboard"></i>
                    </span>
                    <span class="title">{{ trans('home.Stock Movements') }} </span>
                </a>
            </li>
            <li class="nav-item ">
                <a  href="{{ URL::to('admin/shop-movements') }}">
                    <span class="icon-holder">
                        <i class="anticon anticon-dashboard"></i>
                    </span>
                    <span class="title">{{ trans('home.Shop Movements') }} </span>
                </a>
            </li>
            <li class="nav-item ">
                <a  href="{{ URL::to('admin/stocks') }}">
                    <span class="icon-holder">
                        <i class="anticon anticon-dashboard"></i>
                    </span>
                    <span class="title">{{ trans('home.Stock') }} </span>
                </a>
            </li>
            @endif
            @if(auth()->user()->type == 0)
                <li class="nav-item ">
                    <a  href="{{ URL::to('admin/inventories') }}">
                        <span class="icon-holder">
                            <i class="anticon anticon-dashboard"></i>
                        </span>
                        <span class="title">{{ trans('home.Inventory') }} </span>
                    </a>
                </li>
                <li class="nav-item ">
                    <a  href="{{ URL::to('admin/processes') }}">
                        <span class="icon-holder">
                            <i class="anticon anticon-dashboard"></i>
                        </span>
                        <span class="title">{{ trans('home.Inventory Process') }} </span>
                    </a>
                </li>
                <li class="nav-item ">
                    <a  href="{{ URL::to('admin/users') }}">
                        <span class="icon-holder">
                            <i class="anticon anticon-dashboard"></i>
                        </span>
                        <span class="title">{{ trans('home.Users') }} </span>
                    </a>
                </li>
                <li class="nav-item ">
                    <a  href="{{ URL::to('admin/settings') }}">
                        <span class="icon-holder">
                            <i class="anticon anticon-dashboard"></i>
                        </span>
                        <span class="title">{{ trans('home.Settings') }} </span>
                    </a>
                </li>
            @endif
            @if(auth()->user()->type == 2)
            <li class="nav-item ">
                <a  href="{{ URL::to('admin/shop-recives') }}">
                    <span class="icon-holder">
                        <i class="anticon anticon-dashboard"></i>
                    </span>
                    <span class="title">{{ trans('home.Recives') }} </span>
                </a>
            </li>
            @endif
            <li class="nav-item ">
                <a  href="{{ URL::to('admin/profile') }}">
                    <span class="icon-holder">
                        <i class="anticon anticon-dashboard"></i>
                    </span>
                    <span class="title">{{ trans('home.Profile') }} </span>
                </a>
            </li>
            <li class="nav-item ">
                <a  href="{{ URL::to('logout') }}">
                    <span class="icon-holder">
                      <i class="fas fa-power-off"></i>
                    </span>
                    <span class="title">{{ trans('home.Logout') }} </span>
                </a>
            </li>
        </ul>
    </div>
</div>
<!-- Side Nav END -->