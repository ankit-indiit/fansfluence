@extends('admin.layout.master')
@section('content')
<div class="page-wrapper">
   <div class="content container-fluid">
      <div class="row">
         <div class="col-md-12">
            <div class="card card-table">
               <div class="card-header d-flex justify-content-between align-items-center">
                  <h4 class="card-title">Update FAQ</h4>
                  <a href="{{ URL::previous() }}" class="btn btn-default btnwhite">Back</a>
               </div>
               <div class="card-body">
                  <div class="padBox">
                     <form method="POST" action="{{route('faq.update')}}" id="updateFaqForm">
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
                                 <input class="form-control" name="question" type="text" value="{{ $faq->question }}" placeholder="Enter Question">
                              </div>
                           </div>            
                           <div class="col-md-12">
                              <div class="form-group">
                                 <label>FAQ For</label>
                                 <select class="form-control" name="user">
                                    {{-- <option value="">Select User</option> --}}
                                    <option {{ $faq->user == 'buyer' ? 'selected' : '' }} value="buyer">Buyer</option>
                                    <option {{ $faq->user == 'influencer' ? 'selected' : '' }} value="influencer">Influencer</option>
                                 </select>
                              </div>
                           </div>
                           <div class="col-md-12">
                               <div class="form-group appendAns">
                                    @if (count($faqAnswers) == 0)
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
                                   @endif
                                   @if (count($faqAnswers) > 0)
                                       @foreach ($faqAnswers as $ans)
                                          <div class="row mt-4">
                                             <div class="col-md-10">
                                                @if ($loop->iteration == 1)
                                                   <label>Answer</label>
                                                @endif 
                                                <input type="text" class="form-control" value="{{ $ans->answer }}" name="answer[]">
                                             </div>
                                             <div class="col-md-2">
                                                 <button type="button" class="btn btn-{{ $loop->iteration == 1 ? 'primary addFaqAns mt-4' : 'danger removeAnswer' }}">
                                                 <i class="fa fa-{{ $loop->iteration == 1 ? 'plus' : 'trash' }}"></i>
                                                 </button>
                                             </div>
                                         </div>
                                       @endforeach
                                   @endif                                     
                               </div>
                           </div>                                
                        </div>
                        <input type="hidden" name="id" value="{{ $faq->id }}">
                        <div class="mt-2">
                           <button class="btn btn-primary" id="updateFaqFormBtn" type="submit">Update</button>
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

   $("#updateFaqForm").validate({
      rules: {
         question: {
           required: true,
         },         
         user: {
           required: true,
         },         
      },
      messages: {
         question: "Please enter question!",
         user: "Please choose user",         
      },
      submitHandler: function(form) {
         var serializedData = new FormData(form);
         $("#err_mess").html('');
         $('#updateFaqFormBtn').attr('disabled', true);
         $('#updateFaqFormBtn').html('Processing <i class="fa fa-spinner fa-spin"></i>');
         $.ajax({
            headers: {
              'X-CSRF-Token': $('input[name="_token"]').val()
            },
            type: 'post',
            url: "{{ route('faq.update') }}",
            data: serializedData,
            dataType: 'json',
            processData: false,
            contentType: false,
            cache: false,
            success: function(data) {
               if (data.status == true) {
                  $('#updateFaqFormBtn').attr('disabled', false);         
                  $('#updateFaqFormBtn').html('Save Changes');
                  swal("", data.message, "success", {
                     button: "close",
                  });
                  window.location.href = "{{ URL::previous() }}";
               } else {
                  $('#updateFaqFormBtn').attr('disabled', false);         
                  $('#updateFaqFormBtn').html('Submit');
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