<li class="nav-item dropdown position-relative user-dropdown-menu ms-0 pe-3">
  	<a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
  		<span class="user-img">
  			<img src="{{ Auth::user()->image }}" class="me-2 profile-image">
  		</span> {{ ucfirst(Auth::user()->name) }}
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
               <a class="dropdown-item" href="{{ route('influencerEarning') }}?status=pending">Earnings</a>
            </li>
         </ul>
      </li>
      <li>
         <a
            class="dropdown-item"
            href="{{ route('order', 'influencer') }}?status=pending"
         >Orders</a>
      </li>      
      <li><a class="dropdown-item" href="{{ route('staredCollection') }}">Starred</a></li>
      <li><a class="dropdown-item" href="{{ route('preference') }}">Preferences</a></li>
      <li>
         <form action="{{ route('logout') }}" method="post">
            @csrf
            <button type="submit" class="dropdown-item">Logout</button>
         </form>
      </li>
   </ul>
</li>