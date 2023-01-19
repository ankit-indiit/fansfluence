@extends('admin.layout.master')
@section('content')
<div class="page-wrapper">
   <div class="content container-fluid">
      <div class="row">
         <div class="col-md-12">
            <div class="card card-table">
               <div class="card-header d-flex justify-content-between align-items-center">
                  <h4 class="card-title">Add FAQ</h4>
                  <a href="{{ URL::previous() }}" class="btn btn-default btnwhite">Back</a>
               </div>
               <div class="card-body">
                  <div class="padBox">
                     <form method="POST" action="{{route('faqStore')}}" id="addFaqForm">
                        @csrf
                        <div class="row">
                           <div class="col-md-12">
                              <div class="form-group">
                                 <h1>FAQ Information</h1>
                              </div>
                           </div>
                           <div class="col-md-12">
                              <div class="form-group">
                                 <label>Question</label>
                                 <input class="form-control" name="question" type="text" placeholder="Enter Question">
                              </div>
                           </div>                                     
                           <div class="col-md-12">
                              <div class="form-group">
                                 <label>FAQ For</label>
                                 <select class="form-control" name="user">
                                    {{-- <option value="">Select Role</option> --}}
                                    <option value="buyer">Buyer</option>
                                    <option value="influencer">Influencer</option>
                                 </select>
                              </div>
                           </div> 
                           <div class="col-md-12">
                               <div class="form-group appendAns">
                                   <div class="row">
                                       <div class="col-md-10">
                                           <label>Answer</label>
                                           <input type="text" class="form-control" value="" name="answer[0]">
                                       </div>
                                       <div class="col-md-2">
                                           <button type="button" class="btn btn-primary mt-4 addFaqAns">
                                           <i class="fa fa-plus"></i>
                                           </button>
                                       </div>
                                   </div>                                                                      
                               </div>
                           </div>                                      
                        </div>
                        <div class="mt-2">
                           <button class="btn btn-primary" id="addFaqFormBtn" type="submit">Submit</button>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@section('customScript')
<script type="text/javascript">
   $(document).on('click', '.addFaqAns', function() {
      var index = $('.appendAns > .answerField').length + 1;
      $('.appendAns').append(faqAnsHtml(index));      
   });

   $(document).on('click', '.removeAnswer', function() {
      $(this).parent().parent().remove();      
   });

   function readURL(input) {
       if (input.files && input.files[0]) {
           var reader = new FileReader();
           reader.onload = function (e) {
               $('.preUserImage').removeClass('d-none');
               $('.preUserImage').attr('src', e.target.result);
           }
           reader.readAsDataURL(input.files[0]);
       }
   }
   $(".userImage").change(function(){
       readURL(this);
   });

   $("#addFaqForm").validate({
      rules: {
         question: {
           required: true,
         },         
         user: {
           required: true,
         },
         "answer[0]": "required",         
      },
      messages: {
         question: "Please enter question!",
         user: "Please choose user!",
         "answer[0]": "Please enter answer!"     
      },
      submitHandler: function(form) {
         var serializedData = new FormData(form);
         $("#err_mess").html('');
         $('#addFaqFormBtn').attr('disabled', true);
         $('#addFaqFormBtn').html('Processing <i class="fa fa-spinner fa-spin"></i>');
         $.ajax({
            headers: {
              'X-CSRF-Token': $('input[name="_token"]').val()
            },
            type: 'post',
            url: "{{ route('faqStore') }}",
            data: serializedData,
            dataType: 'json',
            processData: false,
            contentType: false,
            cache: false,
            success: function(data) {
               if (data.status == true) {
                  $('#addFaqFormBtn').attr('disabled', false);         
                  $('#addFaqFormBtn').html('Save Changes');
                  swal("", data.message, "success", {
                     button: "close",
                  });
                  window.location.href = "{{ URL::previous() }}";
               } else {
                  $('#addFaqFormBtn').attr('disabled', false);         
                  $('#addFaqFormBtn').html('Submit');
                  swal("", data.errors, "error", {
                     button: "close",
                  });
               }
            }
         });
      return false;
      }
   });

   function faqAnsHtml(index) {
      return '<div class="row answerField mt-4"> <div class="col-md-10"> <input type="text" class="form-control" name="answer['+index+']"> </div> <div class="col-md-2"> <button type="button" class="btn btn-danger removeAnswer"> <i class="fa fa-trash"></i> </button> </div> </div>';
   }
</script>
@endsection