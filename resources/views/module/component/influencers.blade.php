{{-- @if (Route::currentRouteName() == 'home' || Route::currentRouteName() == 'staredCollection'|| Route::currentRouteName() == 'influencerDetail') --}}
   <div class="container">
       <div class="d-flex justify-content-between mb-4">
            <h3 class="section-title">{{ @$title }}</h3>
            @if (isset($platform))
                <a href="{{ route('stars', $platform) }}" class="view-all-link">View All</a>
            @endif
       </div>
       <div class="carousel-wrap">
           <div class="owl-carousel profile-item-carousel owl-loaded owl-drag">
               <div class="owl-stage-outer">
                   <div class="owl-stage" style="transform: translate3d(-1800px, 0px, 0px); transition: all 0.25s ease 0s; width: 4116px;">
                       @foreach ($users as $user)                  
                       <div class="owl-item" style="width: 237.2px; margin-right: 20px;">
                           <div class="profile-item">
                               <div class="profile-img">
                                   <a href="{{ route('influencerDetail', $user->id) }}">
                                   <img src="{{ @$user->image }}" class="img-fluid">
                                   </a>
                                   <span
                                       class="profile-item-logo @if (Auth::user()) {{ @$user->stared ? 'unStarInfluencer' : 'starInfluencer' }}  @else {{ 'loginAlert' }} @endif"
                                       data-collection-id="{{ @$user->stared }}"
                                       data-id="{{ @$user->id }}"
                                       >
                                       <img
                                           src="{{ asset('assets/img/logo-icon2.png') }}"
                                           class="starClass{{ @$user->id }} {{ @$user->stared ? '' : 'logo-gray' }}"
                                       >
                                   </span>
                               </div>
                               <a href="{{ route('influencerDetail', $user->id) }}">
                                   <div class="profile-info  d-flex justify-content-between">
                                       <div>
                                           <h5>{{ @$user->name }}</h5>
                                           @if ($user->rating)
                                           <span class="rating-star">
                                           <i class="fa fa-star" aria-hidden="true"></i> 
                                           {{ @$user->rating }}
                                           </span>
                                           @else
                                           <span class="rating-star gray-star">
                                           <i class="fa fa-star" aria-hidden="true"></i> 
                                           </span>
                                           @endif
                                       </div>
                                       <div class="profile-price">
                                           @if ($user->min_price)
                                           ${{ @$user->min_price }}+
                                           @endif
                                       </div>
                                   </div>
                               </a>
                           </div>
                       </div>
                       @endforeach
                   </div>
               </div>
               @if (count($users) > 5)
               <div class="owl-nav">
                   <button type="button" role="presentation" class="owl-prev">
                   <i class="fa fa-chevron-left"></i>
                   </button>
                   <button type="button" role="presentation" class="owl-next">
                   <i class="fa fa-chevron-right"></i>
                   </button>
               </div>
               <div class="owl-dots">
                   <button role="button" class="owl-dot active">
                   <span></span>
                   </button>
                   <button role="button" class="owl-dot">
                   <span></span>
                   </button>
               </div>
               @endif
           </div>
       </div>
   </div>
{{-- @else
   <div class="expore-profiles-lists">
       @foreach ($users as $user)
       <div class="profile-item">
           <a href="{{ route('influencerDetail', $user->id) }}">
               <div class="profile-img">
                   <img src="{{ @$user->image }}" class="img-fluid">
                   <span class="profile-item-logo">
                   <img src="{{ asset('assets/img/logo-icon2.png') }}">
                   </span>
               </div>
               <div class="profile-info  d-flex justify-content-between">
                   <div>
                       <h5>{{ @$user->name }}</h5>
                       @if ($user->rating)
                       <span class="rating-star">
                       <i class="fa fa-star" aria-hidden="true"></i> 
                       {{ @$user->rating }}
                       </span>
                       @else
                       <span class="rating-star gray-star">
                       <i class="fa fa-star" aria-hidden="true"></i> 
                       </span>
                       @endif
                   </div>                   
                   <div class="profile-price">
                       @if ($user->min_price)
                       ${{ @$user->min_price }}+
                       @endif
                   </div>
               </div>
           </a>
       </div>
       @endforeach
   </div>
@endif --}}