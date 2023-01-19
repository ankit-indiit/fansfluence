@extends('layout.master')
@section('content')
<section class="pt-5 pb-5 order-details-section">
    <div class="container">
        <div class="influencers-user-name mt-3 mb-5 d-flex align-items-center">
            <div class="d-flex align-items-center">
                <div class="influencers-user-img me-3">
                    <img src="{{ getUserImageById($order->user_id) }}">
                </div>
                <h5 class="m-0">{{ getUserNameById($order->user_id) }}</h5>
            </div>
            <div class="ms-auto">
                <div class="action-group-btn">
                    @switch($order->status)
                        @case('pending')
                            <a
                                href="javascript:void();"
                                class="action-btn btn-accept text-light mx-2"
                                id="acceptOrder"            
                                data-order-id="{{ $order->id }}"
                                data-status="accept"
                            >
                                Accept
                            </a>
                            @break
                        @case('accept')
                            <a
                                href="javascript:void();"
                                class="action-btn btn-accept text-light"
                            >
                                Accepted
                            </a>
                            @break
                        @case('decline')
                            <a
                                href="javascript:void();"
                                class="action-btn btn-accept text-light"
                            >
                                Declined
                            </a>
                            @break
                        @case('delivered')
                            <a
                                href="javascript:void();"
                                class="action-btn btn-accept text-light"
                            >
                                Delivered
                            </a>
                            @break
                        @case('completed')
                            <a
                                href="javascript:void();"
                                class="action-btn btn-accept text-light"
                            >
                                Completed
                            </a>
                            @break
                    @endswitch                    
                </div>
            </div>
        </div>
        <div class="d-flex mb-4 justify-content-between page-head-title align-items-center">
            <h3 class="section-title">
                {{--{!! bussIcon($order->orderDetail->user_id) !!}--}} Personalized {{ $order->product }} 
                <span class="section-sb-title">
                    @if ($order->mark)
                        ({{ $order->mark }})
                    @endif
                </span>
            </h3>
            <div class="order-delivery-date">
                Delivery Date: <span>{{ $order->orderDetail->delivery_date }}</span>
            </div>
        </div>
        {{ Form::open([
            'url' => route('order.deliver'),
            'id' => 'deliverOrder',
            'class' => 'row g-4 order-details-form'
        ]) }}
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
                                        Detail for {{Auth::user()->name}} to follow
                                    </label>
                                    <textarea type="text" class="form-control" readonly>{{ $value }}</textarea>
                                @break
                                @case('to_follow')
                                    <label for="" class="form-label">
                                        Detail for {{Auth::user()->name}} to follow
                                    </label>
                                    <textarea type="text" class="form-control" readonly>{{ $value }}</textarea>
                                @break
                                @default
                                    <label for="" class="form-label">
                                        {{ str_replace('_', ' ', $key) }}
                                    </label>
                                    <textarea type="text" class="form-control" readonly>{{ $value }}</textarea>
                                @break
                            @endswitch
                        </div>
                    </div>                       
                @endforeach
            @endif
            @if ($order->status == 'accept' || $order->status == 'delivered' || $order->status == 'completed')
                <div class="col-md-12">
                    <div class="form-group">
                        @php
                            if ($order->product == 'Photo') {
                                $type = 'image/png, image/jpeg';
                            } elseif ($order->product == 'Video') {
                                $type = 'video/mp4,video/x-m4v,video/*';
                            } else {
                                $type = '';
                            }
                        @endphp
                        @if ($order->status == 'accept' && $order->customer_id != '')
                            <h5>Delivered Order</h5>
                            <div class="video-upload-wrap">
                                {{ Form::hidden('order_id', $order->id) }}
                                {{ Form::hidden('type', $order->product) }}
                                {{ Form::file('product', [
                                        'class' => 'file-upload-input', 
                                        'id' => 'imgInp',
                                        'accept' => $type
                                    ]) 
                                }}
                                <div class="drag-text">
                                    <h6>Upload {{ $order->product }}</h6>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 previewProduct text-center py-4">
                                    
                                </div>
                            </div>
                        @endif
                        <div class="row">
                            @if (isset($order->deliverProduct))
                                @foreach ($order->deliverProduct as $product)
                                    @if ($product->product_exe == 'mp4' || $product->product_exe == 'mov' || $product->product_exe == 'webm' || $product->product_exe == 'mkv')
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <div class="order-deliver-video position-relative mt-3">
                                                    <video style="width: 100%;">
                                                        <source src="{{ $product->product }}"  class="img-fluid" width="410px" height="340px">
                                                    </video>
                                                    <span class="vdo-dwnld-btn">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                                                            <line x1="18" y1="6" x2="6" y2="18"></line>
                                                            <line x1="6" y1="6" x2="18" y2="18"></line>
                                                        </svg>
                                                    </span>
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
                                                <div class="order-deliver-video position-relative mt-3">
                                                    <img src="{{ $product->product }}" width="410px" height="340px">
                                                    <span class="vdo-dwnld-btn">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                                                            <line x1="18" y1="6" x2="6" y2="18"></line>
                                                            <line x1="6" y1="6" x2="18" y2="18"></line>
                                                        </svg>
                                                    </span>     
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @endif      
                        </div>                        
                    </div>
                </div>
                @if ($order->payment_type == 'paypal' && $order->customer_id != '' && $order->status == 'accept' || $order->payment_type == 'stripe' && $order->status == 'accept')
                    <div class="col-12 text-end mt-sm-5 mt-4">
                        {{ Form::button('Deliver', [
                          'class' => 'btn custom-btn-main',
                          'id' => 'deliverOrderBtn',
                          'type' => 'submit'
                       ]) }}
                    </div>
                @else
                    @if ($order->status == 'accept')
                        <p class="text-center text-danger">Payment has not done yet by buyer side!</p>
                    @endif
                @endif
            @endif
        {{ Form::close() }}
        <div class="row mt-4">
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
        </div>
    </div>
