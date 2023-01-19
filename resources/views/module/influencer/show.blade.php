@extends('layout.master')
@section('content')
{{ Breadcrumbs::render('influencerDetail', $user) }}
<section class="pt-4 pb-5 influencer-details-section">
   <div class="container">
      <div class="d-flex mb-4">
         <h3 class="section-title">            
            {!! bussIcon($user->id) !!} {{ $user->name }}
         </h3>
      </div>
      <div class="row">
         <div class="col-lg-7">
            <div class="influencers-details-left">
               <div class="carousel-wrap introVideoSec">
                  @if (isset ($profileDetail->intro_video ))
                     <div class="owl-carousel influencers-img-carousel owl-loaded owl-drag">
                        <div class="owl-stage-outer">
                           <div class="owl-stage" style="transform: translate3d(-2245px, 0px, 0px); transition: all 0.25s ease 0s; width: 5240px;">
                              <div class="owl-item active" style="width: 728.5px; margin-right: 20px;">
                                 <div class="influencers-item">
                                    <div class="influencers-img">
                                       @if (!empty($profileDetail->intro_video ))
                                          <video width="100%" height="400" controls>
                                             <source src="{{ $profileDetail->intro_video }}" type="video/mp4" class="img-fluid">
                                             <source src="movie.ogg" type="video/ogg">
                                          </video>
                                       @endif                                    
                                    </div>
                                 </div>
                              </div>  
                           </div>
                        </div>                    
                     </div>                  
                  @endif
               </div>
               <div class="carousel-wrap d-none introPhotoSlider">
                  @if (isset ($introPhotos) && count($introPhotos) > 0)
                     <div class="owl-carousel influencers-img-carousel owl-loaded owl-drag">
                        <div class="owl-stage-outer">
                           <div class="owl-stage" style="transform: translate3d(-2245px, 0px, 0px); transition: all 0.25s ease 0s; width: 5240px;">
                              @foreach ($introPhotos as $introPhoto)                    
                                 <div class="owl-item active" style="width: 728.5px; margin-right: 20px;">
                                    <div class="influencers-item">
                                       <div class="influencers-img">
                                          <img src="{{ $introPhoto->name }}" class="img-fluid" style="height: 400px;"> 
                                       </div>
                                    </div>
                                 </div>
                              @endforeach                                                    
                           </div>
                        </div>
                        <div class="owl-nav"><button type="button" role="presentation" class="owl-prev"><i class="fa fa-chevron-left"></i></button><button type="button" role="presentation" class="owl-next"><i class="fa fa-chevron-right"></i></button></div>
                        <div class="owl-dots"><button role="button" class="owl-dot"><span></span></button><button role="button" class="owl-dot active"><span></span></button><button role="button" class="owl-dot"><span></span></button></div>
                     </div>                  
                  @endif
               </div>
               @if (!isset($profileDetail->intro_video) && count($introPhotos) == 0)
                  No Videos/Photos have been added
               @endif
               <div class="influencers-details-left-tags">
                  @if (isset ($profileDetail->intro_video ))
                     <button type="button" class="tags-item active-tag-item introVideoBtn">Videos</button>
                  @endif
                  @if (isset ($introPhotos) && count($introPhotos) > 0)
                     <button type="button" class="tags-item introPhotoBtn">Photos</button>
                  @endif
               </div>
            </div>
         </div>
         <div class="col-lg-5">
            <div class="influencers-details-right">
               <div class="influencers-info-tp d-flex">
                  <div class="influencers-rating">
                     <div>
                        @php
                           $i = 0;
                           $grayStar = 5 - $user->rating;
                        @endphp
                        @if ($user->rating)
                           @for ($i = 1; $i <= $user->rating; $i++)
                              <span class="rating-star">
                                 <i class="fa fa-star" aria-hidden="true"></i>
                              </span>
                           @endfor
                           @for ($i = 1; $i <= $grayStar; $i++)
                              <span class="rating-un-star">
                                 <i class="fa fa-star" aria-hidden="true"></i>
                              </span>
                           @endfor
                           <h6 class="rating-value"> {{ $user->rating }}
                              <span>({{ $user->rating }} Ratings)</span>
                           </h6>
                        @else
                           <span>There is no rating yet</span>
                        @endif
                     </div>
                  </div>
                  <div class="ms-auto">
                     <span
                        class="@if (Auth::user()) {{ @$user->stared ? 'unStarInfluencer' : 'starInfluencer' }}  @else {{ 'loginAlert' }} @endif"
                        data-collection-id="{{ @$user->stared }}"
                        data-id="{{ @$user->id }}"
                        style="cursor: pointer;"
                        >
                        <img
                           src="{{ asset('assets/img/logo-icon1.svg') }}"
                           class="{{ $user->stared ? '' : 'logo-gray' }}"
                        >
                    </span>
                     {{-- <img
                        src="{{ asset('assets/img/logo-icon1.svg') }}"
                        class="{{ $user->stared == 1 ? '' : 'logo-gray' }}"
                     > --}}
                  </div>
               </div>
               <div class="influencers-details-info">
                  <h4>Select Category</h4>
                  @if (isset($profilePersonalize->check_cat) && count($profilePersonalize->check_cat) > 0)
                     <div class="influencers-category-actions d-flex flex-column" id="accordionExample">
                        <form action="{{ route('order.info') }}" method="post">
                           @csrf
                           <a href="javascript:void(0);" class="influencers-category-btn {{DNoneClass('photo', $user->id)}}" data-bs-toggle="collapse" data-bs-target="#personalized-photo" aria-expanded="false" aria-controls="personalized-photo">
                              <span><img src="{{ asset('assets/img/photo-icon.svg') }}"></span> Personalized Photo 
                              <div class="category-value photoSelectedPrice">                              
                                 ${{ $profilePersonalize->photo_price }}+
                              </div>
                           </a>
                           <div id="personalized-photo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                              <div class="accordion-body">
                                 @include('.module.component.seller-product', [
                                    'category' => 'photo_with_watermark',
                                    'data' => $profilePersonalize->photo_with_watermark
                                 ])
                                 @include('.module.component.seller-product', [
                                    'category' => 'photo_with_out_watermark',
                                    'data' => $profilePersonalize->photo_with_out_watermark
                                 ])                              
                                 <!--Delivery Type Dropdown-->
                                 @include('module.component.delivery-type', [
                                    'type' => 'photo',
                                    'data' => $profilePersonalize->photo_type
                                 ])                              
                              </div>
                           </div>
                           <a href="javascript:void(0);" class="influencers-category-btn {{DNoneClass('video', $user->id)}}" data-bs-toggle="collapse" data-bs-target="#personalized-video" aria-expanded="false" aria-controls="personalized-video">
                              <span><img src="{{ asset('assets/img/video-icon.svg') }}"></span> Personalized Video 
                              <div class="category-value videoSelectedPrice">
                                 ${{ @$profilePersonalize->video_price }}+
                              </div>
                           </a>
                           <div id="personalized-video" class="accordion-collapse collapse " data-bs-parent="#accordionExample">
                              <div class="accordion-body">
                                 @include('.module.component.seller-product', [
                                    'category' => 'video_with_watermark',
                                    'data' => $profilePersonalize->video_with_watermark
                                 ])
                                 @include('.module.component.seller-product', [
                                    'category' => 'video_with_out_watermark',
                                    'data' => $profilePersonalize->video_with_out_watermark
                                 ])                                                          
                                 <!--Delivery Type Dropdown-->
                                 @include('module.component.delivery-type', [
                                    'type' => 'video',
                                    'data' => $profilePersonalize->video_type
                                 ])
                              </div>
                           </div>
                           <a href="javascript:void(0);" class="influencers-category-btn {{DNoneClass('media', $user->id)}}" data-bs-toggle="collapse" data-bs-target="#personalized-social-post" aria-expanded="false" aria-controls="personalized-social-post">
                              <span>
                                 <img src="{{ asset('assets/img/social-post-icon.svg') }}">
                              </span>
                                 Social Media Post 
                              <div class="category-value postSelectedPrice">
                                 ${{ $profilePersonalize->social_price }}+
                              </div>
                           </a>
                           <div id="personalized-social-post" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                              <div class="accordion-body">
                                 @include('.module.component.seller-product', [
                                    'category' => 'facebook_price',
                                    'data' => $profilePersonalize->facebook_price
                                 ])
                                 @include('.module.component.seller-product', [
                                    'category' => 'instagram_price',
                                    'data' => $profilePersonalize->instagram_price
                                 ])
                                 @include('.module.component.seller-product', [
                                    'category' => 'twitter_price',
                                    'data' => $profilePersonalize->twitter_price
                                 ])                                                        
                              </div>
                           </div>
                           <input type="hidden" name="influencer_id" value="{{ Request::segment(3) }}">
                           <button
                              type="submit"
                              class="apply-btn mt-4"
                           >
                              Continue
                           </button>
                        </form>
                     </div>
                  @else
                     <p>No category added!</p>
                  @endif
                  <hr class="mt-4">
                  <div class="influencers-social-share">
                     <ul>
                        @if (@$profileDetail->twitter)
                           <li>
                              <a href="{{ $profileDetail->twitter }}" target="_blank">
                                 <img src="{{ asset('assets/img/twitter-icon.svg') }}">
                              </a>
                           </li>
                        @endif
                        @if (@$profileDetail->facebook)
                           <li>
                              <a href="{{ $profileDetail->facebook }}" target="_blank">
                                 <img src="{{ asset('assets/img/facebook-icon.svg') }}">
                              </a>
                           </li>
                        @endif
                        @if (@$profileDetail->instagram)
                           <li>
                              <a href="{{ $profileDetail->instagram }}" target="_blank">
                                 <img src="{{ asset('assets/img/instagram-icon.svg') }}">
                              </a>
                           </li>
                        @endif
                        @if (@$profileDetail->youtube)
                           <li>
                              <a href="{{ $profileDetail->youtube }}" target="_blank">
                                 <img src="{{ asset('assets/img/youtube-icon.svg') }}">
                              </a>
                           </li>
                        @endif
                        @if (@$profileDetail->tiktok)
                           <li>
                              <a href="{{ $profileDetail->tiktok }}" target="_blank">
                                 <img src="{{ asset('assets/img/tiktok-icon.svg') }}">
                              </a>
                           </li>
                        @endif
                        @if (@$profileDetail->emails)
                           <li>
                              <a href="{{ $profileDetail->emails }}" target="_blank">
                                 <img src="{{ asset('assets/img/emails-icon.svg') }}">
                              </a>
                           </li>
                        @endif                                                                        
                     </ul>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-12">
            <div class="influencers-details-about mt-md-5 mt-4">
               <div class="d-flex mb-2">
                  <h3 class="section-title">About</h3>
               </div>
               <p class="about-content" style="height: 100px; overflow: hidden;">
                  {{ @$profileDetail->about }}
               </p>
               @if (isset($profileDetail->about) && strlen($profileDetail->about) > 1000)
                  <span class="d-flex justify-content-end">
                     <button class="btn seeMoreAbout">See more</button>                  
                  </span>
               @endif
            </div>
         </div>
         <div class="col-md-12">
            <div class="influencers-details-reviews mt-md-5 mt-3">
               <div class="d-flex mb-3">
                  <h3 class="section-title">Reviews</h3>
               </div>
               <div class="reviews-lists">
                  <ul>
                     @if (count($user->reviews) > 0)
                        @foreach ($user->reviews as $review)
                        <li>
                           <div class="reviews-avatar-img">
                              <img src="{{ getUserImageById($review->user_id) }}" class="profile-image" alt="img">
                           </div>
                           <div class="reviews-text">
                              <div class="reviews-rating">
                                 @php
                                    $grayStar = 5 - $review->rating;
                                 @endphp
                                 @for ($i = 1; $i <= $review->rating; $i++)
                                    <span class="rating-star">
                                       <i class="fa fa-star" aria-hidden="true"></i>
                                    </span>
                                 @endfor
                                 @for ($i = 1; $i <= $grayStar; $i++)
                                    <span class="rating-un-star">
                                       <i class="fa fa-star" aria-hidden="true"></i>
                                    </span>
                                 @endfor                                 
                              </div>
                              <h5>{{ getUserNameById($review->user_id) }}</h5>
                              <p>{{ $review->review }}</p>
                           </div>
                        </li>
                        @endforeach
                        <div class="justify-content-center d-flex">
                           @include('module.component.pagination', [
                              'pagination' => $user->reviews,
                           ])
                        </div>
                     @else
                        No Review found!
                     @endif                 
                  </ul>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<section class="recommended-profiles">
   @if (count(getInfluencers('recommended')) > 0)     
      @include('module.component.influencers', [
         'users' => getInfluencers('recommended'),
         'title' => 'Recommended',
         'platform' => 'recommended'
      ]) 
   @endif
