@extends('admin.layout.master')
@section('content')
<div class="page-wrapper">
   <div class="content container-fluid">
      <div class="row">
         <div class="col-md-12">
            <div class="card card-table">
               <div class="card-header d-flex justify-content-between align-items-center">
                  <h4 class="card-title">Add Category</h4>
                  <a href="{{ URL::previous() }}" class="btn btn-default btnwhite">Back</a>
               </div>
               <div class="card-body">
                  <div class="padBox">
                     <form method="POST" action="{{route('category.store')}}" id="addCategoryForm">
                        @csrf
                        <div class="row">
                           <div class="col-md-12">
                              <div class="form-group">
                                 <h1>Category Information</h1>
                              </div>
                           </div>
                           <div class="col-md-12">
                              <div class="form-group">
                                 <label>Name</label>
                                 <input class="form-control" name="name" type="text" placeholder="Enter Question">
                              </div>
                           </div>                           
                           <div class="col-md-12">
                               <div class="form-group appendAns">
                                   <div class="row">
                                       <div class="col-md-10">
                                           <label>Sub Category</label>
                                           <input type="text" class="form-control" value="" name="sub_categories[0]">
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
                           <button class="btn btn-primary" id="addCategoryFormBtn" type="submit">Submit</button>
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

   $("#addCategoryForm").validate({
      rules: {
         name: {
           required: true,
         },                  
         "sub_categories[0]": "required",         
      },
      messages: {
         name: "Please enter name!",
         user: "Please choose user!",
         "sub_categories[0]": "Please enter sub_categories!"     
      },
      submitHandler: function(form) {
         var serializedData = new FormData(form);
         $("#err_mess").html('');
         $('#addCategoryFormBtn').attr('disabled', true);
         $('#addCategoryFormBtn').html('Processing <i class="fa fa-spinner fa-spin"></i>');
         $.ajax({
            headers: {
              'X-CSRF-Token': $('input[name="_token"]').val()
            },
            type: 'post',
            url: "{{ route('category.store') }}",
            data: serializedData,
            dataType: 'json',
            processData: false,
            contentType: false,
            cache: false,
            success: function(data) {
               if (data.status == true) {
                  $('#addCategoryFormBtn').attr('disabled', false);         
                  $('#addCategoryFormBtn').html('Save Changes');
                  swal("", data.message, "success", {
                     button: "close",
                  });
                  window.location.href = "{{ URL::previous() }}";
               } else {
                  $('#addCategoryFormBtn').attr('disabled', false);         
                  $('#addCategoryFormBtn').html('Submit');
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
      return '<div class="row answerField mt-4"> <div class="col-md-10"> <input type="text" class="form-control" name="sub_categories['+index+']"> </div> <div class="col-md-2"> <button type="button" class="btn btn-danger removeAnswer"> <i class="fa fa-trash"></i> </button> </div> </div>';
   }
</script>
@endsection