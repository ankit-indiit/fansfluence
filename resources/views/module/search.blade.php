@extends('layout.master')
@section('content')
{{ Breadcrumbs::render('search') }}
<section class="pt-sm-5 mt-4 pb-5 expoer-profile-section">
   <div class="container">
      {{-- Filter Section --}}
      @include('module.component.influencer-filter')      
      <div class="d-flex justify-content-between mb-4">
         <h3 class="section-title">Users</h3>
      </div>
      @if (count($users) > 0)
         @include('module.component.influencers', [
            'users' => $users,
         ])
         @include('module.component.pagination', [
            'pagination' => $users,
         ])         
      @else
         <h4>No user found</h4>
      @endif
   </div>
</section>
@endsection