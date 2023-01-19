@extends('layout.master')
@section('content')
<section class="pt-5 pb-5 add-influencers-section">
   <div class="container">
      <div class="row">
         <div class="col-lg-7">
            <div class="d-flex mb-3 justify-content-between">
               <h3 class="section-title">{!! bussIcon(Auth::id()) !!} {{ Auth::user()->name }}</h3>
               <div class="form-check form-switch DisableProfileBtn">
                  <label class="form-check-label" for="profileStatus">Disable Profile</label>
                  <input class="form-check-input" type="checkbox" name="profileStatus" id="profileStatus" {{ Auth::user()->status == 0 ? 'checked' : '' }}>
               </div>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-lg-7">
            <div class="influencers-details-left">
               <div class="influencer-add-media">
                  <div class="influencer-add-media-inner profile_inner_media">
                     <div class="introVideoSec">
                        @if (!empty($profileDetail->intro_video ))
                           <video id="introVideoClip" width="100%" height="90%" controls>
                              <source id="introVideoSrc" src="{{ $profileDetail->intro_video }}" type="video/mp4">
                              <source src="movie.ogg" type="video/ogg">
                           </video>
                        @else
                           <div class="gallery_uploadimg">
                              <img src="{{ asset('assets/img/intro-video-icon.png') }}">
                           </div>
                        @endif
                        {{ Form::open(['url' => route('introVideo'), 'id' => 'introVideoForm']) }}
                           <div class="text-center"> 
                              <button type="button" class="add-intr-Btn addIntroVideo">
                                 {{ @$profileDetail->intro_video ? 'Update Intro Video' : 'Add Intro Video' }}
                              </button>
                           </div>
                           <input type="file" class="introVideo" name="introVideo" style="visibility: hidden;">
                           <input type="hidden" class="existVideoName" name="existVideoName" value="{{ @$profileDetail->exist_video_name }}">
                        {{ Form::close() }}
                     </div>
                     <div class="carousel-wrap introPhotoSec introPhotoSlider" style="display: none;">
                        @if (count($introPhotos) > 0)
                           <div class="owl-carousel profileimgcarousel">
                              @foreach ($introPhotos as $introPhoto)
                                 <div class="item image{{ $introPhoto->id }}">
                                    <div class="influencers-item">
                                       <div class="influencers-img">
                                          <button
                                             class="btn remove-intro-photo"
                                             data-id="{{ $introPhoto->id }}"
                                             data-image="{{ $introPhoto->image }}"
                                             style="float:right;"
                                          >
                                             <i class="fa fa-trash text-danger"></i>
                                          </button>
                                          <img src="{{ $introPhoto->name }}" class="img-fluid" style="height: 400px;object-fit: cover;">
                                       </div>
                                    </div>
                                 </div>                                 
                              @endforeach
                           </div>
                           <div id="imageUpload" class="dropzone">
                              <div id="dropzonePreview"></div>
                           </div>  
                        @else
                           <div class="gallery_uploadimg dropzone" id="imageUpload">
                              <img class="upload-svg-icon" src="{{ asset('assets/img/intro-video-icon.png') }}">
                              <div id="dropzonePreview"></div>
                                 {{-- <div id="imageUpload" class="dropzone">
                                    
                                 </div> --}}
                           </div>
                        @endif                
                     </div>                     
                  </div>
               </div>
               <div class="influencers-details-left-tags d-none d-lg-block">
                  <button type="button" class="custom-btn-main  active-tag-item introVideoBtn">Videos</button>
                  <button type="button" class="custom-btn-main introPhotoBtn">Photos</button>
               </div>
            </div>
         </div>
         <div class="col-lg-5">
            {{ Form::open(['url' => route('updateProfileCat'), 'id' => 'updateProfileCat']) }}
               <div class="influencers-details-right add-influencers-right">
                  <div class="influencers-info-tp d-flex">
                     <div class="influencers-rating">
                        <div>
                           @php
                              $user = Auth::user();
                              $i = 0;
                           @endphp
                           @if ($user->rating)
                              @for ($i == 1; $i < $user->rating; $i++)
                                 <span class="rating-star">
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                 </span>
                              @endfor
                              <h6 class="rating-value"> {{ $user->rating }}
                                 <span>({{ $user->rating }} Ratings)</span>
                              </h6>
                           @endif
                        </div>
                     </div>
                     {{-- <div class="ms-auto">
                        <img src="{{ asset('assets/img/logo-icon-gray.svg') }}">
                     </div> --}}
                  </div>
                  <div class="influencers-details-info">
                     <div class="add-media-category">
                        <h4 class="mb-lg-5 mb-4">
                           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus size-18">
                              <line x1="12" y1="5" x2="12" y2="19"></line>
                              <line x1="5" y1="12" x2="19" y2="12"></line>
                           </svg>
                           {{ $existPersonalize == true ? 'Add Category(ies)' : 'Manage category' }}
                        </h4>
                        <div class="mb-lg-5 mb-lg-3">
                           <div class="form-check">
                              <input
                                 class="form-check-input starCategory photoDeliveryType"
                                 type="checkbox"
                                 value="photo"
                                 name="personalizedPhoto"
                                 id="personalizedPhoto"
                                 {{ @checkedAttr('photo') }}
                                 data-option="Influencer Decides"
                              >
                              <label class="form-check-label" for="personalizedPhoto">
                              <span><img src="{{ asset('assets/img/photo-icon.svg') }}"></span> Personalized Photo
                              </label>
                           </div>
                           <div class="form-check">
                              <input
                                 class="form-check-input starCategory photoDeliveryType"
                                 type="checkbox"
                                 value="video"
                                 name="personalizedVideo"
                                 id="personalizedVideo"
                                 {{ @checkedAttr('video') }}
                                 data-option="Mobile"
                              >
                              <label class="form-check-label" for="personalizedVideo">
                              <span><img src="{{ asset('assets/img/video-icon.svg') }}"></span> Personalized Video
                              </label>
                           </div>
                           <div class="form-check">
                              <input
                                 class="form-check-input starCategory photoDeliveryType"
                                 type="checkbox"
                                 value="media"
                                 name="socialMediaPost"
                                 id="socialMediaPost"
                                 {{ @checkedAttr('media') }}
                                 data-option="Desktop"
                              >
                              <label class="form-check-label" for="socialMediaPost">
                              <span><img src="{{ asset('assets/img/social-post-icon.svg') }}"></span> Social Media Post
                              </label>
                           </div>
                        </div>
                        <button type="button" class="custom-btn-main my-lg-5 my-3 add-category-continue d-none w-100" id="addCategoryContinue">Continue</button>
                     </div>
                     <div class="add-media-select-category">
                        <h4 class="mb-lg-5 mb-lg-4 mb-2">Select Category</h4>
                        <div class="influencers-category-actions d-flex flex-column" id="accordionExample">
                           @include('module.user.influencer.personalize-category', [
                              'category' => 'photo'
                           ])
                           @include('module.user.influencer.personalize-category', [
                              'category' => 'video'
                           ])
                           @include('module.user.influencer.personalize-category', [
                              'category' => 'media'
                           ])
                           <div class="add-influencers-btngroup mb-lg-5 mb-3">
                              <button type="button" class="custom-btn-outline influencer-category-save">Manage Categories</button>
                              <button type="submit" class="custom-btn-main" id="updateProfileCatBtn">Save</button>
                           </div>
                        </div>
                     </div>                     
                  </div>
               </div>
            {{ Form::close() }}
            <div class="influencers-details-left-tags d-block d-lg-none">
               <button class="custom-btn-main  active-tag-item  add-category-continue ">Videos</button>
               <button class="custom-btn-main  add-category-continue">Photos</button>
               <button class="custom-btn-main  add-category-continue ">Post</button>
            </div>
         </div>
      </div>
      {{ Form::open(['url' => route('updateProfileDetail'), 'id' => 'updateInfluencerDetailForm']) }}
         <div class="col-md-12">
            <div class="row influencers-details-about mt-sm-5 mt-4">
               <div class="col-12">
                  <h3 class="section-title mb-3">About</h3>
                  <div class="form-group">
                     {{ Form::textarea('about', @$profileDetail->about,[
                           'class'=>'form-control',
                           'placeholder' => 'Tell fans and businesses a little bit about yourself...',
                           'style' => 'height:150px'
                        ]) 
                     }}
                     <div class="form-text text-end">Max 1000 Characters</div>
                  </div>
               </div>            
               <div class="col-6">
                  <h3 class="section-title mb-3">Customize Client Questions</h3>
                  @if (DNoneClass('photo') && DNoneClass('video') && DNoneClass('media'))
                     <span class="text-danger categoryMsg">Please select a category first</span>
                  @endif
                  <div class="form-group categoryQuestionSec">
                     <div class="add-custom-questions">
                        <a class="customize-qstns-btn photo {{ @DNoneClass('photo') }}" data-bs-toggle="modal" data-bs-target="#questionphoto">Personalized Photo</a>
                        @include('module.user.influencer.personalized-question', [
                           'personalize' => 'photo',
                           'data' => @$profileDetail->photo_question,
                        ])
                        <a class="customize-qstns-btn video {{ @DNoneClass('video') }}" data-bs-toggle="modal" data-bs-target="#questionvideo">Personalized Video</a>
                        @include('module.user.influencer.personalized-question', [
                           'personalize' => 'video',
                           'data' => @$profileDetail->video_question,
                        ])
                        <a class="customize-qstns-btn media {{ @DNoneClass('media') }}" data-bs-toggle="modal" data-bs-target="#questionmedia">Social Media Post</a>
                        @include('module.user.influencer.personalized-question', [
                           'personalize' => 'media',
                           'data' => @$profileDetail->post_question,
                        ])
                     </div>
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="form-group">                 
                     {{ Form::label('delivery_speed', 'Delivery Speed', ['class' => 'form-label']) }}
                     {{ Form::select('delivery_speed', $deliverySpeed, @$profileDetail->delivery_speed, ['class' => 'form-control', 'id' => '',]) 
                     }}
                  </div>
               </div>
               <h3 class="section-title">Social Networks</h3>
               <div class="col-md-6">
                  <div class="form-group">
                     {{ Form::label('twitter', 'Twitter', ['class' => 'form-label']) }}
                     {{ Form::text('twitter', @$profileDetail->twitter, ['class' => 'form-control', 'id' => '', 'placeholder' => 'Enter Twitter']) }}
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="form-group">
                     {{ Form::label('facebook', 'Facebook', ['class' => 'form-label']) }}
                     {{ Form::text('facebook', @$profileDetail->facebook, ['class' => 'form-control', 'id' => '', 'placeholder' => 'Enter facebook']) }}
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="form-group">
                     {{ Form::label('instagram', 'Instagram', ['class' => 'form-label']) }}
                     {{ Form::text('instagram', @$profileDetail->instagram, ['class' => 'form-control', 'id' => '', 'placeholder' => 'Enter Instagram']) }}
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="form-group">
                     {{ Form::label('youtube', 'Youtube', ['class' => 'form-label']) }}
                     {{ Form::text('youtube', @$profileDetail->youtube, ['class' => 'form-control', 'id' => '', 'placeholder' => 'Enter Youtube']) }}
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="form-group">
                     {{ Form::label('tiktok', 'Tiktok', ['class' => 'form-label']) }}
                     {{ Form::text('tiktok', @$profileDetail->tiktok, ['class' => 'form-control', 'id' => '', 'placeholder' => 'Enter Tiktok']) }}
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="form-group">
                     {{ Form::label('twitch', 'Twitch', ['class' => 'form-label']) }}
                     {{ Form::text('twitch', @$profileDetail->twitch, ['class' => 'form-control', 'id' => '', 'placeholder' => 'Enter Twitch']) }}
                  </div>
               </div>               
               <div class="col-12 text-end mt-md-5 mt-4">
                  {{ Form::button('Save', [
                     'class' => 'btn custom-btn-main',
                     'id' => 'updateInfluencerDetailFormBtn',
                     'type' => 'submit'
                  ]) }}
               </div>
            </div>
         </div>
      {{ Form::close() }} 
   </div>