</section>
@endsection
@section('customModal')
    <div class="modal fade custom-model-design" id="orderStatusModal" tabindex="-1" aria-labelledby="decline-request-label" aria-modal="true" role="dialog" style="display: none;">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">   
                <form action="{{ route('order.status') }}" method="post" id="updateOrderStatusForm">
                    @csrf
                    <div class="modal-body">
                        <div class="custom-model-inner text-start">
                            <div class="form-group">
                                <label for="" class="form-label orderStatusLabel">
                                                                        
                                </label>
                                <textarea type="text" class="form-control" name="reasone" id="declineReason" placeholder="This helps the buyer understand why there purchase was declined" rows="4" cols="50"></textarea>
                                {{-- <div class="form-text text-end">Max 200 Characters</div> --}}
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="order_id" id="orderId">
                    <input type="hidden" name="status" id="status">
                    <div class="modal-footer">
                        <button type="button" class="btn custom-btn-outline me-3" data-bs-dismiss="modal">
                            Cancel
                        </button>
                        <button type="submit" class="btn custom-btn-main text-capitalize" id="updateOrderStatusFormBtn">
                            
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>    
@endsection
@section('customScript')
<script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
<script type="text/javascript">
    $(document).on('change', '.file-upload-input', function(){
        var imageExtension = ['ras', 'xwd', 'bmp', 'jpe', 'jpg', 'jpeg', 'xpm', 'ief', 'pbm', 'tif', 'gif', 'ppm', 'xbm', 'tiff', 'rgb', 'pgm', 'png', 'pnm'];
        var videoExtension = ['m1v', 'webm', 'mpeg', 'mov', 'qt', 'mpa', 'mpg', 'mpe', 'avi', 'movie', 'mp4'];
        const [file] = imgInp.files
        var fileExt = $(this).val().split('.').pop().toLowerCase();
        if (fileExt == 'jpe' || fileExt == 'jpeg' || fileExt == 'png' || fileExt == 'jpg') {
            $('.previewProduct').html('<img src="'+URL.createObjectURL(file)+'" width="200px">');
        } else {
            $('.previewProduct').html('<iframe src="'+URL.createObjectURL(file)+'" style="width: 200px; height: 126px;"></iframe>');            
        }
    });

    $(document).on('click', '#updateOrderStatus', function(){
        var orderId = $(this).data('order-id');
        var status = $(this).data('status');
        $('#orderId').val(orderId);
        $('#status').val(status);
        $('.orderStatusLabel').html('Resone for '+ status + ' (optional)');
        $('#updateOrderStatusFormBtn').html(status);
        $('#orderStatusModal').modal('show');             
        if($("#orderStatusModal").hasClass("show")){
        
        } else {
            $('#updateOrderStatusForm').trigger("reset");
        }
    });

    $("#deliverOrder").validate({    
      rules: {
         product: {
            required: true,
         },                 
      },
      messages: {
         product: "Please choose product! ",        
      },
      submitHandler: function(form) {
         var serializedData = new FormData(form);
         $("#err_mess").html('');
         $('#deliverOrderBtn').attr('disabled', true);
         $('#deliverOrderBtn').html('Processing <i class="fa fa-spinner fa-spin"></i>');      
         $.ajax({
            headers: {
              'X-CSRF-Token': $('input[name="_token"]').val()
            },
            type: 'post',
            url: "{{ route('order.deliver') }}",
            data: serializedData,
            dataType: 'json',
            processData: false,
            contentType: false,
            cache: false,
            success: function(data) {
                if (data.status == true) {
                    $('#deliverOrderBtn').attr('disabled', true);
                    $('#deliverOrderBtn').html('Delivered');
                    $('.successMsg').html(data.message);
                    $("#successModel").modal("show");
                    $('.okMsgBtn').on('click', function(){
                        window.location.reload();
                    });
                } else {
                    $('#deliverOrderBtn').attr('disabled', false);
                    $('#deliverOrderBtn').html('Deliver');
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