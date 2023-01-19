@extends('layout.master')
@section('content')
<section class="pt-5 pb-5 order-details-section">
   <div class="container">
      <div class="d-flex justify-content-between mb-4 page-head-title align-items-center">
         <h3 class="section-title">Manage Orders </h3>
         @include('module.component.search')
      </div>
      <div class="orders-tabs-section">
         <ul class="nav nav-pills" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
               <a
                  href="{{ route('order', 'influencer') }}?status=pending"
                  class="nav-link {{ request()->status == 'pending' ? 'active' : '' }}"
               >Requests</a>
            </li>
            <li class="nav-item" role="presentation">
               <a 
                  href="{{ route('order', 'influencer') }}?status=accept"
                  class="nav-link {{ request()->status == 'accept' ? 'active' : '' }}"
               >Active</a>
            </li>
            <li class="nav-item" role="presentation">
               <a
                  href="{{ route('order', 'influencer') }}?status=delivered"
                  class="nav-link {{ request()->status == 'delivered' ? 'active' : '' }}"
               >Delivered</a>
            </li>
            <li class="nav-item" role="presentation">
               <a
                  href="{{ route('order', 'influencer') }}?status=completed"
                  class="nav-link {{ request()->status == 'completed' ? 'active' : '' }}"
               >Completed</a>
            </li>            
            <div class="single-sidebar ms-auto">
               @include('module.component.order-filter') 
            </div>
         </ul>
         <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade {{ request()->status == 'pending' ? 'show active' : '' }}" id="requestPills" role="tabpanel" aria-labelledby="requestOrderTab">
               <div class="empty-orders text-center p-4 d-none">
                  <img src="{{ asset('assets/img/emptry-orders-img.png') }}" class="emptry-orders-img">
               </div>               
               <div class="table-responsive">
                  @include('module.component.influencer-order-table', [
                     'type' => 'pending',
                     'orders' => $orders
                  ])
               </div>               
            </div>
            <div class="tab-pane fade {{ request()->status == 'accept' ? 'show active' : '' }}" id="activePills" role="tabpanel" aria-labelledby="pendingOrderTab">
               <div class="empty-orders text-center p-4 d-none">
                  <img src="{{ asset('assets/img/emptry-orders-img.png') }}" class="emptry-orders-img">
               </div>
               <div class="table-responsive activeOrders">
                  @include('module.component.influencer-order-table', [
                     'type' => 'accept',
                     'orders' => $orders
                  ])
               </div>
            </div>
            <div class="tab-pane fade {{ request()->status == 'delivered' ? 'show active' : '' }}" id="deliveredPills" role="tabpanel" aria-labelledby="deliveredOrderTab">
               <div class="empty-orders text-center p-4 d-none">
                  <img src="{{ asset('assets/img/emptry-orders-img.png') }}" class="emptry-orders-img">
               </div>                              
               <div class="table-responsive">
                  @include('module.component.influencer-order-table', [
                     'type' => 'delivered',
                     'orders' => $orders
                  ])
               </div>
            </div>
            <div class="tab-pane fade {{ request()->status == 'completed' ? 'show active' : '' }}" id="completedPills" role="tabpanel" aria-labelledby="completedOrderTab">
               <div class="empty-orders text-center p-4 d-none">
                  <img src="{{ asset('assets/img/emptry-orders-img.png') }}" class="emptry-orders-img">
               </div>
               <div class="table-responsive">
                  @include('module.component.influencer-order-table', [
                     'type' => 'completed',
                     'orders' => $orders
                  ])
               </div>               
            </div>            
         </div>
      </div>
   </div>
