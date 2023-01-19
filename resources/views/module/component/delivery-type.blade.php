<div class="">
   <label for="inputState" class="form-label text-red">Delivery</label>
   <div class="dropdown">
      <button class="select-dropdown dropdown-toggle" type="button" id="{{$type}}DeliveryType" data-bs-toggle="dropdown" aria-expanded="false">
      Select Delivery Type
      </button>
      <div class="dropdown-menu custom-select-dropdown-options" aria-labelledby="{{$type}}DeliveryType">
         @if (isset($data))
            @if ($data == 'buyer_decides')
               <div class="form-check">
                  <label class="form-check-label" for="{{$type}}InfluencerDesides">
                  Influencer Decides
                  </label>
                  <input
                     class="form-check-input {{$type}}DeliveryType"
                     type="radio"
                     name="delevery_type"
                     value="Influencer Decides"
                     id="{{$type}}InfluencerDesides"
                     data-option="Influencer Decides"
                  >               
               </div>
               <div class="form-check">
                  <label class="form-check-label" for="{{$type}}Mobile">
                  Mobile
                  </label>
                  <input
                     class="form-check-input {{$type}}DeliveryType"
                     type="radio"
                     name="delevery_type"
                     value="Mobile"
                     id="{{$type}}Mobile"
                     data-option="Mobile"
                  >
               </div>
               <div class="form-check">
                  <label class="form-check-label" for="{{$type}}Desktop">
                  Desktop 
                  </label>
                  <input
                     class="form-check-input {{$type}}DeliveryType"
                     type="radio"
                     name="delevery_type"
                     value="Desktop"
                     id="{{$type}}Desktop"
                     data-option="Desktop"
                  >
               </div>
            @endif
            @if ($data == 'mobile_only')            
               <div class="form-check">
                  <label class="form-check-label" for="{{$type}}Mobile">
                  Mobile
                  </label>
                  <input
                     class="form-check-input {{$type}}DeliveryType"
                     type="radio"
                     name="delevery_type"
                     value="Mobile"
                     id="{{$type}}Mobile"
                     data-option="Mobile"
                  >
               </div>            
            @endif
            @if ($data == 'desktop_only')            
               <div class="form-check">
                  <label class="form-check-label" for="{{$type}}Mobile">
                  Mobile
                  </label>
                  <input
                     class="form-check-input {{$type}}DeliveryType"
                     type="radio"
                     name="delevery_type"
                     value="Mobile"
                     id="{{$type}}Mobile"
                     data-option="Mobile"
                  >
               </div>            
            @endif
         @else
            Not found!
         @endif
      </div>
   </div>
</div>