</section>
@endsection
@section('customModal')   
   <div class="modal fade custom-model-design show" id="delete-question" tabindex="-1" aria-labelledby="payment-success-label" style="padding-right: 15px; display: none;" aria-modal="true" role="dialog">
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
                  <h5>Are you sure you would like to delete the 
                     question?
                  </h5>
                  <div class="form-check">
                     <input class="form-check-input" type="checkbox" value="" id="flexCheck">
                     <label class="form-check-label" for="flexCheck">
                     Please do no ask this again
                     </label>
                  </div>
                  <div class="modal-btn-group">
                     <button type="button" class="btn custom-btn-main delete-question-confirm" data-bs-dismiss="modal">Yes</button>
                     <button type="button" class="btn custom-btn-outline" data-bs-dismiss="modal">No</button>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection
@section('customScript')
<script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
<script>
   // $(document).ready(function(){
   //    var cat = "{{ $existPersonalize }}";
   //    if (cat == true) {
   //       $('.add-media-category').show();
   //       $('.add-media-select-category').hide();
   //    } else {
   //       $('.add-media-category').hide();
   //       $('.add-media-select-category').show();
   //    }
   // });

   $(".max750").each(function() {
      var type = $(this).data('type');
      $(this).on('keyup', function(){
         if ($(this).val().length > 750) {
            $('#'+type+'Btn').css("pointer-events", "none");
            $(this).next().html('Max 750 characters required!');
         } else {
            $('#'+type+'Btn').css("pointer-events", "unset");
            $(this).next().html('');
         }
      })
   });

   $(document).on('change', '.introVideo', function(){
      var existsVideo = $('.existVideoName').val();
      var form = $('#introVideoForm')[0];
      var serializedData = new FormData(form);
      $('.addIntroVideo').attr('disabled', true);
      $('.addIntroVideo').html('Processing <i class="fa fa-spinner fa-spin"></i>');
      $.ajax({
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
         type: 'post',
         url: "{{ route('introVideo') }}",
         data: serializedData,
         dataType: 'json',
         processData: false,
         contentType: false,
         cache: false,
         success: function(data) {
            var videoClip = document.getElementById('introVideoClip');
            var videoSrc = document.getElementById('introVideoSrc');
            if (data.status == true) {
               $('.addIntroVideo').attr('disabled', false);
               $('.addIntroVideo').html('Video Uploaded');
               if (existsVideo != '') {
                  videoClip.pause();
                  videoSrc.setAttribute('src', data.video);
                  videoClip.load();                
                  videoClip.play();
                  $('.successMsg').html(data.message);
                  $("#successModel").modal("show");
               } else {
                  $('.successMsg').html(data.message);
                  $("#successModel").modal("show");
                  $('.okMsgBtn').on('click', function(){
                     window.location.reload();
                  });
               }
            } else {
               $('.addIntroVideo').attr('disabled', false);
               $('.errorMsg').html(data.message);
               $("#errorModel").modal("show");
            }      
         }
      });
   });

   Dropzone.autoDiscover = false;
   $(document).ready(function(){
      $('#imageUpload').dropzone({         
         url: '{{ route('introPhotos') }}',
         method: 'post',
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
         dictDefaultMessage: "Drag your images",
         dictMaxFilesExceeded: "You can upload only 4 images at a time!",
         addRemoveLinks: true,        
         enqueueForUpload: false,         
         maxFiles:4,
         maxfilesexceeded: function(file) {
            this.removeAllFiles();
            this.addFile(file);
         },
         uploadMultiple: false,
         previewsContainer: '#dropzonePreview',
         init: function() {            
            this.on("removedfile", function(file) {
               $.post({
                  url: "{{ route('removeIntroPhoto') }}",
                  data: {
                     name: file.name,
                     _token: $('meta[name="csrf-token"]').attr('content')
                  },
                  dataType: 'json',
                  success: function (data) {
                    
                  }
               });   
            });
         }
      });      
   });

   $(document).on('click', '.remove-intro-photo', function(){
      var id = $(this).data('id');
      var image = $(this).data('image');
      $('#confirmAlert').modal('show');
      $('.confirmDeleteBtn').on('click', function(){
         $(this).attr('disabled', true);
         $(this).html('Processing <i class="fa fa-spinner fa-spin"></i>');   
         $.ajax({
            headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: "{{ route('removeIntroPhoto') }}",
            data: { id: id, image: image },
            success: function(data) {
               if (data.status == true) {                 
                  $('.confirmDeleteBtn').attr('disabled', false);
                  $('.confirmDeleteBtn').html('Yes'); 
                  $('.successMsg').html(data.message);
                  $('#confirmAlert').modal('hide');
                  $('.image'+id).parent().remove();
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
   });

   $(document).ready(function(){
      $('#profileStatus').click(function(){         
         if ($(this).is(":checked")) {
            var status = 0;
         } else {
            var status = 1;
         }

         $.ajax({
            headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: "{{ route('profileStatus') }}",
            data: { 
               status: status, 
            },
            success: function(data) {
               if (data.status == true) {
                  $('#successMsgHeading').html(data.message);
                     $("#successModel").modal("show");
               } else {
                  $('#errorMsg').html(data.message);
                     $("#errorModel").modal("show");
               }          
            }
         });
      });

      $(document).on('click', '.introPhotoBtn', function(){
         $('.introVideoBtn').removeClass('active-tag-item');
         $(this).addClass('active-tag-item');
         $('.introVideoSec').css('display', 'none');
         $('.introPhotoSec').css('display', 'block');
      });

      $(document).on('click', '.introVideoBtn', function(){
         $('.introPhotoBtn').removeClass('active-tag-item');
         $(this).addClass('active-tag-item');
         $('.introPhotoSec').css('display', 'none');
         $('.introVideoSec').css('display', 'block');
      });

      $(document).on('click', '.addIntroVideo', function(){
         $('.introVideo').trigger('click');   
      });

      $(document).on('click', '.addIntroPhoto', function(){
         $('.introPhoto').trigger('click');   
      });

      $("input[type=checkbox]").change(function(){
         if(!$('#personalizedPhoto').is(':checked') && !$('#personalizedVideo').is(':checked') && !$('#socialMediaPost').is(':checked')) {
            $('.categoryMsg').removeClass('d-none');        
         }
      });     

      $('.starCategory').click(function(){
         var categoryCount = $('.starCategory').filter(':checked').length;
         if (categoryCount >= 1) {
            $('#addCategoryContinue').removeClass('d-none');
         } else {
            $('#addCategoryContinue').addClass('d-none');
         }       
         $('.categoryMsg').addClass('d-none');
         var cat = $(this).val();
         if ($(this).is(":checked")) {            
            $('.'+cat).removeClass('d-none');
            $('.'+cat+'ClientQues').val(cat);
         } else {            
            $('.'+cat).addClass('d-none');
            $('.'+cat+'ClientQues').val('');
         }
      });

      $('.personalizePrice').click(function(){
         var type = $(this).data('type');
         if ($(this).is(":checked")) {
            $('.'+type+'WaterMarkPrice').removeClass('d-none');
         } else {
            $('.'+type+'WaterMarkPrice').children().val('');
            $('.'+type+'WaterMarkPrice').addClass('d-none');
         }
      });

      $('.personalizeSocial').click(function(){
         var type = $(this).data('type');
         if ($(this).is(":checked")) {
            $('.'+type).removeClass('d-none');
         } else {
            $('.'+type).addClass('d-none');
            $('.'+type+' input').val('');
         }
      });      
   });

   $(document).ready(function(){
      $(".appendphotoQuestions").click(function(){
         var sec = $(this).data('type');
         var textClass = '';
         var length = $('.questionphotoSec textarea').length;
         if (length < 2) {
            length = length+1;
            textClass = 'photoQus'+length;
         }
         $(".questionphotoSec").append("<div class='form-group'><label class='form-label d-flex'>Insert Question<div class='ms-auto qstns-action-btn'><a class='qstn-delete' href='#' data-bs-toggle='modal' data-bs-target='#delete-question'><i class='fa fa-trash'></i></a></div></label><textarea type='text' name='"+sec+"[qus][]' class='form-control "+textClass+"' placeholder='Enter Question Text...' style='height: 100px;'></textarea><div class='form-text text-end'>Max 750 Characters</div></div>");
      });
      $(".appendvideoQuestions").click(function(){
         var sec = $(this).data('type');
         var textClass = '';
         var length = $('.questionvideoSec textarea').length;
         if (length < 2) {
            length = length+1;
            textClass = 'videoQus'+length;
         }
         $(".questionvideoSec").append("<div class='form-group'><label class='form-label d-flex'>Insert Question<div class='ms-auto qstns-action-btn'><a class='qstn-delete' href='#' data-bs-toggle='modal' data-bs-target='#delete-question'><i class='fa fa-trash'></i></a></div></label><textarea type='text' name='"+sec+"[qus][]' class='form-control "+textClass+"' placeholder='Enter Question Text...' style='height: 100px;'></textarea><div class='form-text text-end'>Max 750 Characters</div></div>");
      });
      $(".appendmediaQuestions").click(function(){
         var sec = $(this).data('type');
         var textClass = '';
         var length = $('.questionmediaSec textarea').length;
         if (length < 2) {
            length = length+1;
            textClass = 'mediaQus'+length;
         }
         $(".questionmediaSec").append("<div class='form-group'><label class='form-label d-flex'>Insert Question<div class='ms-auto qstns-action-btn'><a class='qstn-delete' href='#' data-bs-toggle='modal' data-bs-target='#delete-question'><i class='fa fa-trash'></i></a></div></label><textarea type='text' name='"+sec+"[qus][]' class='form-control "+textClass+"' placeholder='Enter Question Text...' style='height: 100px;'></textarea><div class='form-text text-end'>Max 750 Characters</div></div>");
      });
   });

   $(document).on('click', '.qstn-delete', function(){
      var removeQusSec = $(this).parent().parent().parent();
      $('.delete-question-confirm').click(function() {
         removeQusSec.remove();          
      });
   });

   $(".add-category-continue").click(function(){
      $(".add-media-select-category").show();
      $(".add-media-category").hide();
   });

   $(".influencer-category-save").click(function(){
      $(".add-media-select-category").hide();
      $(".add-media-category").show();
   });

   $(".add-socailpost-btn").click(function(){
      $(".add-media-category").hide();
      $(".add-media-select-socail").show();
   });
   
   $(".influencer-social-save").click(function(){
      $(".add-media-category").show();
      $(".add-media-select-socail").hide();
   });

   $(document).ready(function(){
      var photoQus = $('.photoDesc').val();
      var photoQus1 = $('.photoQus1').val();
      var photoQus2 = $('.photoQus2').val();
   });

   $("#updateProfileCat").validate({    
      rules: {
         // name: {
         //    required: true,
         // },
         // email: {
         //    required: true,
         // },              
      },
      messages: {
         // name: "Please enter name!",
         // email: "Please enter email!",        
      },
      submitHandler: function(form) {
         var serializedData = new FormData(form);
         // $("#err_mess").html('');
         // $('#updateInfluencerDetailFormBtn').attr('disabled');
         $('#updateProfileCatBtn').html('Processing <i class="fa fa-spinner fa-spin"></i>');      
         $.ajax({
            headers: {
              'X-CSRF-Token': $('input[name="_token"]').val()
            },
            type: 'post',
            url: "{{ route('updateProfileCat') }}",
            data: serializedData,
            dataType: 'json',
            processData: false,
            contentType: false,
            cache: false,
            success: function(data) {
               if (data.status == true) {
                  $('#updateProfileCatBtn').html('Saved');
                  $('.successMsg').html(data.message);
                  $("#successModel").modal("show");
                  $(".add-media-select-category").hide();
                  $(".add-media-category").show();
               } else {
                  $('.errorMsg').html(data.message);
                  $("#errorModel").modal("show");
               }
            }
         });
         return false;
      }
   });

    $("#videoForm").validate({    
      rules: {
         "video[desc]": "required"         
      },
      messages: {
         "video[desc]": "Please enter description!",
      },
      submitHandler: function(form) {
         
      }
   });

   $(document).on('click', '#photoBtn', function(){
      var qus1 = $('.photoQus1').val();
      var qus2 = $('.photoQus2').val();
      var photoDesc = $('.photoDesc').val();        
      if (photoDesc == "") {
         $('.photoDesc').css({'border': '2px solid red'});
         return false;
      }        
      if (qus1 == "") {
         $('.photoQus1').css({'border': '2px solid red'});
         return false;
      }
      // if (qus2 == "") {
      //    $('.photoQus2').css({'border': '2px solid red'});
      //    return false;
      // }
      $('textarea').css({'border': '1px solid #E5E0EB'});
      $('#questionphoto').modal('hide');
   });

   $(document).on('click', '#videoBtn', function(){
      var qus1 = $('.videoQus1').val();
      var qus2 = $('.videoQus2').val();
      var videoDesc = $('.videoDesc').val();        
      if (videoDesc == "") {
         $('.videoDesc').css({'border': '2px solid red'});
         return false;
      }
      if (qus1 == "") {
         $('.videoQus1').css({'border': '2px solid red'});
         return false;
      }
      // if (qus2 == "") {
      //    $('.videoQus2').css({'border': '2px solid red'});
      //    return false;
      // }
      $('textarea').css({'border': '1px solid #E5E0EB'});
      $('#questionvideo').modal('hide');
   });

   $(document).on('click', '#mediaBtn', function(){
      var qus1 = $('.mediaQus1').val();
      var qus2 = $('.mediaQus2').val();
      var mediaDesc = $('.mediaDesc').val();        
      if (mediaDesc == "") {
         $('.mediaDesc').css({'border': '2px solid red'});
         return false;
      }
      if (qus1 == "") {
         $('.mediaQus1').css({'border': '2px solid red'});
         return false;
      }
      // if (qus2 == "") {
      //    $('.mediaQus2').css({'border': '2px solid red'});
      //    return false;
      // }
      $('textarea').css({'border': '1px solid #E5E0EB'});
      $('#questionmedia').modal('hide');
   });

   $("#updateInfluencerDetailForm").validate({    
      rules: {
         about: {
            required: true,
            maxlength: 1000
         },
         twitter: {
            required: true,
            url: true
         },
         facebook: {
            required: true,
            url: true
         },
         instagram: {
            required: true,
            url: true
         },
         youtube: {
            required: true,
            url: true
         },
         tiktok: {
            required: true,
            url: true
         },
         twitch: {
            required: true,
            url: true
         },
      },
      messages: {
         about: {
            required: "Please enter about!",
            maxlength: "Max 1000 characters required!",
         },
         twitter: {
            required: "Please enter about!",
            url: "Please enter a valid url!",
         },
         facebook: {
            required: "Please enter about!",
            url: "Please enter a valid url!",
         },
         instagram: {
            required: "Please enter about!",
            url: "Please enter a valid url!",
         },
         youtube: {
            required: "Please enter about!",
            url: "Please enter a valid url!",
         },
         tiktok: {
            required: "Please enter about!",
            url: "Please enter a valid url!",
         },
         twitch: {
            required: "Please enter about!",
            url: "Please enter a valid url!",
         },
      },
      submitHandler: function(form) {
         var qus1 = $('.photoQus1').val();
         var qus2 = $('.photoQus2').val();
         var photoDesc = $('.photoDesc').val();
         var video1 = $('.videoQus1').val();
         var video2 = $('.videoQus2').val();
         var videoDesc = $('.videoDesc').val();
         var post1 = $('.mediaQus1').val();
         var post2 = $('.mediaQus2').val();        
         var postDesc = $('.mediaDesc').val();
         if (!$('.photo').hasClass('d-none')) {
            if(photoDesc == "" || qus1 == ""){
               if (photoDesc == "") {
                  $('.photoDesc').css({'border': '2px solid red'});
               }
               if (qus1 == "") {
                  $('.photoQus1').css({'border': '2px solid red'});
               }
               // if (qus2 == "") {
               //    $('.photoQus2').css({'border': '2px solid red'});
               // }
               jQuery("#questionphoto").modal('show');
               return false;
            }            
         }
         if (!$('.video').hasClass('d-none')) {
            if(videoDesc == "" || video1 == ""){
               if (videoDesc == "") {
                  $('.videoDesc').css({'border': '2px solid red'});
               }
               if (video1 == "") {
                  $('.videoQus1').css({'border': '2px solid red'});
               }
               // if (video2 == "") {
               //    $('.videoQus2').css({'border': '2px solid red'});
               // }
               jQuery("#questionvideo").modal('show');
               return false;
            }
         }
         if (!$('.media').hasClass('d-none')) {
            if(postDesc == "" || post1 == ""){
               if (postDesc == "") {
                  $('.mediaDesc').css({'border': '2px solid red'});
               }
               if (post1 == "") {
                  $('.mediaQus1').css({'border': '2px solid red'});
               }
               // if (post2 == "") {
               //    $('.mediaQus2').css({'border': '2px solid red'});
               // }
               jQuery("#questionmedia").modal('show');
               return false;
            }            
         }
         var serializedData = new FormData(form);
         $("#err_mess").html('');
         $('#updateInfluencerDetailFormBtn').attr('disabled', true);
         $('#updateInfluencerDetailFormBtn').html('Processing <i class="fa fa-spinner fa-spin"></i>');      
         $.ajax({
            headers: {
              'X-CSRF-Token': $('input[name="_token"]').val()
            },
            type: 'post',
            url: "{{ route('updateProfileDetail') }}",
            data: serializedData,
            dataType: 'json',
            processData: false,
            contentType: false,
            cache: false,
            success: function(data) {
               if (data.status == true) {
                  $('#updateInfluencerDetailFormBtn').attr('disabled', false);
                  $('#updateInfluencerDetailFormBtn').html('Saved');
                  $('.successMsg').html(data.message);
                  $("#successModel").modal("show");
               } else {
                  $('#updateInfluencerDetailFormBtn').attr('disabled', false);
                  $('#updateInfluencerDetailFormBtn').html('Saved');
                  $('.errorMsg').html(data.message);
                  $("#errorModel").modal("show");
               }
            }
         });
         return false;
      }
   });

   $('.profileimgcarousel').owlCarousel({
      loop:true,
      nav:true, 
      margin: 20,
      navText: [
         "<i class='fa fa-chevron-left'></i>",
         "<i class='fa fa-chevron-right'></i>"
      ],
      autoplay: true,
      autoplayHoverPause: true,
      responsive:{
         0:{
            items:1
         },
         600:{
            items:1
         },
         1000:{
            items:1
         }
      }
   })
</script>
@endsection