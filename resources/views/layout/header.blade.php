<div class="header {{ Route::currentRouteName() == 'home' ? 'home-header' : '' }}">
    <nav class="navbar navbar-light navbar-expand-lg h2-nav">
        <div class="container d-flex">
            <a class="navbar-brand me-5" href="{{ route('home') }}">
	            {!! siteLogo() !!}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#header-nav" aria-controls="header-nav" aria-expanded="false" aria-label="Toggle navigation">
            	<span class="navbar-toggler-icon"></span>
            </button>
            <div class="nav-item dropdown notification-dropdown d-lg-none">
                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                    </svg>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <h4>Notifications <a href="{{ route('notification') }}">View all</a></h4>
                    </li>
                    <li>
                        @if (Auth::user() && count(getAllNotifications()) > 0)
                            @foreach (getAllNotifications() as $notification)
                                <a class="dropdown-item" href="{{ @$notification['data']['link'] }}">
                                    <div class="d-flex align-items-center">
                                        <div class="main-img-user">
                                            @if (isset($notification['data']['user_id']))
                                            {!! getUserProfilePic($notification['data']['user_id']) !!}
                                            @endif
                                        </div>
                                        <div class="notification-body">
                                            <p>{!! substr(@$notification['data']['message'], 0, 25) !!}...</p>
                                            <p>{{ $notification->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        @else
                            <h4 class="pt-2">No notification found!</h4>
                        @endif
                    </li>
                </ul>
            </div>
            <div class="collapse navbar-collapse hover-dropdown ms-auto justify-content-between" id="header-nav">
                <ul class="navbar-nav">
                    @foreach (getAllCategory() as $category)
                    <li class="nav-item dropdown dropdown-mega-menu">
                        <a class="nav-link dropdown-toggle" href="javascript:void(0);" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ $category->name }}
                        </a>
                        @if (count($category->subCategory) > 0)
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <div class="flx-wrp">
                                    <ul>
                                        @foreach ($category->subCategory as $subCategory)
                                            <li>
                                                <a
                                                    class="dropdown-item"
                                                    href="{{ route('influencers', [$category->category, $subCategory->name]) }}"
                                                    >
                                                {{ $subCategory->name }}
                                                </a>
                                            </li>
                                        @endforeach			               		                                    
                                    </ul>
                                </div>
                            </div>
                        @endif
                    </li>
                    @endforeach
                    @if (Auth::user())
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);">
                                Business                            
                            </a>
                        </li>                    
                        <li class="menu-swith-btn">
                            <div class="form-check form-switch">
                                <input
                                    class="form-check-input business"
                                    type="checkbox"
                                    name="business"
                                    {{ @Auth::user()->business == 1 ? 'checked' : '' }}
                                >
                            </div>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);">
                                Business                            
                            </a>
                        </li>                    
                        <li class="menu-swith-btn">
                            <div class="form-check form-switch">
                                <input
                                    class="form-check-input businessFilter"
                                    type="checkbox"
                                    name="business_filter"
                                    {{ Session::has('business') ? 'checked' : '' }}
                                >
                            </div>
                        </li>
                    @endif
                </ul>
                <ul class="navbar-nav ms-auto align-items-center nav-menu-right">
                    <li class="searchhome">
                        <form
                            class="d-flex header-search-form position-relative"
                            action="{{ route('search') }}"
                            method="get"
                            id="search"
                        >
                            <input
                                type="search"
                                name="search"
                                class="form-control me-2"
                                placeholder="Search"
                                aria-label="Search"
                                id="searchBox"
                                autocomplete="off"
                                value="{{ request()->search ? request()->search : '' }}"
                            >
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                        </form> 
                        <ul class="dropdown-menu searchdrop">
                            
                       </ul>                       
                    </li>
                    @if (Auth::user())
                    <li class="nav-item dropdown notification-dropdown position-relative m-0 ms-3">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell">
                                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                                <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                            </svg>
                            @if (count(getAllNotifications()) > 0)
                                <span class="highliter"></span>
                            @endif
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <h4>Notifications <a href="{{ route('notification') }}">View all</a></h4>
                            </li>
                            @if (count(getAllNotifications()) > 0)
                                @foreach (getAllNotifications() as $notification)
                                    <li>
                                        <a class="dropdown-item" href="{{ @$notification['data']['link'] }}">
                                            <div class="d-flex align-items-center">
                                                <div class="main-img-user">
                                                    @if (isset($notification['data']['user_id']))
                                                    {!! getUserProfilePic($notification['data']['user_id']) !!}
                                                    @endif       
                                                </div>
                                                <div class="notification-body">
                                                    <p>
                                                        {!! substr(@$notification['data']['message'], 0, 25) !!}...
                                                    </p>
                                                    <p>{{ $notification->created_at->diffForHumans() }}</p>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            @else
                                <h4 class="pt-2">No notification found!</h4>
                            @endif
                        </ul>
                    </li>
                    @if (Auth::user()->hasRole('influencer') && Auth::user()->hasRole('buyer'))
                    	@include('layout.profile-menu.common')
                    @elseif (Auth::user()->hasRole('influencer'))
                    	@include('layout.profile-menu.seller')
                    @elseif (Auth::user()->hasRole('buyer'))
                    	@include('layout.profile-menu.buyer')
                    @endif
                    @else
                    <li>
                        <a
                            class="dropdown-item login {{ Route::currentRouteName() == 'home' ? 'light-login' : 'dark-login' }}"
                            href="{{ route('login') }}"                            
                        >
                            Login
                        </a>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
</div>