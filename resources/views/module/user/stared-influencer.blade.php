@extends('layout.master')
@section('content')
<section class="pt-5 pb-5 stared-influencers-section">
    <div class="container">
        <div class="d-flex justify-content-between mb-sm-5 mb-4">
            <div class="stared-influencers-hdr">
                <h3 class="section-title">{{ $collection->name }}</h3>
                <p>({{ count($collection->stars) }} influencers)</p>
            </div>
        </div>
        <div class="expore-profiles-lists">
            @foreach ($collection->stars as $star)
            <div class="profile-item">
                <div class="profile-img">
                    <img src="{{ $star->user->image }}" class="img-fluid">
                    <span class="profile-item-logo"><img src="img/logo-icon2.png"></span>
                </div>
                <div class="profile-info  d-flex justify-content-between">
                    <div>
                        <h5>
                            <a href="{{ route('influencerDetail', $star->user->id) }}">
                                {{ $star->user->name }}
                            </a>
                        </h5>
                        <span class="rating-star">
                            <i class="fa fa-star" aria-hidden="true"></i> {{$star->user->rating}}
                        </span>
                    </div>
                    <div class="profile-price">
                        @if ($star->user->profile_price)
                        ${{ $star->user->profile_price }}+
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
@section('customScript')
@endsection