@extends('layout.master')
@section('content')
<section class="pt-5 pb-5 contactus-section">
   <div class="container">
      <div class="d-flex mb-4">
         <h3 class="section-title">Contact Us</h3>
      </div>
      {{ Form::open(['url' => route('contactUs'), 'id' => 'contactUs']) }}
      <div class="row">
         <div class="col-md-12">
            <div class="form-group py-2">
               {{ Form::label('name', 'Name', ['class' => 'form-label']) }}
               {{ Form::text('name', '', ['class' => 'form-control', 'id' => '', 'placeholder' => 'Enter Name']) }}
            </div>
         </div>
         <div class="col-md-12">
            <div class="form-group py-2">
               {{ Form::label('reaching_out_us', 'Why are you reaching out to us?', ['class' => 'form-label']) }}
               {{ Form::select('reaching_out_us', reachingOutUsOptions(), 2, ['class' => 'form-control', 'id' => 'select-reason']); }}
            </div> 
         </div>
         <div class="col-md-6">
            <div class="form-group py-2">
               {{ Form::label('email', 'Email', ['class' => 'form-label']) }}
               {{ Form::email('email', '', [
                     'class' => 'form-control',
                     'id' => 'email',
                     'placeholder' => 'Enter Email'
                  ]) 
               }}
            </div>
         </div>
         <div class="col-md-6">
            <div class="form-group py-2">
               {{ Form::label('confirm_email', 'Confirm Email', ['class' => 'form-label']) }}
               {{ Form::email('confirm_email', '', [
                     'class' => 'form-control',
                     'id' => 'confirmEmail',
                     'placeholder' => 'Enter Confirm Email'
                  ])
               }}
            </div>
         </div>                
         <div class="col-md-12">                       
            <div class="reason-output">
               <div class="reason-option reason-question d-none" id="questionDescription">
                  <div class="form-group py-2">
                     {{ Form::label('question_description', 'Description of Question', ['class' => 'form-label']) }}
                     {{ Form::textarea('question_description',null,['class'=>'form-control', 'style' => 'height:150px']) }}
                     <div class="form-text text-end">Max 750 Characters</div>
                  </div>                 
               </div>
               <div class="reason-option reason-enroll d-none" id="enrollSection">
                  <div class="form-group py-2">
                     {{ Form::label('primary_platform', 'What’s your primary platform?', ['class' => 'form-label']) }}
                     {{ Form::select('primary_platform', primaryPlatformOptions(), 2, ['class' => 'form-select form-control']); }}
                  </div>                              
                  <div class="form-group py-2">
                     <label for="" class="form-label">Please select up to 3 genres that best describe your content</label>
                     <div class="genres-items">
                        @foreach ($genreses as $genres)
                           <span class="genres-option" data-id="{{ $genres->id }}">
                              <input type="hidden" name="genres[]" class="genresIds">
                              {{ $genres->name }}
                           </span>
                        @endforeach
                     </div>
                  </div>
                  <div class="row">
                     <h3 class="section-title">Social Networks</h3>
                     <div class="col-md-6">
                        <div class="form-group">
                           {{ Form::label('twitter', 'Twitter', ['class' => 'form-label']) }}
                           {{ Form::text('twitter', '', ['class' => 'form-control', 'id' => '', 'placeholder' => 'Enter Twitter']) }}
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           {{ Form::label('facebook', 'Facebook', ['class' => 'form-label']) }}
                           {{ Form::text('facebook', '', ['class' => 'form-control', 'id' => '', 'placeholder' => 'Enter facebook']) }}
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           {{ Form::label('instagram', 'Instagram', ['class' => 'form-label']) }}
                           {{ Form::text('instagram', '', ['class' => 'form-control', 'id' => '', 'placeholder' => 'Enter Instagram']) }}
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           {{ Form::label('youtube', 'Youtube', ['class' => 'form-label']) }}
                           {{ Form::text('youtube', '', ['class' => 'form-control', 'id' => '', 'placeholder' => 'Enter Youtube']) }}
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           {{ Form::label('tiktok', 'Tiktok', ['class' => 'form-label']) }}
                           {{ Form::text('tiktok', '', ['class' => 'form-control', 'id' => '', 'placeholder' => 'Enter Tiktok']) }}
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           {{ Form::label('twitch', 'Twitch', ['class' => 'form-label']) }}
                           {{ Form::text('twitch', '', ['class' => 'form-control', 'id' => '', 'placeholder' => 'Enter Twitch']) }}
                        </div>
                     </div>  
                  </div>
                  <div class="form-group py-2">
                     {{ Form::label('anything_else', 'Anything else you would like to add?', ['class' => 'form-label']) }}
                     {{ Form::textarea('anything_else',null,['class'=>'form-control', 'style' => 'height:150px']) }}
                     <div class="form-text text-end">Max 750 Characters</div>
                  </div>                
               </div>
               <div class="row">
                  
               </div>
            </div>
         </div>         
         <div class="col-12 text-end mt-sm-5 mt-3">
            <input type="hidden" id="contactUsFormRoute">
            {{ Form::button('Submit', [
               'class' => 'btn custom-btn-main',
               'id' => 'contactUsBtn',
               'type' => 'submit'
            ]) }}
         </div>
      </div>
      {{ Form::close() }}  
   </div>
