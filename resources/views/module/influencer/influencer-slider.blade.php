<div class="container">
   <div class="d-flex mb-4">
      <h3 class="section-title">{{ $title }}</h3>
   </div>
   <div class="carousel-wrap">
      <div class="owl-carousel profile-item-carousel owl-loaded owl-drag">
         <div class="owl-stage-outer">
            <div class="owl-stage" style="transform: translate3d(-1800px, 0px, 0px); transition: all 0.25s ease 0s; width: 4116px;">
               @foreach ($users as $user)
                  <div class="owl-item" style="width: 237.2px; margin-right: 20px;">
                     <div class="profile-item">
                        <div class="profile-img">
                           <img src="{{ $user->image }}" class="img-fluid">
                           <span
                              class="profile-item-logo @if (Auth::user()) {{ $user->stared ? 'unStarInfluencer' : 'starInfluencer' }}  @else {{ 'loginAlert' }} @endif"
                              data-collection-id="{{ $user->stared }}"
                              data-id="{{ $user->id }}"
                           >
                              <img
                                 src="{{ asset('assets/img/logo-icon2.png') }}"
                                 class="starClass{{ $user->id }} {{ $user->stared ? '' : 'logo-gray' }}"
                              >
                           </span>
                        </div>
                        <div class="profile-info  d-flex justify-content-between">
                           <div>
                              <h5>{{ $user->name }}</h5>
                              @if ($user->rating)
                                 <span class="rating-star">
                                    <i class="fa fa-star" aria-hidden="true"></i> 
                                    {{ $user->rating }}
                                 </span>
                              @else
                                 <span class="rating-star gray-star">
                                    <i class="fa fa-star" aria-hidden="true"></i> 
                                 </span>
                              @endif
                           </div>
                           <div class="profile-price">
                              @if ($user->profile_price)
                                 ${{ $user->profile_price }}+
                              @endif
                           </div>
                        </div>
                     </div>
                  </div>
               @endforeach              
            </div>
         </div>
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
      </div>
   </div>
</div>