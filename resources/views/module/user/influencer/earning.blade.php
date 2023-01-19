@extends('layout.master')
@section('content')
<section class="pt-5 pb-5 order-details-section">
   <div class="container">
      <div class="d-flex mb-4 page-head-title align-items-center">
         <h3 class="section-title">My Earning</h3>
         @include('module.component.search-box')
         <div class="single-sidebar ms-3">
            @include('module.component.order-filter')            
         </div>
      </div>

      <div class="orders-tabs-section">
         <ul class="nav nav-pills" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
               <a
                  href="{{ route('influencerEarning') }}?status=pending"
                  class="nav-link {{ request()->status == 'pending' ? 'active' : '' }}"
               >
                  Pending Funds
               </a>
            </li>
            <liclass="nav-item" role="presentation">
               <a
                  href="{{ route('influencerEarning') }}?status=completed"
                  class="nav-link {{ request()->status == 'completed' ? 'active' : '' }}"
               >
                  Settled Funds
               </a>
            </li>
         </ul>
         <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade {{ request()->status == 'pending' ? 'active show' : '' }}">
               <div class="table-responsive">
                  <table class="table">
                     <thead>
                        <tr>
                           <th>Client</th>
                           <th>Oder ID</th>
                           <th>Date / Time</th>
                           <th>Earnings</th>
                        </tr>
                     </thead>
                     <tbody>
                        @if (count($pendingFunds) > 0)
                           @foreach ($pendingFunds as $fund)
                              <tr>
                                 <td>
                                    <span class="user-td">
                                    <img src="{{ getUserImageById($fund->user_id) }}" width="40px"> 
                                    </span> 
                                    {{ getUserNameById($fund->user_id) }}
                                 </td>
                                 <td>{{ $fund->customer_id }}</td>
                                 <td>
                                    <div class="earningTime"> {{ $fund->created_at }}
                                       <span>{{ $fund->time }}</span> 
                                    </div>
                                 </td>
                                 <td>${{ $fund->product_price }}</td>
                              </tr>
                           @endforeach
                        @else
                           <tr>
                              <td colspan="4">No Earnings Yet!</td>
                           </tr>
                        @endif
                     </tbody>
                  </table>
               </div>
            </div>
            <div class="tab-pane fade {{ request()->status == 'completed' ? 'active show' : '' }}">
               <div class="table-responsive">
                  <table class="table">
                     <thead>
                        <tr>
                           <th>Client</th>
                           <th>Oder ID</th>
                           <th>Date / Time</th>
                           <th>Earnings</th>
                        </tr>
                     </thead>
                     <tbody>
                        @if (count($settledFunds) > 0)
                           @foreach ($settledFunds as $fund)
                              <tr>
                                 <td>
                                    <span class="user-td">
                                    <img src="{{ getUserImageById($fund->user_id) }}" width="40px"> 
                                    </span> 
                                    {{ getUserNameById($fund->user_id) }}
                                 </td>
                                 <td>{{ $fund->customer_id }}</td>
                                 <td>
                                    <div class="earningTime"> {{ $fund->created_at }}
                                       <span>{{ $fund->time }}</span> 
                                    </div>
                                 </td>
                                 <td>${{ $fund->product_price }}</td>
                              </tr>
                           @endforeach
                        @else
                           <tr>
                              <td colspan="4">No Earnings Yet!</td>
                           </tr>
                        @endif               
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
         
      </div>
   </div>
</section>
@endsection
@section('customScript')

@endsection