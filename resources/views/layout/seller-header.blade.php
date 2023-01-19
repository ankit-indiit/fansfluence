<div class="header {{ Route::currentRouteName() == 'home' ? 'home-header' : '' }}">
   <nav class="navbar navbar-light navbar-expand-lg h2-nav">
      <div class="container d-flex">
         <a class="navbar-brand me-5" href="{{ route('home') }}">
            @if (Route::currentRouteName() == 'home')
               <img src="{{ asset('assets/img/logo.png') }}" class="site-logo">
            @else
               <img src="{{ asset('assets/img/logo-2.png') }}" class="site-logo">
            @endif
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
                  <a class="dropdown-item" href="#">
                     <div class="d-flex align-items-center">
                        <div class="main-img-user"><img alt="avatar" src="{{ asset('assets/img/recommended4.png') }}"></div>
                        <div class="notification-body">
                           <p><strong>John Doe</strong> has delivered your video. </p>
                           <small class="notification-text">Won the monthly best seller badge</small>
                        </div>
                     </div>
                  </a>
               </li>
               
            </ul>
         </div>
         <div class="collapse navbar-collapse hover-dropdown ms-auto justify-content-between" id="header-nav">
            <ul class="navbar-nav">
               @foreach (getAllCategory() as $category)
                  <li class="nav-item dropdown dropdown-mega-menu">
                     <a class="nav-link dropdown-toggle" href="explore.html" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
               <li class="menu-swith-btn">
                  <div class="form-check form-switch">
                       <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked">
                  </div>
               </li>
            </ul>
            <ul class="navbar-nav ms-auto align-items-center nav-menu-right">
               <li>
                  <form class="d-flex header-search-form position-relative">
                     <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                     </svg>
                  </form>
               </li>
               @if (Auth::user())
                  <li class="nav-item dropdown notification-dropdown position-relative m-0 ms-3">
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
                        @if (count(getAllNotifications()) > 0)
                           @foreach (getAllNotifications() as $notification)
                              <li>
                                 <a class="dropdown-item" href="{{ @$notification['data']['link'] }}">
                                    <div class="d-flex align-items-center">
                                       <div class="main-img-user">
                                          @if (isset($notification['data']['user_id']))
                                             <img alt="avatar" src="{{ getUserImageById($notification['data']['user_id']) }}">
                                          @else
                                             <img alt="avatar" src="{{ asset('assets/img/recommended4.png') }}">
                                          @endif
                                       </div>
                                       <div class="notification-body">
                                          <p>{{ @$notification['data']['message'] }}</p>
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
                  <li class="nav-item dropdown position-relative user-dropdown-menu ms-0 pe-3">
                     <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="user-img">
                           <img src="{{ Auth::user()->image }}" class="me-2 profile-image">
                        </span>
                        {{ @Auth::user()->name }}
                     </a>
                     <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('account') }}">Account</a></li>
                        <li class="dropdown-submenu">
                           <a class="dropdown-item submenu-dropdown-tgl">Influencers</a>
                           <ul class="submenu dropdown-menu">
                              <li>
                                 <a class="dropdown-item" href="{{ route('influencerProfile') }}">Profile</a>
                              </li>
                              <li>
                                 <a class="dropdown-item" href="{{ route('influencerEarning') }}">Earnings</a>
                              </li>
                              <li>
                                 <a class="dropdown-item" href="{{ route('accountNotification') }}">Account Notification</a>
                              </li>
                           </ul>
                        </li>
                        <li>
                           <a
                              class="dropdown-item"
                              href="{{ route('order', 'seller') }}?status=pending"
                           >Orders</a>
                        </li>                        
                        <li><a class="dropdown-item" href="{{ route('staredCollection') }}">Starred</a></li>
                        <li><a class="dropdown-item" href="#">Preferences</a></li>
                        <li>
                           <form action="{{ route('logout') }}" method="post">
                              @csrf
                              <button type="submit" class="dropdown-item">Logout</button>
                           </form>
                        </li>
                     </ul>
                  </li>
               @else
                  <li>
                     <a class="dropdown-item" href="{{ route('login') }}">Login</a>
                  </li>
               @endif
            </ul>
         </div>
      </div>
   </nav>
</div>