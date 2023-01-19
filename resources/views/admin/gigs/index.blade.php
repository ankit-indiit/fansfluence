@extends('admin.layout.master')
@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Seller Gigs</h4>
                <input type="text" class="form-control w-50 search" name="Search" placeholder="Search here">
                <a href="{{ URL::previous() }}" class="btn btn-default btnwhite">Back</a>
            </div>
        </div>        
        <div class="row sellerGigs">
            @include('admin.component.seller-gigs', ['gigs' => $gigs])            
        </div>
    </div>
    <div class="modal fade" id="sellerGig" tabindex="-1" role="dialog" aria-labelledby="sellerGigTitle" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="sellerGigTitle">Update Gig</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <span class="text-center processing">Processing <i class="fa fa-spinner fa-spin"></i></span>       
            <form action="" method="" id="gigForm" class="d-none">
                <div class="form-group">
                    <label>Photo With Wateramrk</label>
                    <input type="text" name="photo_with_watermark" class="form-control photoWithWatermark">
                </div>
                <div class="form-group">
                    <label>Photo WithOut Wateramrk</label>
                    <input type="text" name="photo_with_out_watermark" class="form-control photoWithOutWatermark">
                </div>
                <div class="form-group">
                    <label>Video With Wateramrk</label>
                    <input type="text" name="video_with_watermark" class="form-control videoWithWatermark">
                </div>
                <div class="form-group">
                    <label>Video WithOut Wateramrk</label>
                    <input type="text" name="video_with_out_watermark" class="form-control videoWithOutWatermark">
                </div>
                <div class="form-group">
                    <label>Facebook</label>
                    <input type="text" name="facebook_price" class="form-control facebookPrice">
                </div>
                <div class="form-group">
                    <label>Instagram</label>
                    <input type="text" name="instagram_price" class="form-control instagramPrice">
                </div>
                <div class="form-group">
                    <label>Twitter</label>
                    <input type="text" name="twitter_price" class="form-control twitterPrice">
                </div>
                <input type="hidden" name="id" value="" class="id">
                <div class="form-group d-flex justify-content-end">
                    <button type="button" class="btn btn-primary" id="gigFormBtn">Update</button>
                </div>
            </form>
          </div>          
        </div>
      </div>
    </div>
</div>
@endsection
@section('customScript')
<script type="text/javascript">
    $(document).on('keyup', '.search', function(){
        var search = $(this).val();
        $.ajax({            
            type: 'get',
            url: "{{ route('gigs.index') }}",
            data: { search: search },
            dataType: 'json',            
            success: function(data) {
                if (data.status == true) {
                    $('.sellerGigs').html(data.gigs);
                }
            }
        });
    });

    $(document).on('click', '.sellerCard', function(){
        var influencer_id = $(this).data('id');
        $('#sellerGig').modal('show');
        $.ajax({            
            type: 'get',
            url: "{{ route('gigs.edit') }}",
            data: { influencer_id: influencer_id },
            dataType: 'json',            
            success: function(data) {
               if (data.status == true) {
                    $('.processing').addClass('d-none');
                    $('#gigForm').removeClass('d-none');
                    $('.id').val(data.id);                    
                    $('.photoWithWatermark').val(data.photo_with_watermark);                    
                    $('.photoWithOutWatermark').val(data.photo_with_out_watermark);                    
                    $('.videoWithWatermark').val(data.video_with_watermark);                    
                    $('.videoWithOutWatermark').val(data.video_with_out_watermark);                    
                    $('.facebookPrice').val(data.facebook_price);                    
                    $('.instagramPrice').val(data.instagram_price);                    
                    $('.twitterPrice').val(data.twitter_price);                    
               } else {
                   
               }
            }
        });
    });

    $(document).on('click', '#gigFormBtn', function(){
        $('#gigFormBtn').attr('disabled', true);
        $('#gigFormBtn').html('Processing <i class="fa fa-spinner fa-spin"></i>');
        var serializedData = $("form").serializeArray();
        $.ajax({
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: "{{ route('gigs.update') }}",
            data: serializedData,
            dataType: 'json',
            success: function (data) {
                if (data.status == true) {
                    $('#gigFormBtn').attr('disabled', false);         
                    $('#gigFormBtn').html('Save Changes');
                    $('#sellerGig').modal('hide');
                    swal("", data.message, "success", {
                      button: "close",
                    });
                    $('.swal2-confirm').on('click', function(){
                        location.reload();
                    });
                } else {
                   swal("", data.message, "error", {
                         button: "close",
                   });
                }
            }
        });
    });
</script>
@endsection