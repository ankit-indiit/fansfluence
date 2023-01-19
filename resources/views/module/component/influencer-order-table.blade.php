<table class="table table-responsive">
   <thead>
      <tr>        
         <th>Client</th>         
         <th>Order Type</th>
         <th>Order Placed</th>
         <th>Delivery Date</th>
         <th>Price</th>
         <th>Action</th>
      </tr>
   </thead>
   <tbody>
      @if (count($orders) > 0)
         @foreach ($orders as $order)
            <tr>
               <td style="width: 130px;">
                  <span class="user-td">
                     {!! getUserProfilePic($order->orderDetail->user_id) !!} 
                  </span> 
                  {{ $order->user->name }}
               </td>
               @if (!empty($order->mark))
                  <td>
                     Personalized 
                     {{ $order->product }} 
                     ({{ $order->mark }}) 
                     {{-- {!! bussIcon($order->orderDetail->user_id) !!} --}}
                  </td>
               @else
                  <td>
                     Personalized 
                     {{ $order->product }} 
                     {{-- {!! bussIcon($order->orderDetail->user_id) !!} --}}
                  </td>
               @endif
               <td>{{ $order->created_at }}</td>
               <td>{{ $order->orderDetail->delivery_date }}</td>
               <td>${{ $order->product_price }}</td>
               @if ($type == 'pending')
                  <td class="action">
                     <div class="table-action-group">
                        <a
                           href="javascript:void();"
                           class="action-btn btn-decline text-light me-2"
                           id="declineOrder"            
                           data-order-id="{{ $order->id }}"
                           data-status="decline"
                        >
                           Decline
                        </a>
                        <a
                           href="javascript:void();"
                           class="action-btn btn-accept text-light mx-2"
                           id="acceptOrder"            
                           data-order-id="{{ $order->id }}"
                           data-status="accept"
                        >
                           Accept
                        </a>
                     </div>
                  </td>
               @else
                  <td>
                     <a
                        href="{{ route('order.detail', [$order->id, 'influencer']) }}"
                        class="tbl-actin-btn"
                     >
                        View Order
                     </a>
                  </td>
               @endif
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