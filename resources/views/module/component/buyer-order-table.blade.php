<table class="table">
   <thead>
      <tr>
         <th>Influencer</th>              
         <th>Order Type</th>
         <th>Order Placed</th>
         <th>Delivery Date</th>
         <th>Price</th>
         {{-- @if ($type == 'pending' || $type == 'delivered' || $type == 'completed') --}}
            <th>Action</th>
         {{-- @endif --}}
      </tr>
   </thead>
   <tbody>
      @if (count($orders) > 0)
         @foreach ($orders as $order)            
            <tr>
               <td style="width: 130px;">
                  <span class="user-td">
                     {!! getUserProfilePic($order->orderDetail->influencer_id) !!}
                  </span>
                  {{ getUserNameById($order->orderDetail->influencer_id) }}
               </td>
               @if (!empty($order->mark))
                  <td>Personalized {{ $order->product }} ({{ $order->mark }})</td>
               @else
                  <td>Personalized {{ $order->product }}</td>
               @endif
               <td>{{ $order->created_at }}</td>
               <td>{{ $order->orderDetail->delivery_date }}</td>
               <td>${{ $order->product_price }}</td>              
               {{-- @if ($type == 'pending' || $type == 'delivered' || $type == 'completed') --}}
                  <td>                     
                     <a href="{{ route('order.detail', [$order->id, 'buyer']) }}" class="tbl-actin-btn">View Order</a>
                  </td>
               {{-- @endif --}}
            </tr>
         @endforeach
      @else
         <tr>            
            <td colspan="6">
               No order found! 
            </td>            
         </tr>
      @endif            
   </tbody>
</table>