</section>
<section class="pt-5 pb-5 recently-viewed">
   @if (count(getInfluencers('recentlyViewed')) > 0)
      @include('module.component.influencers', [
         'users' => getInfluencers('recentlyViewed'),
         'title' => 'Recently Viewed',
         'platform' => 'recentlyViewed'
      ])           
   @endif
</section>
@endsection
@section('customScript')
   <script type="text/javascript">
      $(document).on('click', '.videoPrice', function(){
         var price = $(this).data('price');
         $('.videoSelectedPrice').html('$'+price+'+');
      });

      $(document).on('click', '.photoPrice', function(){
         var price = $(this).data('price');
         $('.photoSelectedPrice').html('$'+price+'+');
      });

      $(document).on('click', '.postPrice', function(){
         var price = $(this).data('price');
         $('.postSelectedPrice').html('$'+price+'+');
      });

      $(document).on('click', '.introPhotoBtn', function(){
         $(this).addClass('active-tag-item');
         $('.introVideoBtn').removeClass('active-tag-item');
         $('.introPhotoSlider').removeClass('d-none');
         $('.introVideoSec').addClass('d-none');
      });

      $(document).on('click', '.introVideoBtn', function(){
         $(this).addClass('active-tag-item');
         $('.introPhotoBtn').removeClass('active-tag-item');
         $('.introVideoSec').removeClass('d-none');
         $('.introPhotoSlider').addClass('d-none');
      });

      $(document).on('click', '.personalized-options-item', function(){
         $('.personalized-options-item').removeClass('selectedCategory');
         $(".personalized-options-item > input[type='hidden']").remove();     
         var item = $(this).data('item');
         $(this).toggleClass('selectedCategory');
         if ($(this).hasClass("selectedCategory")) {
            $('<input>').attr({
               type: 'hidden',
               name: 'order_item',
               value: item
            }).appendTo($(this));
         } else {
            $("input[type='hidden'][name='"+name+"']").remove();
         }        
      });

      $(document).on('click', '.seeMoreAbout', function(){
         $('.about-content').toggleClass('show-more');
         if ($('.about-content').hasClass('show-more')) {
            $('.about-content').css({height: "auto"});
            $(this).html('See less');
         } else {
            $('.about-content').css({height: "100px"});
            $(this).html('See more');
         }
      });
   </script>
@endsection
