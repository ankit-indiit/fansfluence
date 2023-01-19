<div class="sidebar" id="sidebar">
    <div class="sidebar-logo">      
        <a href="">
            <img src="{{ asset('assets/img/logo-2.png') }}" alt="Logo" width="30" height="30" class="site-logo">
        </a>
    </div>
    <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: 100%; height: 289px;"><div class="sidebar-inner slimscroll" style="overflow: hidden; width: 100%; height: 339px;">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                @php
                    $route = Route::currentRouteName();
                @endphp
                <li class="{{ $route == 'dashboard' ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}"><i class="fas fa-columns"></i> <span>Dashboard</span></a>
                </li>
                <li>
                    <li class="{{ $route == 'user.index' ? 'active' : '' }}">
                        <a href="{{ route('user.index') }}">
                            <i class="fas fa-users"></i>
                            <span>Users</span>
                        </a>
                    </li>
                </li>
                <li>
                    <li class="{{ $route == 'order.index' ? 'active' : '' }}">
                        <a href="{{ route('category.index') }}">
                            <i class="fas fa-list-alt"></i>
                            <span>Category</span>
                        </a>
                    </li>
                </li>
                <li>
                    <li class="{{ $route == 'order.index' ? 'active' : '' }}">
                        <a href="{{ route('order.index') }}">
                            <i class="fas fa-shopping-cart"></i>
                            <span>Orders</span>
                        </a>
                    </li>
                </li>
                <li>
                    <li class="{{ $route == 'gigs.index' ? 'active' : '' }}">
                        <a href="{{ route('gigs.index') }}">
                            <i class="fas fa-list-alt"></i>
                            <span>Seller Gigs</span>
                        </a>
                    </li>
                </li>
                <li>
                    <li class="{{ $route == 'contactUs.index' ? 'active' : '' }}">
                        <a href="{{ route('contactUs.index') }}">
                            <i class="fas fa-address-book"></i>
                            <span>Contact Us</span>
                        </a>
                    </li>
                </li>
                <li>
                    <li class="{{ $route == 'page.index' ? 'active' : '' }}">
                        <a href="{{ route('page.index') }}">
                            <i class="fa fa-file"></i>
                            <span>Pages</span>
                        </a>
                    </li>
                </li>
                <li>
                    <li class="{{ $route == 'faq.index' ? 'active' : '' }}">
                        <a href="{{ route('faq.index') }}">
                            <i class="fas fa-question-circle"></i>
                            <span>FAQs</span>
                        </a>
                    </li>
                </li>
                <li>
                    <li class="{{ $route == 'manage-payment.index' ? 'active' : '' }}">
                        <a href="{{ route('manage-payment.index') }}">
                            <i class="fas fa-credit-card"></i>
                            <span>Manage Payments</span>
                        </a>
                    </li>
                </li>          
                <li class="submenu">
                    <a href="#" class="">
                        <i class="fa fa-user-cog"></i> 
                        <span> Setting </span> 
                        <span class="menu-arrow pl-4"></span>
                    </a>
                    <ul style="display: none;">
                        <li><a href="{{ route('payment.create', 'paypal') }}">Paypal</a></li>
                        <li><a href="{{ route('payment.create', 'stripe') }}">Stripe</a></li>
                    </ul>
                </li>
                {{-- <li class="submenu">
                    <a href="#" class="">
                        <i class="fas fa-users"></i> 
                        <span> Orders </span> 
                        <span class="menu-arrow pl-4"></span>
                    </a>
                    <ul style="display: none;">
                    <li><a href="{{ route('order.index', 'buyer') }}">Buyer</a></li>
                    <li><a href="{{ route('order.index', 'influencer') }}">Seller</a></li>
                    </ul>
                </li>      --}}                                           
            </ul>
        </div>
    </div><div class="slimScrollBar" style="background: rgb(204, 204, 204); width: 7px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 593.772px;"></div><div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;"></div></div>
</div>