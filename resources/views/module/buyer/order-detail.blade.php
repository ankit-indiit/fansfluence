@extends('layout.master')
@section('content')
<section class="pt-5 pb-5 order-details-section">
   <div class="container">
      <div class="influencers-user-name mt-3 mb-5 d-flex align-items-center">
         <div class="influencers-user-img me-3">
            <img src="{{ $influencer->image }}">
         </div>
         <h5 class="m-0">{{ $influencer->name }}</h5>
      </div>
      <div class="d-flex mb-4 justify-content-between page-head-title align-items-center">
         {{-- <h3 class="section-title">{!! bussIcon($influencer->id) !!} Personalized {{ @$order->product }}  --}}
         <h3 class="section-title"> Personalized {{ @$order->product }} 
            <span class="section-sb-title">
               @if ($order->mark) 
                  ({{ @$order->mark }})
               @endif
            </span>
         </h3>
         <p class="tp-delivery-date">
            Delivery Date: <span>{{ $order->orderDetail->delivery_date }}</span>
         </p>
      </div>
      <form class="row g-4 order-details-form" action="{{ route('buyerReview') }}" method="post" id="buyerReview">
         @csrf
         @php
             $detail = $order->orderDetail->detail;                
         @endphp
         @if (!empty($detail) && count($detail) > 0)
             @foreach ($detail as $key => $value)
                 <div class="col-md-{{ $key == 'product_for' || $key == 'product_from' ? 6 : 12 }}">
                     <div class="form-group">
                         @switch($key)
                             @case('product_for')
                                 <label for="" class="form-label">
                                     Who is this {{ $order->product }} for? <span>(Optional)</span>
                                 </label>
                                 <input type="text" class="form-control" value="{{ $value }}" readonly>
                             @break
                             @case('product_from')
                                 <label for="" class="form-label">
                                     Who is this {{ $order->product }} from? <span>(Optional)</span>
                                 </label>
                                 <input type="text" class="form-control" value="{{ $value }}" readonly>
                             @break
                             @case('product_desc')
                                 <label for="" class="form-label">
                                     Detail for {{ $influencer->name }} to follow
                                 </label>
                                 <textarea type="text" class="form-control" readonly>{{ $value }}</textarea>
                             @break                                                          
                         @endswitch
                     </div>
                 </div>                       
             @endforeach
         @endif        
         @if (isset($order->deliverProduct))
            @foreach ($order->deliverProduct as $product)
               @if ($product->type == 'Video')
                  <div class="col-md-4">
                     <div class="form-group">
                        <h5>Delivered Order</h5>
                        <div class="order-deliver-video position-relative mt-3">
                           <video style="width: 100%;">
                             <source src="{{ $product->product }}"  class="img-fluid" width="410px" height="340px">
                           </video>
                           <a href="{{ route('downloadProduct', $product->id) }}">
                              <span class="vdo-dwnld-btn downloadProduct">
                                 <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                    <polyline points="7 10 12 15 17 10"></polyline>
                                    <line x1="12" y1="15" x2="12" y2="3"></line>
                                 </svg>
                              </span>
                           </a>
                           @if ($product->type == 'Video')
                              <span class="vdo-play-btn">
                                 <i class="fa fa-play"></i>
                              </span>
                           @endif
                        </div>
                     </div>
                  </div>
               @else
                  <div class="col-md-4">
                     <div class="form-group">
                        <h5>Delivered Order</h5>
                        <div class="order-deliver-video position-relative mt-3">
                           <img src="{{ $product->product }}" class="img-fluid">
                           <a href="{{ route('downloadProduct', $product->id) }}">
                              <span class="vdo-dwnld-btn downloadProduct">
                                 <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                    <polyline points="7 10 12 15 17 10"></polyline>
                                    <line x1="12" y1="15" x2="12" y2="3"></line>
                                 </svg>
                              </span>
                           </a>                           
                        </div>
                     </div>
                  </div>
               @endif
            @endforeach
            @if (!isset($review))
               <div class="col-md-12">
                  <div class="form-group add-order-review">
                     <label for="" class="form-label">Add a Review</label>
                      <div class="container">
                          <div class="starrating risingstar d-flex justify-content-center flex-row-reverse">
                              <input type="radio" id="star5" name="rating" value="5" />
                              <label for="star5" title="5 star"></label>
                              <input type="radio" id="star4" name="rating" value="4" />
                              <label for="star4" title="4 star"></label>
                              <input type="radio" id="star3" name="rating" value="3" />
                              <label for="star3" title="3 star"></label>
                              <input type="radio" id="star2" name="rating" value="2" />
                              <label for="star2" title="2 star"></label>
                              <input type="radio" id="star1" name="rating" value="1" />
                              <label for="star1" title="1 star"></label>
                          </div>
                          <span class="rating"></span>
                    </div>               
                     <input type="text" class="form-control " name="review" placeholder="Add a review....">
                  </div>
               </div>
               <input type="hidden" name="influencer_id" value="{{ @$order->orderDetail->influencer_id }}">
               <input type="hidden" name="user_id" value="{{ Auth::id() }}">
               <input type="hidden" name="order_id" value="{{ @$order->id }}">
               <div class="col-12 text-end mt-sm-5 mt-4">
                  <button type="submit" class="btn custom-btn-main" id="buyerReviewBtn">Submit</button>
               </div>
            @endif
            @if (isset($review))
               <div class="col-md-12">
                  <div class="reviews-lists">
                     <ul>
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
                              <p>{{ @$review->review }}</p>
                           </div>
                        </li>                                                                      
                     </ul>
                  </div>
               </div>           
            @endif  
         @endif
      </form>
   </div>
</section>
@endsection
@section('customScript')
<script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
<script type="text/javascript">
   $("#buyerReview").validate({    
      rules: {
         // rating: {
         //    required: true,
         // },
         // review: {
         //    required: true,
         // },                 
      },
      errorPlacement: function (error, element) {
          if (element.attr("name") == "rating") {
              error.appendTo($("."+element.attr("name")));
          } else {
              error.insertAfter(element);
          }
      },
      messages: {
         // rating: "Please choose star! ",        
         // review: "Please enter review! ",        
      },
      submitHandler: function(form) {
         var serializedData = new FormData(form);
         $("#err_mess").html('');
         $('#buyerReviewBtn').attr('disabled', true);
         $('#buyerReviewBtn').html('Processing <i class="fa fa-spinner fa-spin"></i>');      
         $.ajax({
            headers: {
              'X-CSRF-Token': $('input[name="_token"]').val()
            },
            type: 'post',
            url: "{{ route('buyerReview') }}",
            data: serializedData,
            dataType: 'json',
            processData: false,
            contentType: false,
            cache: false,
            success: function(data) {
               if (data.status == true) {
                  $('#buyerReviewBtn').attr('disabled', false);
                  $('#buyerReviewBtn').html('Submitted');
                  $('.successMsg').html(data.message);
                  $("#successModel").modal("show");
                  $('.okMsgBtn').on('click', function(){
                     window.location.reload();
                  });
               } else {
                  $('#buyerReviewBtn').attr('disabled', false);
                  $('#buyerReviewBtn').html('Submit');
                  $('.errorMsg').html(data.message);
                  $("#errorModel").modal("show");
               }
            }
         });
         return false;
      }
   });   
</script>
@endsection