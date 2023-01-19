@extends('layout.master')
@section('content')
<section class="pt-5 pb-5 notifications-section section-full-height">
   <div class="container">
      <div class="d-flex mb-4 page-head-title">
         <h3 class="section-title">Notifications</h3>
      </div>
      <div class="main-notification-list">
         @if (count($notifications) > 0)
            @foreach ($notifications as $notification)
               <div class="media">
                  <div class="main-img-user">
                     @if (isset($notification['data']['user_id']))
                        {!! getUserProfilePic($notification['data']['user_id']) !!}
                     @endif                    
                  </div>
                  <div class="media-body">
                     <a class="dropdown-item" href="{{ @$notification['data']['link'] }}">
                        <p>{!! @$notification['data']['message'] !!}</p>
                        <span>{{ $notification->created_at->diffForHumans() }}</span> 
                     </a>
                  </div>
               </div>
            @endforeach
            <div class="justify-content-center d-flex">
               @include('module.component.pagination', [
                  'pagination' => $notifications,
               ]) 
            </div>
         @else
            No notification found!
         @endif  
      </div>
   </div>
</section>
@endsection