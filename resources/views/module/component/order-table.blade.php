<table class="table">
   <thead>
      <tr>
         @if ($type == 'completed')
            <th>Influencer</th>
         @else
            <th>Client</th>         
         @endif         
         <th>Order Type</th>
         <th>Order Placed</th>
         <th>Delivery Date</th>
         <th>Price</th>
         @if (Auth::user()->hasRole('influencer') && $type == 'requests')
            <th>Action</th>
         @endif
      </tr>
   </thead>
   <tbody>
      @if (count($orders) > 0)
         @foreach ($orders as $order)
            <tr>
               <td>
                  <span class="user-td">
                     <img src="{{ getUserImageById($order->user_id) }}" width="40px"> 
                  </span> 
                  {{ $order->user }}
               </td>
               @if (!empty($order->mark))
                  <td>Personalized {{ $order->product }} ({{ $order->mark }})</td>
               @else
                  <td>Personalized {{ $order->product }}</td>
               @endif
               <td>{{ $order->created_at }}</td>
               <td>May 12, 2022</td>
               <td>${{ $order->product_price }}</td>
               @if (Auth::user()->hasRole('influencer') && $type == 'requests')
                  <td>
                     <div class="table-action-group">
                        <a href="javascript:void();" class="action-btn btn-decline me-2" data-bs-toggle="modal" data-bs-target="#decline-request">Decline</a>
                        <a href="javascript:void();" class="action-btn btn-accept">Accept</a>
                     </div>
                  </td>
               @endif
               @if ($type == 'delivered' || $type == 'completed')
                  <td>
                     @if (Auth::user()->hasRole('influencer'))
                        <a href="{{ route('order.detail', [$order->id, 'influencer']) }}" class="tbl-actin-btn">View Order</a>
                     @endif
                     @if (Auth::user()->hasRole('user'))
                        <a href="{{ route('order.detail', [$order->id, 'user']) }}" class="tbl-actin-btn">View Order</a>
                     @endif
                  </td>
               @endif
            </tr>
         @endforeach
      @else
         <tr>
            <h4>No order found</h4>                           
         </tr>
      @endif            
   </tbody>
</table>