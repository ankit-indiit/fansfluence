@extends('layout.master')
@section('content')
<!-- Banner Start -->
<section id="hero" class="">
   <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
      <div class="carousel-inner">
         <div class="carousel-item active" style="background: #DE0017;">
            <div class="container">
               <div class="row  d-flex justify-content-center align-items-center">
                  <div class="col-md-6">
                     <div class="carousel-caption-text">
                        <h2><strong>Customized</strong> Videos & <br> Photos <strong>from your favorite<br> stars</strong> <span><img src="{{ asset('assets/img/login-icon.png') }}"></span></h2>
                        <a class="btn btn-primary custom-btn1 mt-4" href="{{ route('stars', 'explore') }}">Explore</a>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="carousel-img carousel-img1">
                        <img src="{{ asset('assets/img/hero-img1.png') }}" class="img-fluid">
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="carousel-item" style="background: #FFB800;">
            <div class="container">
               <div class="row  d-flex justify-content-center align-items-center">
                  <div class="col-md-6">
                     <div class="carousel-caption-text">
                        <h2><strong>Customized</strong> Videos & <br> Photos <strong>from your favorite<br> stars</strong> <span><img src="{{ asset('assets/img/login-icon.png') }}"></span></h2>
                        <a class="btn btn-primary custom-btn1 mt-4" href="{{ route('stars', 'explore') }}">Explore</a>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="carousel-img carousel-img2">
                        <img src="{{ asset('assets/img/hero-img2.png') }}" class="img-fluid">
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="carousel-item" style="background: #01C839;">
            <div class="container">
               <div class="row  d-flex justify-content-center align-items-center">
                  <div class="col-md-6">
                     <div class="carousel-caption-text">
                        <h2><strong>Customized</strong> Videos & <br> Photos <strong>from your favorite<br> stars</strong> <span><img src="{{ asset('assets/img/login-icon.png') }}"></span></h2>
                        <a class="btn btn-primary custom-btn1 mt-4" href="{{ route('stars', 'explore') }}">Explore</a>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="carousel-img carousel-img3">
                        <img src="{{ asset('assets/img/hero-img3.png') }}" class="img-fluid">
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
      </button>
   </div>
</section>
<!-- Banner End -->
@if (Auth::check())
   <section class="pt-5 pb-5 recently-viewed">
      @if (count(getInfluencers('recentlyViewed')) > 0)
         @include('module.component.influencers', [
            'users' => getInfluencers('recentlyViewed'),
            'title' => 'Recently Viewed',
            'platform' => 'recentlyViewed'
         ])      
      @endif
   </section>
   <section class="pt-5 pb-5 trending-profiles">
      @if (count(getInfluencers('trending')) > 0)
         @include('module.component.influencers', [
            'users' => getInfluencers('trending'),
            'title' => 'Trending',
            'platform' => 'trending'
         ])      
      @endif
   </section>
   <section class="pb-5 youtubers-profiles">
      @if (count(getInfluencers('youtubers')) > 0)
         @include('module.component.influencers', [
            'users' => getInfluencers('youtubers'),
            'title' => 'Youtubers',
            'platform' => 'youtubers'
         ])      
      @endif
   </section>
   <section class="pb-5 tiktokers-profiles">
      @if (count(getInfluencers('tiktok')) > 0)
         @include('module.component.influencers', [
            'users' => getInfluencers('tiktok'),
            'title' => 'Tiktokers',
            'platform' => 'tiktok'
         ])      
      @endif
   </section>
   <section class="pb-5 twitchers-profiles">
      @if (count(getInfluencers('twitch')) > 0)
         @include('module.component.influencers', [
            'users' => getInfluencers('twitch'),
            'title' => 'Twitchers',
            'platform' => 'twitch'
         ])
      @endif
   </section>
   <section class="pb-5 recommended-profiles">
     @if (count(getInfluencers('recommended')) > 0)
         @include('module.component.influencers', [
            'users' => getInfluencers('recommended'),
            'title' => 'Recommended',
            'platform' => 'recommended'
         ])
      @endif
   </section>
   <section class="pb-5 recently-starred-profiles">
      @if (count(getInfluencers('recentlyStarred')) > 0)
         @include('module.component.influencers', [
            'users' => getInfluencers('recentlyStarred'),
            'title' => 'Recently Starred',
            'platform' => 'recentlyStarred'
         ])
      @endif
   </section>
@else
   <section class="pt-5 pb-5 trending-profiles">
      @if (count(getInfluencers('trending')) > 0)
         @include('module.component.influencers', [
            'users' => getInfluencers('trending'),
            'title' => 'Trending',
            'platform' => 'trending'
         ])      
      @endif
   </section>
   <section class="pb-5 youtubers-profiles">
      @if (count(getInfluencers('youtubers')) > 0)
         @include('module.component.influencers', [
            'users' => getInfluencers('youtubers'),
            'title' => 'Youtubers',
            'platform' => 'youtubers'
         ])      
      @endif
   </section>
   <section class="pb-5 tiktokers-profiles">
      @if (count(getInfluencers('tiktok')) > 0)
         @include('module.component.influencers', [
            'users' => getInfluencers('tiktok'),
            'title' => 'Tiktokers',
            'platform' => 'tiktok'
         ])      
      @endif
   </section>
   <section class="pb-5 twitchers-profiles">
      @if (count(getInfluencers('twitch')) > 0)
         @include('module.component.influencers', [
            'users' => getInfluencers('twitch'),
            'title' => 'Twitchers',
            'platform' => 'twitch'
         ])
      @endif
   </section>
   <section class="pb-5 recommended-profiles">
     @if (count(getInfluencers('recommended')) > 0)
         @include('module.component.influencers', [
            'users' => getInfluencers('recommended'),
            'title' => 'Recommended',
            'platform' => 'recommended'
         ])
      @endif
   </section>
@endif
@endsection