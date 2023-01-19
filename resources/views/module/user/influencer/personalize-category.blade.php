@if ($category == 'media')
   <a
      href="javascript:void(0);"
      class="influencers-category-btn {{ $category }} {{ @DNoneClass($category) }}"
      data-bs-toggle="collapse"
      data-bs-target="#personalized-post"
      aria-expanded="false"
      aria-controls="personalized-post"
   >
      <span><img src="{{ asset('assets/img/video-icon.svg') }}"></span> Social Media Post 
   </a>
   <div id="personalized-post" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
      <div class="accordion-body">
         <div class="categories-personalized">
            <div class="form-check">
               <input
                  class="form-check-input personalizeSocial"
                  type="checkbox"
                  id="facebookPrice"
                  data-type="facebook"
                  {{ @$personalize->facebook_price ? 'checked' : '' }}
               >
               <label class="form-check-label" for="facebookPrice">
               Facebook
               </label>
            </div>
            <div class="personalized-price-fields facebook {{ @$personalize->facebook_price ? '' : 'd-none' }}">
               <input
                  type="text"
                  name="facebook_price"
                  placeholder="$ Price"
                  class="form-control"
                  value="{{ @$personalize->facebook_price }}"
               >
            </div>
         </div>
         <div class="categories-personalized">
            <div class="form-check">
               <input
                  class="form-check-input personalizeSocial"
                  type="checkbox"
                  id="instagram"
                  data-type="instagram"
                  {{ @$personalize->instagram_price ? 'checked' : '' }}
               >
               <label class="form-check-label" for="instagram">
               Instagram
               </label>
            </div>
            <div class="personalized-price-fields instagram {{ @$personalize->instagram_price ? '' : 'd-none' }}">
               <input
                  type="text"
                  name="instagram_price"
                  placeholder="$ Price"
                  class="form-control"
                  value="{{ @$personalize->instagram_price }}"
               >
            </div>
         </div>     
         <div class="categories-personalized">
            <div class="form-check">
               <input
                  class="form-check-input personalizeSocial"
                  type="checkbox"
                  id="twitter"
                  data-type="twitter"
                  {{ @$personalize->twitter_price ? 'checked' : '' }}
               >
               <label class="form-check-label" for="twitter">
               Twitter
               </label>
            </div>
            <div class="personalized-price-fields twitter {{ @$personalize->twitter_price ? '' : 'd-none' }}">
               <input
                  type="text"
                  name="twitter_price"
                  placeholder="$ Price"
                  class="form-control"
                  value="{{ @$personalize->twitter_price }}"
               >
            </div>
         </div>                                                            
      </div>
   </div>
@else 
   <a
      href="javascript:void(0);"
      class="influencers-category-btn {{ $category }} {{ @DNoneClass($category) }}"
      data-bs-toggle="collapse"
      data-bs-target="#personalized-{{ $category }}"
      aria-expanded="false"
      aria-controls="personalized-photo"
   >
      <span><img src="{{ asset('assets/img/photo-icon.svg') }}"></span> Personalized {{ ucfirst($category) }} 
   </a>
   <div id="personalized-{{ $category }}" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
      <div class="accordion-body">
         <div class="categories-personalized">
            <div class="form-check">
               <input
                  class="form-check-input personalizePrice"
                  type="checkbox"
                  id="{{$category}}WaterMark"
                  data-type="{{$category}}With"
                  {{ @price($category.'WaterMark') ? 'checked' : '' }}
               >
               <label class="form-check-label" for="{{$category}}WaterMark">
               With Watermark
               </label>
            </div>
            <div class="personalized-price-fields {{$category}}WithWaterMarkPrice {{ @$personalize->photo_with_watermark ? '' : 'd-none' }}">
               <input
                  type="text"
                  name="{{$category}}_with_watermark"
                  placeholder="$ Price"
                  class="form-control"
                  value="{{ @price($category.'WaterMark') }}"
               >
            </div>
         </div>
         <div class="categories-personalized">
            <div class="form-check">
               <input
                  class="form-check-input personalizePrice"
                  type="checkbox"
                  id="{{$category}}WithOutWaterMark"
                  data-type="{{$category}}WithOut"
                  {{ @price($category.'WithOutWaterMark') ? 'checked' : '' }}
               >
               <label class="form-check-label" for="{{$category}}WithOutWaterMark">
               Without Watermark
               </label>
            </div>
            <div class="personalized-price-fields {{$category}}WithOutWaterMarkPrice {{ @$personalize->photo_with_out_watermark ? '' : 'd-none' }}">
               <input
                  type="text"
                  name="{{$category}}_with_out_watermark"
                  placeholder="$ Price"
                  class="form-control"
                  value="{{ @price($category.'WithOutWaterMark') }}"
               >
            </div>
         </div>
         <div class="form-group">
            @php
               $type = $category.'_type';
            @endphp
            <label for="inputState" class="form-label text-red">Delivery</label>
            <div class="dropdown">
               <button class="select-dropdown dropdown-toggle" type="button" id="{{$category}}DeliveryType" data-bs-toggle="dropdown" aria-expanded="false">
               {{ @$personalize->$type ? str_replace('_', ' ', ucfirst($personalize->$type)) : 'Select Delivery Type'}}
               </button>
               <div class="dropdown-menu custom-select-dropdown-options" aria-labelledby="{{$category}}DeliveryType">
                  <div class="form-check">
                     <label class="form-check-label" for="{{$category}}BuyerDeside">
                     Buyer Decides
                     </label>
                     <input
                        class="form-check-input {{$category}}DeliveryType"
                        type="radio"
                        value="buyer_decides"
                        name="{{$category}}DeliveryType"
                        id="{{$category}}BuyerDeside"
                        data-option="Buyer Decides"
                     >
                  </div>
                  <div class="form-check">
                     <label class="form-check-label" for="{{$category}}MobileOnly">
                     Mobile Only
                     </label>
                     <input
                        class="form-check-input {{$category}}DeliveryType"
                        type="radio"
                        value="mobile_only"
                        name="{{$category}}DeliveryType"
                        id="{{$category}}MobileOnly"
                        data-option="Mobile Only"
                     >
                  </div>
                  <div class="form-check">
                     <label class="form-check-label" for="{{$category}}DesktopOnly">
                     Desktop Only
                     </label>
                     <input
                        class="form-check-input {{$category}}DeliveryType"
                        type="radio"
                        value="desktop_only"
                        name="{{$category}}DeliveryType"
                        id="{{$category}}DesktopOnly"
                        data-option="Desktop Only"
                     >
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
@endif