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
                                class="action-btn btn-accept mx-2"
                                id="updateOrderStatus"            
                                data-order-id="{{ $order->id }}"
                                data-status="accepted"
                            >
                                Accept
                            </a>
                            @break
                        @case('accepted')
                            <a
                                href="javascript:void();"
                                class="action-btn btn-accept"
                            >
                                Accepted
                            </a>
                            @break
                        @case('declined')
                            <a
                                href="javascript:void();"
                                class="action-btn btn-accept"
                            >
                                Declined
                            </a>
                            @break
                        @case('completed')
                            <a
                                href="javascript:void();"
                                class="action-btn btn-accept"
                            >
                                Delivered
                            </a>
                            @break
                    @endswitch                    
                </div>
            </div>
        </div>
        <div class="d-flex mb-4 justify-content-between page-head-title align-items-center">
            <h3 class="section-title">
                Personalized {{ $order->product }} 
                <span class="section-sb-title">
                    @if ($order->mark)
                        ({{ $order->mark }})
                    @endif
                </span>
            </h3>
            <div class="order-delivery-date">Delivery Date: <span>02 Aug 2022</span></div>
        </div>
        {{ Form::open([
            'url' => route('deliverOrder'),
            'id' => 'deliverOrder',
            'class' => 'row g-4 order-details-form'
        ]) }}
            <div class="col-md-6">
                <div class="form-group">
                    <label for="" class="form-label">Who is this video for? <span>(Optional)</span></label>
                    <input type="text" class="form-control " value="{{ $order->orderDetail->product_for }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="" class="form-label">Who is this video from? <span>(Optional)</span></label>
                    <input type="text" class="form-control" value="{{ $order->orderDetail->product_from }}">
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label for="" class="form-label">Detail for John Doe to follow</label>
                    <textarea type="text" class="form-control " id="" placeholder="Type here" rows="4" cols="50">{{ $order->orderDetail->product_desc }}</textarea>
                </div>
            </div>
            @if ($order->status == 'accepted' || $order->status == 'completed')
                <div class="col-md-12">
                    <div class="form-group">
                        <h5>Delivered Order</h5>
                        <div class="video-upload-wrap">
                            {{ Form::hidden('order_id', $order->id) }}
                            {{ Form::hidden('type', $order->product) }}
                            {{ Form::file('product', ['class' => 'file-upload-input']) }}
                            <div class="drag-text">
                                <h6>Upload File</h6>
                            </div>
                        </div>
                        <div class="row">
                            @if (isset($order->deliverProduct))
                                @foreach ($order->deliverProduct as $product)
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
                                                @if ($product->type == 'Video')
                                                    <span class="vdo-play-btn">
                                                        <i class="fa fa-play"></i>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif      
                        </div>
                    </div>
                </div>
                <div class="col-12 text-end mt-sm-5 mt-4">
                    {{ Form::button('Deliver', [
                      'class' => 'btn custom-btn-main',
                      'id' => 'deliverOrderBtn',
                      'type' => 'submit'
                   ]) }}
                </div>
            @endif
        {{ Form::close() }} 
    </div>
</section>
@endsection
@section('customModal')
    <div class="modal fade custom-model-design" id="orderStatusModal" tabindex="-1" aria-labelledby="decline-request-label" aria-modal="true" role="dialog" style="display: none;">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">   
                <form action="{{ route('updateOrderStatus') }}" method="post" id="updateOrderStatusForm">
                    @csrf
                    <div class="modal-body">
                        <div class="custom-model-inner text-start">
                            <div class="form-group">
                                <label for="" class="form-label orderStatusLabel">
                                                                        
                                </label>
                                <textarea type="text" class="form-control" name="reasone" id="declineReason" placeholder="This helps the buyer understand why there purchase was declined" rows="4" cols="50"></textarea>
                                <div class="form-text text-end">Max 200 Characters</div>
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
         $('#deliverOrderBtn').attr('disabled');
         $('#deliverOrderBtn').html('Processing <i class="fa fa-spinner fa-spin"></i>');      
         $.ajax({
            headers: {
              'X-CSRF-Token': $('input[name="_token"]').val()
            },
            type: 'post',
            url: "{{ route('deliverOrder') }}",
            data: serializedData,
            dataType: 'json',
            processData: false,
            contentType: false,
            cache: false,
            success: function(data) {
               if (data.status == true) {
                  $('#deliverOrderBtn').html('Delivered');
                  $('.successMsg').html(data.message);
                  $("#successModel").modal("show");
               } else {
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