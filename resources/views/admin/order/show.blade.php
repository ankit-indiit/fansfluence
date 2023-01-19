@extends('admin.layout.master')
@section('content')
<style type="text/css">
    .select2-container--default {
    width: 100% !important;
    }
</style>
<div class="page-wrapper">
<div class="content container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-table">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Order Detail</h4>
                    <a href="{{ URL::previous() }}" class="btn btn-default btnwhite">Back</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                        <div class="row">
                                            <div class="col-sm-12 col-md-6"></div>
                                        </div>
                                        <section class="h-100 gradient-custom">
                                            <div class="container py-5 h-100">
                                                <div class="row mb-4">
                                                    <div class="col-md-4">
                                                        <p class="text-muted my-2">Order Id : {{ @$order->order_id }}</p>
                                                        <p class="text-muted my-2">Buyer : {{ getUserNameById($order->user_id) }}</p>
                                                        <p class="text-muted my-2">Seller : {{ getUserNameById($order->orderDetail->influencer_id) }}</p>
                                                    </div>
                                                    <div class="col-md-4"></div>
                                                    {{-- 
                                                    <div class="col-md-4">
                                                        <select class="form-control orderStatus my-2" style="height: 29px;">
                                                            <option value="">Select</option>
                                                            <option {{ $order->status == 'pending' ? 'selected' : '' }} value="pending">Pending</option>
                                                            <option {{ $order->status == 'accept' ? 'selected' : '' }} value="accept">Accept</option>
                                                            <option {{ $order->status == 'decline' ? 'selected' : '' }} value="decline">Decline</option>
                                                            <option {{ $order->status == 'completed' ? 'selected' : '' }} value="completed">Completed</option>
                                                            <option {{ $order->status == 'delivered' ? 'selected' : '' }} value="delivered">Delivered</option>
                                                        </select>
                                                        <p class="text-muted my-2"><span class="fw-bold me-4">Total</span> ${{ @$order->product_price }}</p>
                                                        <p class="text-muted my-2"><span class="fw-bold me-4">Payment Type:</span> {{ ucfirst($order->payment_type) }}</p>
                                                    </div>
                                                    --}}
                                                </div>
                                                <div class="row d-flex justify-content-center align-items-center h-100">
                                                    <div class="col-lg-12 col-xl-12">
                                                        <div class="card" style="border-radius: 10px;">
                                                            <div class="card-body">
                                                                <div class="d-flex justify-content-between align-items-center mb-4">                                              
                                                                </div>
                                                                @php
                                                                $detail = $order->orderDetail->detail;                
                                                                @endphp
                                                                @if (!empty($detail) && count($detail) > 0)
                                                                @foreach ($detail as $key => $value)
                                                                <div class="card shadow-0 border mb-4">
                                                                    <div class="card-body">
                                                                        <div class="row">
                                                                            <div class="col-md-12">
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
                                                                                    Detail for to follow
                                                                                    </label>
                                                                                    <textarea type="text" class="form-control" readonly>{{ $value }}</textarea>
                                                                                    @break
                                                                                    @case('to_follow')
                                                                                    <label for="" class="form-label">
                                                                                    Detail for to follow
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
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @endforeach
                                                                @endif
                                                                @if (count($order->deliverProduct) > 0)
                                                                <div class="card shadow-0 border mb-4">
                                                                    <div class="card-body">
                                                                        <div class="form-group row">
                                                                            @foreach ($order->deliverProduct as $product)
                                                                            @if ($product->product_exe == 'mp4' || $product->product_exe == 'mov' || $product->product_exe == 'webm' || $product->product_exe == 'mkv')
                                                                            <div class="col-md-{{count($order->deliverProduct) > 1 ? '6' : '12'}}">
                                                                                <div class="form-group">
                                                                                    <div class="order-deliver-video position-relative mt-3">
                                                                                        <video width="100%" height="260px" controls>
                                                                                            <source src="{{ $product->product }}" type="video/mp4" class="img-fluid" width="410px" height="260px">
                                                                                            <source src="movie.ogg" type="video/ogg">
                                                                                            Your browser does not support the video tag.
                                                                                        </video>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            @else
                                                                            <div class="col-md-{{count($order->deliverProduct) > 1 ? '6' : '12'}}">
                                                                                <div class="form-group">
                                                                                    <div class="order-deliver-video position-relative mt-3">
                                                                                        <img src="{{ $product->product }}" width="410px" height="260px">            
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            @endif
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @endif
                                                            </div>
                                                            @if (isset($review))
                                                               <div class="mb-4" style="display: inherit;">
                                                                <img src="{{ getUserImageById($review->user_id) }}" style="width: 100px; height: 100px; border-radius: 50px;">
                                                                   <div class="reviews-text px-4 pt-3">
                                                                      <div class="reviews-rating">
                                                                         @php
                                                                            $grayStar = 5 - $review->rating;
                                                                         @endphp
                                                                         @for ($i = 1; $i <= $review->rating; $i++)
                                                                            <span class="rating-star" style="color: #ffa500;">
                                                                               <i class="fa fa-star" aria-hidden="true"></i>
                                                                            </span>
                                                                         @endfor
                                                                         @for ($i = 1; $i <= $grayStar; $i++)
                                                                            <span class="rating-un-star">
                                                                               <i class="fa fa-star" aria-hidden="true"></i>
                                                                            </span>
                                                                         @endfor                                 
                                                                      </div>
                                                                      <p>{{ @$review->review }}</p>
                                                                      <h5>{{ getUserNameById($review->user_id) }}</h5>
                                                                   </div>                              
                                                               </div>           
                                                            @endif 
                                                            <div class="card-footer border-0"
                                                                style="background-color: #a8729a; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
                                                                <h5 class="d-flex align-items-center justify-content-end text-white text-uppercase mb-0">Total
                                                                    paid: <span class="h2 mb-0 ms-2">${{ $order->product_price }}</span>
                                                                </h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </section>
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('customScript')
<script type="text/javascript">
    $(document).on('change', '.orderStatus', function() {
       var status = $(this).val();
       updateStatus(status);   
    });      
    
    function updateStatus(status) {
       $.ajax({
          headers: {
            'X-CSRF-Token': $('input[name="_token"]').val()
          },
          type: 'post',
          url: "{{ route('orderStatus') }}",
          data: {
             status: status,
             id: {{$order->id}},
          },         
          success: function(data) {
             if (data.status == true) {               
                swal("", data.message, "success", {
                   button: "close",
                });
                window.location.href = "{{ Url::previous() }}";
             } else {               
                swal("", data.errors, "error", {
                   button: "close",
                });
             }
          }
       });
    }
</script>
@endsection