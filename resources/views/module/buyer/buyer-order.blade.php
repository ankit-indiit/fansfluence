@extends('layout.master')
@section('content')
<section class="pt-5 pb-5 order-details-section">
   <div class="container">
      <div class="d-flex justify-content-between mb-4 page-head-title align-items-center">
         <h3 class="section-title">Manage Orders </h3>
         <form class="d-flex header-search-form position-relative">
            <input
               class="form-control"
               type="search"
               name="search"
               placeholder="Search"
               value="{{ request()->search ? request()->search : '' }}"
               aria-label="Search"
            >
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search">
               <circle cx="11" cy="11" r="8"></circle>
               <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
         </form>
      </div>
      <div class="orders-tabs-section">
         <ul class="nav nav-pills" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
               <a 
                  href="{{ route('order', 'buyer') }}?status=accepted"
                  class="nav-link {{ request()->status == 'accepted' ? 'active' : '' }}"
               >Active</a>
            </li>
            <li class="nav-item" role="presentation">
               <a
                  href="{{ route('order', 'buyer') }}?status=completed"
                  class="nav-link {{ request()->status == 'completed' ? 'active' : '' }}"
               >Completed</a>
            </li>
            <li class="nav-item" role="presentation">
               <a
                  href="{{ route('order', 'buyer') }}?status=pending"
                  class="nav-link {{ request()->status == 'pending' ? 'active' : '' }}"
               >Requests</a>
            </li>
            <li class="nav-item" role="presentation">
               <a
                  href="{{ route('order', 'buyer') }}?status=completed"
                  class="nav-link {{ request()->status == 'delivered' ? 'active' : '' }}"
               >Delivered</a>
            </li>
            <div class="single-sidebar ms-auto">
               <div class="dropdown">
                  <button class="filter-btn recommended-btn dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                  <img src="{{ asset('assets/img/rcmnd-icon.svg') }}">
                  @if (request()->sortOrder == 'newOld')
                     New - Old
                  @endif
                  @if (request()->sortOrder == 'oldNew')
                     Old - New
                  @endif
                  </button>
                  <div class="dropdown-menu custom-filter-dropdown" aria-labelledby="dropdownMenuButton1" style="">
                     <form action="" method="get" id="orderFilter">
                        <input type="hidden" name="status" value="{{ request()->status }}">
                        <div class="filter-checkboxes d-flex flex-wrap">
                           <div class="form-check form-check-inline w-100">
                              <input
                                 class="form-check-input"
                                 type="radio"
                                 name="sortOrder"
                                 id="newOldOrder"
                                 value="newOld"
                                 {{ request()->sortOrder == 'newOld' ? 'checked' : '' }}
                              >
                              <label class="form-check-label" for="newOldOrder">New - Old</label>
                           </div>
                           <div class="form-check form-check-inline  w-100">
                              <input
                                 class="form-check-input"
                                 type="radio"
                                 name="sortOrder"
                                 id="oldNewOrder"
                                 value="oldNew"
                                 {{ request()->sortOrder == 'oldNew' ? 'checked' : '' }}
                              >
                              <label class="form-check-label" for="oldNewOrder">Old - New</label>
                           </div>
                        </div>
                        <button class="apply-btn" type="submit" id="orderFilterBtn">Apply</button>
                     </form>
                  </div>
               </div>
            </div>
         </ul>
         <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade {{ request()->status == 'accepted' ? 'show active' : '' }}" id="activePills" role="tabpanel" aria-labelledby="pendingOrderTab">
               <div class="empty-orders text-center p-4 d-none">
                  <img src="{{ asset('assets/img/emptry-orders-img.png') }}" class="emptry-orders-img">
               </div>
               <div class="table-responsive activeOrders">
                  @include('module.component.order-table', [
                     'type' => 'active',
                     'orders' => $orders
                  ])
               </div>
            </div>
            <div class="tab-pane fade {{ request()->status == 'completed' ? 'show active' : '' }}" id="completedPills" role="tabpanel" aria-labelledby="completedOrderTab">
               <div class="empty-orders text-center p-4 d-none">
                  <img src="{{ asset('assets/img/emptry-orders-img.png') }}" class="emptry-orders-img">
               </div>
               <div class="table-responsive">
                  @include('module.component.order-table', [
                     'type' => 'completed',
                     'orders' => $orders
                  ])
               </div>               
            </div>
            <div class="tab-pane fade {{ request()->status == 'pending' ? 'show active' : '' }}" id="requestPills" role="tabpanel" aria-labelledby="requestOrderTab">
               <div class="empty-orders text-center p-4 d-none">
                  <img src="{{ asset('assets/img/emptry-orders-img.png') }}" class="emptry-orders-img">
               </div>               
               <div class="table-responsive">
                  @include('module.component.order-table', [
                     'type' => 'requests',
                     'orders' => $orders
                  ])
               </div>               
            </div>
            <div class="tab-pane fade {{ request()->status == 'delivered' ? 'show active' : '' }}" id="deliveredPills" role="tabpanel" aria-labelledby="deliveredOrderTab">
               <div class="empty-orders text-center p-4 d-none">
                  <img src="{{ asset('assets/img/emptry-orders-img.png') }}" class="emptry-orders-img">
               </div>                              
               <div class="table-responsive">
                  @include('module.component.order-table', [
                     'type' => 'delivered',
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