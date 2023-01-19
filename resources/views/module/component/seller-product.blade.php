@switch($category)
   @case('photo_with_watermark')
      @if (isset($data))
         <div class="personalized-options-item" data-item="photo_with_watermark">
            <h5 class="catHeading photoPrice" data-price="{{ @$data }}">Personalized Photo <span>(With Watermark)</span></h5>
            <div class="personalized-value photoPrice" data-price="{{ @$data }}">${{ @$data }}+</div>
         </div>
      @endif
   @break
   @case('photo_with_out_watermark')
      @if (isset($data))
      <div class="personalized-options-item" data-item="photo_with_out_watermark">
         <h5 class="catHeading photoPrice" data-price="{{ @$data }}">Personalized Photo <span>(With Out Watermark)</span></h5>
         <div class="personalized-value photoPrice" data-price="{{ @$data }}">${{ @$data }}+</div>
      </div>
      @endif
   @break
   @case('video_with_watermark')
      @if (isset($data))
         <div class="personalized-options-item" data-item="video_with_watermark">
            <h5 class="catHeading videoPrice" data-price="{{ @$data }}">Personalized Video <span>(With Watermark)</span></h5>
            <div class="personalized-value videoPrice" data-price="{{ @$data }}">${{ @$data }}+</div>
         </div>
      @endif
   @break
   @case('video_with_out_watermark')
      @if (isset($data))
         <div class="personalized-options-item" data-item="video_with_out_watermark">
            <h5 class="catHeading videoPrice" data-price="{{ @$data }}">Personalized Video <span>(Without Watermark)</span></h5>
            <div class="personalized-value videoPrice" data-price="{{ @$data }}"> ${{ @$data }}+</div>
         </div>
      @endif
   @break
   @case('facebook_price')
      @if (isset($data))
         <div class="personalized-options-item" data-item="facebook_price">
            <h5 class="catHeading postPrice" data-price="{{ @$data }}">Facebook</h5>
            <div class="personalized-value postPrice" data-price="{{ @$data }}">${{ @$data }}+</div>
         </div>
      @endif
   @break
   @case('instagram_price')
      @if (isset($data))
         <div class="personalized-options-item" data-item="instagram_price">
            <h5 class="catHeading postPrice" data-price="{{ @$data }}">Instagram</h5>
            <div class="personalized-value postPrice" data-price="{{ @$data }}">${{ @$data }}+</div>
         </div>
      @endif
   @break
   @case('twitter_price')
      @if (isset($data))
         <div class="personalized-options-item" data-item="twitter_price">
            <h5 class="catHeading postPrice" data-price="{{ @$data }}">Twitter</h5>
            <div class="personalized-value postPrice" data-price="{{ @$data }}">${{ @$data }}+</div>
         </div>
      @endif
   @break
@endswitch