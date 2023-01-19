@foreach ($gigs as $gig)
    <div class="col-md-6 col-sm-6 col-12">
        <div class="card gigCard">                    
            <div class="text-center mt-4">
                <img src="{{ getUserImageById($gig->influencer_id) }}" class="card-img-top" style="width: 100px; height: 100px; border-radius: 50px;">
                <div class="d-flex justify-content-center">
                    <h5 class="card-title pt-3">{{ getUserNameById($gig->influencer_id) }}</h5>
                    <button type="button" class="btn pl-2 sellerCard" data-id="{{ $gig->influencer_id }}"><i class="fa fa-edit"></i></button>
                </div>
            </div>                    
            <ul class="list-group list-group-flush">
                @if ($gig->photo_with_watermark)        
                <li class="list-group-item">Photo With Wateramrk ${{$gig->photo_with_watermark}}</li>
                @endif
                @if ($gig->photo_with_out_watermark)   
                <li class="list-group-item">Photo WithOut Wateramrk ${{$gig->photo_with_out_watermark}}</li>
                @endif
                @if ($gig->video_with_watermark)   
                <li class="list-group-item">Video With Wateramrk ${{$gig->video_with_watermark}}</li>
                @endif
                @if ($gig->video_with_out_watermark)   
                <li class="list-group-item">Video WithOut Wateramrk ${{$gig->video_with_out_watermark}}</li>
                @endif
                @if ($gig->facebook_price)   
                <li class="list-group-item">Instagram ${{$gig->facebook_price}}</li>
                @endif
                @if ($gig->instagram_price)   
                <li class="list-group-item">Facebook ${{$gig->instagram_price}}</li>
                @endif
                @if ($gig->twitter_price)   
                <li class="list-group-item">Twitter ${{$gig->twitter_price}}</li>
                @endif
            </ul>                   
        </div><br><br>
    </div>
@endforeach