</section>
@endsection
@section('customScript')
<script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
<script type="text/javascript">
   $(function() {
      $('#select-reason').change(function(){
         if ($(this).val() == 'reason-issue' || $(this).val() == 'reason-question') {
            var contact = "{{ route('contactUs') }}";
            $('#email').prop('readonly', false);
            $('#email').val('');
            $('#confirmEmail').prop('readonly', false);
            $('#confirmEmail').val('');
            $('#contactUsFormRoute').val(contact);
            $('#enrollSection').addClass('d-none');
            $('#questionDescription').removeClass('d-none');
         } else {
            var user = "{{ route('userCreate') }}";
            var authEmail = "{{ Auth::check() ? Auth::user()->email : '' }}";
            $('#email').val(authEmail);
            $('#email').prop('readonly', {{ Auth::check() ? true : false }});
            $('#confirmEmail').val(authEmail);
            $('#confirmEmail').prop('readonly', {{ Auth::check() ? true : false }});
            $('#contactUsFormRoute').val(user);
            $('#questionDescription').addClass('d-none');
            $('#enrollSection').removeClass('d-none');
         }
      });
   });

   var genresItem = '.genres-items span';   
   $(document).on('click', '.genres-option', function(){
      var optionVal = $(this).data('id');
      if(jQuery(this).hasClass('active')){
         $(this).toggleClass('active');
         $(this).children('.genresIds').val('');
         return;  
      }
      if(jQuery('.genres-items span.active').length < 3) {
         $(this).toggleClass('active');
         $(this).children('.genresIds').val(optionVal);
      } else {
         toastr.error('You can select only up to 3');
      }
   });   

   $("#contactUs").validate({    
      rules: {
         name: {
            required: true,
         },
         email: {
            required: true,
         },
         confirm_email: {
            required: true,
            equalTo: "#email"
         },
         reaching_out_us: {
            required: true,
         },
         question_description: {
            required: true,
            maxlength: 750
         },
         primary_platform: {
            required: true,
         },
         anything_else: {
            // required: false,
            maxlength: 750
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
         name: "Please enter name!",
         email: "Please enter email!",
         confirm_email: {
            required: "Please enter confirm email!",  
            equalTo: "Email and confirm email must be matched!"  
         },
         reaching_out_us: "Please select one!",
         question_description: {
            required: "Please enter question description!",
            maxlength: "Max 750 characters required!",
         },
         primary_platform: "Please select primary platform!",        
         anything_else: {
            // required: "Please enter description!",
            maxlength: "Max 750 characters required!!",
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
         $('#contactUsBtn').attr('disabled', true);
         $('#contactUsBtn').html('Processing <i class="fa fa-spinner fa-spin"></i>');      
         var formRoute = $('#contactUsFormRoute').val();
         var serializedData = $(form).serialize();
         $("#err_mess").html('');
         $.ajax({
            headers: {
              'X-CSRF-Token': $('input[name="_token"]').val()
            },
            type: 'post',
            url: formRoute,
            data: serializedData,
            dataType: 'json',
            success: function(data) {
               if (data.status == true) {
                  $('#contactUsBtn').attr('disabled', false);
                  $('#contactUsBtn').html('Submitted');
                  $('.successMsg').html(data.message);
                  $("#successModel").modal("show");
                  $('#contactUs').trigger("reset");
               } else {
                  $('#contactUsBtn').attr('disabled', false);
                  $('#contactUsBtn').html('Submit');
                  $('.errorMsg').html(data.message);
                  $("#errorModel").modal("show");
               }
            }
         });
      return false;
      }
   });
</script>
@endsection