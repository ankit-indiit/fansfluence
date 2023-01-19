$('input[type=radio]').click(function(){
    if (this.previous) {
        this.checked = false;
    }
    this.previous = this.checked;
});

$('.custom-filter-dropdown').on('click', function(event){
    event.stopPropagation();
});

$('.apply-btn').on('click', function(event){
    $('.custom-filter-dropdown').hide();
});

/*Show selected delivery type*/
$(document).on('click', '.photoDeliveryType', function(){
 $('#photoDeliveryType').html($(this).data('option'));
});
$(document).on('click', '.videoDeliveryType', function(){
 $('#videoDeliveryType').html($(this).data('option'));
});
/*Show selected delivery type*/

$(document).on('change', '.business', function(){
    var status = $(this).is(":checked");
    if (status == true) {
        status = '1';
    }
    if (status == false) {
        status = '0';
    }
    $.ajax({
        headers: {
            'X-CSRF-Token': $('input[name="_token"]').val()
        },
        type: 'post',
        url: _baseURL+"/user/business",
        data: {
            status: status,
        }, 
        success: function(data) {
            if (data.status == true) {
                $('.successMsg').html(data.message);
                $("#successModel").modal("show");
                $('.okMsgBtn').on('click', function(){
                    window.location.reload();
                });
            } else {
                $('.errorMsg').html(data.message);
                $("#errorModel").modal("show");
            }      
        }
    });
});

$(document).on('change', '.businessFilter', function(){
    var status = $(this).is(":checked");
    if (status == true) {
        status = '1';
    }
    if (status == false) {
        status = '0';
    }
    $.ajax({
        headers: {
            'X-CSRF-Token': $('input[name="_token"]').val()
        },
        type: 'post',
        url: _baseURL+"/user/business-filter",
        data: {
            status: status,
        }, 
        success: function(data) {
            if (data.status == true) {
                $('.successMsg').html(data.message);
                $("#successModel").modal("show");
                $('.okMsgBtn').on('click', function(){
                    window.location.reload();
                });
            } else {
                $('.errorMsg').html(data.message);
                $("#errorModel").modal("show");
            }      
        }
    });
});

$(document).on('click', '.loginAlert', function(){
    $('#loginAlert').modal('show');
})

$(document).on('click', '.starInfluencer', function(){
    $('.influencerId').val($(this).data('id'));
    $('#add-collection').modal('show');
})

$(document).on('click', '.addCollection', function(){
    $(this).toggleClass('showAddCollection');
    if ($(this).hasClass('showAddCollection')) {
        $('.addCollectionSec').append('<div class="addCollectionForm"> <div class="form-group my-4"> <input type="text" class="form-control" name="name" placeholder="Collection Name"> </div> <div class="form-group my-4"> </div><input type="hidden" name="createCollection" value="createCollection"> </div>');
        // $('.addCollectionSec').append('<div class="addCollectionForm"> <div class="form-group my-4"> <input type="text" class="form-control" name="name" placeholder="Collection Name"> </div> <div class="form-group my-4"> <input type="file" class="form-control" name="image_name"> </div><input type="hidden" name="createCollection" value="createCollection"> </div>');
        $('.collectionList').addClass('d-none');
    } else {
        $('.addCollectionForm').remove();
        $('.collectionList').removeClass('d-none');
    }
});

$("#starInfluencer").validate({    
    rules: {
        collection_id: {
            required: true,
        },
        name: {
            required: true,
        },
        image_name: {
            required: true,
        },          
    },
    messages: {
        collection_id: "Please choose collection!",
        name: "Please enter name!",
        image_name: "Please choose image!",        
    },
    submitHandler: function(form) {
        var serializedData = new FormData(form);
        $("#err_mess").html('');
        $('#starInfluencerBtn').attr('disabled');
        $('#starInfluencerBtn').html('Processing <i class="fa fa-spinner fa-spin"></i>')      
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
                    $('#starInfluencerBtn').html('Submitted');
                    $('.successMsg').html(data.message);
                    $("#successModel").modal("show");
                    $('#starInfluencer').trigger("reset");
                    $('#add-collection').modal("hide");
                    $('.okMsgBtn').on('click', function(){
                        window.location.reload();
                    });
               } else {
                    $('#add-collection').modal("hide");
                    $('.errorMsg').html(data.message);
                    $("#errorModel").modal("show");
                    $('.okMsgBtn').on('click', function(){
                        window.location.reload();
                    });
                } 
            }
        });
        return false;
    }
});

$(document).on('click', '.unStarInfluencer', function(){
    var influencer_id = $(this).data('id');
    var collection_id = $(this).data('collection-id');
    $('#confirmAlert').modal('show');
    $('.confirmDeleteBtn').on('click', function(){
        $(this).attr('disabled');
        $(this).html('Processing <i class="fa fa-spinner fa-spin"></i>');        
        $.ajax({
            headers: {
                'X-CSRF-Token': $('input[name="_token"]').val()
            },
            type: 'post',
            url: _baseURL+"/stared/unstar-influencer",
            data: {
                influencer_id: influencer_id,
                collection_id: collection_id
            }, 
            success: function(data) {
                if (data.status == true) {
                    $('#confirmAlert').modal('hide');
                    $('.successMsg').html(data.message);
                    $("#successModel").modal("show");
                    $('.okMsgBtn').on('click', function(){
                        window.location.reload();
                    });
                } else {
                    $('.errorMsg').html(data.message);
                    $("#errorModel").modal("show");
                }      
            }
        });        
    })
});

$(document).on('click', '.orderTab', function(){
    var tab = $(this).data('tab');
    var type ="Active";
    var oldURL = window.location.protocol +"//" + window.location.host + window.location.pathname;
    var newUrl = oldURL +"?status=" + tab;
    if (window.history !='undefined' && window.history.pushState !='undefined') {
        window.history.pushState({ path: newUrl },'', newUrl);
        window.location.reload();
    }
    return false;
});