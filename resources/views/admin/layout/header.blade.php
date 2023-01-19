<div class="header">
    <div class="header-left">
        <a href="" class="logo logo-small">
            <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" width="30" height="30" class="site-logo">
        </a>
    </div>
    <a href="javascript:void(0);" id="toggle_btn">
        <i class="fas fa-align-left"></i>
    </a>
    <a class="mobile_btn" id="mobile_btn" href="javascript:void(0);">
        <i class="fas fa-align-left"></i>
    </a>
    <ul class="nav user-menu">
        {{-- <li class="nav-item dropdown noti-dropdown">
            <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                <i class="far fa-bell"></i> <span class="badge badge-pill"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right notifications">
                <div class="topnav-dropdown-header">
                    <span class="notification-title">Notifications</span>
                    <a href="javascript:void(0)" class="clear-noti"> Clear All </a>
                </div>
                <div class="noti-content">
                    <ul class="notification-list">
                        <li class="notification-message">
                            <a href="/">
                                <div class="media">
                                    <span class="avatar avatar-sm">
                                        <img class="avatar-img rounded-circle" alt="" src="assets/img/avatar1.png">
                                    </span>
                                    <div class="media-body">
                                        <p class="noti-details">
                                            <span class="noti-title">Vincent Porter</span>
                                        </p>
                                        <p class="noti-time">
                                            <span class="notification-time">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do..</span>
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="notification-message">
                            <a href="/">
                                <div class="media">
                                    <span class="avatar avatar-sm">
                                        <img class="avatar-img rounded-circle" alt="" src="assets/img/avatar2.png">
                                    </span>
                                    <div class="media-body">
                                        <p class="noti-details">
                                            <span class="noti-title">Vincent Porter</span>
                                        </p>
                                        <p class="noti-time">
                                            <span class="notification-time">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do..</span>
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="notification-message">
                            <a href="/">
                                <div class="media">
                                    <span class="avatar avatar-sm">
                                        <img class="avatar-img rounded-circle" alt="" src="assets/img/avatar3.png">
                                    </span>
                                    <div class="media-body">
                                        <p class="noti-details">
                                            <span class="noti-title">Vincent Porter</span>
                                        </p>
                                        <p class="noti-time">
                                            <span class="notification-time">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do..</span>
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="notification-message">
                            <a href="/">
                                <div class="media">
                                    <span class="avatar avatar-sm">
                                        <img class="avatar-img rounded-circle" alt="" src="assets/img/avatar7.png">
                                    </span>
                                    <div class="media-body">
                                        <p class="noti-details">
                                            <span class="noti-title">Vincent Porter</span>
                                        </p>
                                        <p class="noti-time">
                                            <span class="notification-time">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do..</span>
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="topnav-dropdown-footer">
                    <a href="notifications.php">View all Notifications</a>
                </div>
            </div>
        </li> --}}
        <li class="nav-item dropdown usedrop">
            <a href="javascript:void(0)" class="dropdown-toggle user-link  nav-link" data-toggle="dropdown">
                <span class="user-img">
                    @if (isset(Auth::guard('admin')->user()->image))
                        <img class="rounded-circle" src="{{ url('/user').'/'.@Auth::guard('admin')->user()->image }}" width="40" alt="">
                    @else
                        <img class="rounded-circle" src="https://ui-avatars.com/api/?name={{ @Auth::guard('admin')->user()->name }}" width="40" alt="">
                    @endif
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="{{ route('admin.profile') }}">
                    <i class="fas fa-user"></i> Profile
                </a>
                <form action="{{ route('adminlogOut') }}" method="post">
                    @csrf
                    <button type="submit" class="dropdown-item brnone">
                        <i class="fa fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        </li>
    </ul>
</div>