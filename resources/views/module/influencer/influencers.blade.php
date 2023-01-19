@extends('layout.master')
@section('content')
{{ Breadcrumbs::render('stars') }}
<section class="mt-4 pb-5 expoer-profile-section">
   <div class="container">      
      <div class="d-flex justify-content-between mb-4">
         <h3 class="section-title">
            {{ Request::segment(3) == 'explore' ? 'Explore' : ucfirst(Request::segment(3)) }}
         </h3>
      </div>
      @if (count($users) > 0)
         @include('module.component.influencers', [
            'users' => $users,
         ])
         @include('module.component.pagination', [
            'pagination' => $users,
         ]) 
      @else
         <h4>No Influencer found</h4>
      @endif
   </div>
</section>
@endsection