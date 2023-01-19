@extends('layout.master')
@section('content')
{{ Breadcrumbs::render('influencers') }}
<section class="pb-5 expoer-profile-section">
   <div class="container">
      {{-- Filter Section --}}
      @include('module.component.influencer-filter') 
      <div class="d-flex justify-content-between mb-4">
         @if (count($users) == 0)
         <h3 class="section-title">{{ Request::segment(3) }}</h3>
         @endif
      </div>
      @if (count($users) > 0)
         @include('module.component.influencers', [
            'users' => $users,
            'title' => Request::segment(3),
            'platform' => 'recommended'
         ])
         {{-- @include('module.component.influencers', [
            'users' => $users,
         ])  --}}
         @include('module.component.pagination', [
            'pagination' => $users,
         ])
      @else
         <h4>No Influencer found</h4>
      @endif
   </div>
</section>
@endsection