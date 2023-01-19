@extends('layout.master')
@section('content')
<section class="pt-5 pb-5 stared-collection-section">
    <div class="container">
        <div class="d-flex justify-content-between mb-sm-5 align-items-center mb-4">
            <h3 class="section-title">Starred</h3>
            <button class="custom-btn-main" data-bs-toggle="modal" data-bs-target="#createCollection">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus me-2">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                Create Collection
            </button>
        </div>
        <div class="stared-profiles-lists">
            @if (count($collections) > 0)
                @foreach ($collections as $collection)
                    <div class="stared-profile-item collection{{ $collection->id }}">
                        <div class="stared-profile-img">
                            <img src="{{ count($collection->stars) == 0 ? $collection->image : getUserImageById($collection->user_id) }}" class="img-fluid">
                            <button class="dlt-prfl deleteCollBtn" data-coll-id="{{ $collection->id }}" data-name="{{ $collection->name }}">
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </button>
                        </div>
                        <div class="stared-profile-info mt-3">
                            <h4>
                                <a href="{{ route('collection.show', $collection->slug) }}">
                                    {{ $collection->name }}
                                </a>
                            </h4>
                            <p>({{ count($collection->stars) }} influencer)</p>
                        </div>
                    </div>
                @endforeach
            @else
                No collection found!
            @endif
        </div>
    </div>
</section>
<section class="recommended-profiles">
    @if (count(getInfluencers('recommended')) > 0)
        @include('module.component.influencers', [
            'users' => getInfluencers('recommended'),
            'title' => 'Recommended',
            'platform' => 'recommended'
        ])
    @endif
</section>
<section class="pt-5 pb-5 recently-viewed">
    @if (count(getInfluencers('recentlyViewed')) > 0)
        @include('module.component.influencers', [
            'users' => getInfluencers('recentlyViewed'),
            'title' => 'Recently Viewed',
            'platform' => 'recentlyViewed'
        ])
    @endif
</section>
@endsection
@section('customModal')
<div class="modal fade custom-model-design delete-option-popup" id="deleteStarModal" tabindex="-1" aria-labelledby="payment-success-label" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <div class="custom-model-inner">
                    <h4 class="text-error">Delete</h4>
                    <div class="my-4">
                        <img src="{{ asset('assets/img/delete-icon.svg') }}">
                    </div>
                    <h5 class="mb-4 deleteMsg"></h5>
                    <div class="modal-btn-group">
                        <button type="button" class="btn custom-btn-main deleteConfirm" data-bs-dismiss="modal">Yes</button>
                        <button type="button" class="btn custom-btn-outline" data-bs-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade custom-model-design show" id="createCollection" tabindex="-1" aria-labelledby="payment-success-label" aria-modal="true" role="dialog" style="display: none; padding-right: 15px;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <form action="{{ route('storeCollection') }}" method="post" id="addStarInfluencer">
                    @csrf
                    <div class="custom-model-inner text-center">
                        <h4>
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                            </span>
                            Name your new collection
                        </h4>
                        <div class="form-group my-4">
                            <input type="text" class="form-control" name="name" placeholder="Collection Name">
                        </div>
                        {{-- <div class="form-group my-4">
                            <input type="file" class="form-control" name="image_name">
                        </div> --}}
                        <input type="hidden" name="createCollection" value="createCollection">
                        <button type="submit" id="addStarInfluencerBtn" class="btn custom-btn-main">Done</button>
                    </div>                    
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('customScript')
<script type="text/javascript">
    $(document).on('click', '.deleteCollBtn', function(){
        var name = $(this).data('name');
        $('.deleteConfirm').attr('data-coll-id', $(this).data('coll-id'));
        $('.deleteMsg').html('Are you sure you would like to delete the “'+name+'” collection? This action cannot be undone.');
        $('#deleteStarModal').modal('show');
    });

    $("#addStarInfluencer").validate({    
        rules: {
            collection_id: {
                required: true,
            },
            name: {
                required: true,
            },
            image: {
                required: true,
            },          
        },
        messages: {
            collection_id: "Please choose collection!",
            name: "Please enter name!",
            image: "Please choose image!",        
        },
        submitHandler: function(form) {
            var serializedData = new FormData(form);
            $("#err_mess").html('');
            $('#addStarInfluencerBtn').attr('disabled');
            $('#addStarInfluencerBtn').html('Processing <i class="fa fa-spinner fa-spin"></i>')      
            $.ajax({
                headers: {
                'X-CSRF-Token': $('input[name="_token"]').val()
                },
                type: 'post',
                url: _baseURL+"/stared/collection",
                data: serializedData,
                dataType: 'json',
                processData: false,
                contentType: false,
                cache: false, 
                success: function(data) {
                   if (data.status == true) {
                        $('#addStarInfluencerBtn').html('Submitted');
                        $('.successMsg').html(data.message);
                        $("#successModel").modal("show");
                        $('#addStarInfluencer').trigger("reset");
                        $('.okMsgBtn').on('click', function(){
                            window.location.reload();
                        });
                   } else {
                        $('.errorMsg').html(data.message);
                        $("#errorModel").modal("show");
                   }
                }
            });
            return false;
        }
    });
    
    $(document).on('click', '.deleteConfirm', function(){
       var collId = $(this).data('coll-id');
       $('.deleteConfirm').attr('disabled');
       $('.deleteConfirm').html('Processing <i class="fa fa-spinner fa-spin"></i>');      
       $.ajax({
          headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'post',
          url: "{{ route('destroyCollection') }}",
          data: {
             collId: collId
          },
          dataType: 'json',
          success: function(data) {
             if (data.status == true) {
                $('.collection'+collId).addClass('d-none');
                $('.successMsg').html(data.message);
                $("#successModel").modal("show");
             } else {
                $('.errorMsg').html(data.message);
                $("#errorModel").modal("show");              
             }
          }
       });
    })
</script>
@endsection