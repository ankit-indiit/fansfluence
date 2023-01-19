<div class="header">
    <!-- Header 1 code -->
    <nav class="navbar navbar-light navbar-expand-lg h2-nav">
        <div class="container d-flex">
            <a class="navbar-brand me-5" href="{{ route('home') }}"><img src="{{ asset('assets/img/logo-2.png') }}" class="site-logo"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#header-nav" aria-controls="header-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse hover-dropdown ms-auto justify-content-between" id="header-nav">
                <nav aria-label="breadcrumb" class="header-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">
                            <a href="#">Order Detail </a>
                        </li>
                        <li class="breadcrumb-item "><a href="#">Payment</a></li>
                    </ol>
                </nav>
                <ul class="navbar-nav ms-auto align-items-center nav-menu-right">
                    @if (Auth::user()->hasRole('influencer') && Auth::user()->hasRole('buyer'))
                        @include('layout.profile-menu.common')
                    @elseif (Auth::user()->hasRole('influencer'))
                        @include('layout.profile-menu.seller')
                    @elseif (Auth::user()->hasRole('buyer'))
                        @include('layout.profile-menu.buyer')
                    @endif
                </ul>
            </div>
        </div>
    </nav>
</div>