</section>
@endsection
@section('customModal')
   <div class="modal fade custom-model-design" id="acceptOrderModal" tabindex="-1" aria-labelledby="decline-request-label" aria-modal="true" role="dialog" style="display: none;">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">   
                <form action="{{ route('acceptOrder') }}" method="post" id="updateOrderStatusForm">
                    @csrf
                    <div class="modal-body">
                        <div class="custom-model-inner text-start">
                            <div class="form-group">
                                <label for="" class="form-label orderStatusLabel">
                                    Reason For Accept (Optional)                            
                                </label>
                                <textarea type="text" class="form-control" name="reasone" id="orderStatusReason" placeholder="This helps the buyer understand why there purchase was accepted" style="height: 80px;"></textarea>
                                <span class="orderStatusReason text-danger d-none"></span>
                                <div class="form-text text-end">Max 200 Characters</div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="order_id" id="acceptedOrderId">
                    <input type="hidden" name="status" value="accept">
                    <div class="modal-footer">
                        <button type="button" class="btn custom-btn-outline me-3" data-bs-dismiss="modal">
                            Cancel
                        </button>
                        <button type="submit" class="btn custom-btn-main text-capitalize" id="updateOrderStatusFormBtn">
                            Accept
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade custom-model-design" id="declineOrderModal" tabindex="-1" aria-labelledby="decline-request-label" aria-modal="true" role="dialog" style="display: none;">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">   
                <form action="{{ route('declineOrder') }}" method="post" id="updateOrderStatusForm">
                    @csrf
                    <div class="modal-body">
                        <div class="custom-model-inner text-start">
                            <div class="form-group">
                                <label for="" class="form-label orderStatusLabel">
                                    Reason For Decline (Optional)                            
                                </label>
                                <textarea type="text" class="form-control" name="reasone" id="orderStatusReason" placeholder="This helps the buyer understand why there purchase was declined" style="height: 80px;"></textarea>
                                <span class="orderStatusReason text-danger d-none"></span>
                                <div class="form-text text-end">Max 200 Characters</div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="order_id" id="declinedOrderId">
                    <input type="hidden" name="status" value="decline">
                    <div class="modal-footer">
                        <button type="button" class="btn custom-btn-outline me-3" data-bs-dismiss="modal">
                            Cancel
                        </button>
                        <button type="submit" class="btn custom-btn-main text-capitalize" id="updateOrderStatusFormBtn">
                            Decline
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
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
                                <textarea type="text" class="form-control" name="reasone" id="orderStatusReason" placeholder="" style="height: 80px;"></textarea>
                                <span class="orderStatusReason text-danger d-none"></span>
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
    $(document).on('click', '#acceptOrder', function(){
        var orderId = $(this).data('order-id');
        $('#acceptedOrderId').val(orderId);
        $('#acceptOrderModal').modal('show');        
    });

    $(document).on('click', '#declineOrder', function(){
        var orderId = $(this).data('order-id');
        $('#declinedOrderId').val(orderId);
        $('#declineOrderModal').modal('show');        
    });

    $(document).on('click', '#updateOrderStatus', function(){
        var orderId = $(this).data('order-id');
        var status = $(this).data('status');
        $('#orderId').val(orderId);
        $('#status').val(status);
        $('.orderStatusLabel').html('Resone for '+ status + ' (optional)');
        $('#orderStatusReason').attr('placeholder', 'This helps the buyer understand why there purchase was '+status+' ');
        $('#updateOrderStatusFormBtn').html(status);
        $('#orderStatusModal').modal('show');             
        if($("#orderStatusModal").hasClass("show")){
        
        } else {
            $('#updateOrderStatusForm').trigger("reset");
        }
    });

   $(document).on('keyup', '#orderStatusReason', function(){
      if ($(this).val().length > 200) {
         $('#updateOrderStatusFormBtn').attr('disabled', true);
         $('.orderStatusReason').html('Max 200 characters required!');
         $('.orderStatusReason').removeClass('d-none');
      } else {
         $('#updateOrderStatusFormBtn').attr('disabled', false);
         $('.orderStatusReason').addClass('d-none');
      }
   });

    $("#updateOrderStatusForm").validate({    
      rules: {
         reasone: {
            required: false,
            maxLength: 1000
         },         
      },
      messages: {
         reasone: {
            maxLength: "Max 1000 characters required!",
         },         
      },
      submitHandler: function(form) {

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
            url: "{{ route('order.deliver') }}",
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
                    $('.okMsgBtn').on('click', function(){
                        window.location.reload();
                    });
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