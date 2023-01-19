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
                  href="{{ route('order', 'buyer') }}?status=pending"
                  class="nav-link {{ request()->status == 'pending' ? 'active' : '' }}"
               >Request</a>
            </li>    
            <li class="nav-item" role="presentation">
               <a 
                  href="{{ route('order', 'buyer') }}?status=accept"
                  class="nav-link {{ request()->status == 'accept' ? 'active' : '' }}"
               >Active</a>
            </li>
            <li class="nav-item" role="presentation">
               <a
                  href="{{ route('order', 'buyer') }}?status=delivered"
                  class="nav-link {{ request()->status == 'delivered' ? 'active' : '' }}"
               >Delivered</a>
            </li>
            <li class="nav-item" role="presentation">
               <a
                  href="{{ route('order', 'buyer') }}?status=completed"
                  class="nav-link {{ request()->status == 'completed' ? 'active' : '' }}"
               >Completed</a>
            </li>
            <div class="single-sidebar ms-auto">
               @include('module.component.order-filter') 
            </div>
         </ul>
         <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade {{ request()->status == 'pending' ? 'show active' : '' }}" id="activePills" role="tabpanel" aria-labelledby="pendingOrderTab">
               <div class="empty-orders text-center p-4 d-none">
                  <img src="{{ asset('assets/img/emptry-orders-img.png') }}" class="emptry-orders-img">
               </div>
               <div class="table-responsive activeOrders">
                  @include('module.component.buyer-order-table', [
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
                  @include('module.component.buyer-order-table', [
                     'type' => 'active',
                     'orders' => $orders
                  ])
               </div>
            </div>
            <div class="tab-pane fade {{ request()->status == 'delivered' ? 'show active' : '' }}" id="activePills" role="tabpanel" aria-labelledby="pendingOrderTab">
               <div class="empty-orders text-center p-4 d-none">
                  <img src="{{ asset('assets/img/emptry-orders-img.png') }}" class="emptry-orders-img">
               </div>
               <div class="table-responsive activeOrders">
                  @include('module.component.buyer-order-table', [
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
                  @include('module.component.buyer-order-table', [
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
@section('customScript')
<script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
<script type="text/javascript">
  
</script>
@endsection