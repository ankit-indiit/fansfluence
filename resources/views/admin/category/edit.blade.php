@extends('admin.layout.master')
@section('content')
<div class="page-wrapper">
   <div class="content container-fluid">
      <div class="row">
         <div class="col-md-12">
            <div class="card card-table">
               <div class="card-header d-flex justify-content-between align-items-center">
                  <h4 class="card-title">Update Category</h4>
                  <a href="{{ URL::previous() }}" class="btn btn-default btnwhite">Back</a>
               </div>
               <div class="card-body">
                  <div class="padBox">
                     <form method="POST" action="{{route('category.update', $category->id)}}" id="updateCategoryForm">
                        @csrf
                        @method('put')
                        <div class="row">
                           <div class="col-md-12">
                              <div class="form-group">
                                 <h1>Category Information</h1>
                              </div>
                           </div>
                           <div class="col-md-12">
                              <div class="form-group">
                                 <label>Name</label>
                                 <input class="form-control" name="name" type="text" placeholder="Enter Question" value="{{ $category->name }}">
                              </div>
                           </div>                           
                           <div class="col-md-12">
                               <div class="form-group appendAns">
                                   @if (count($category->subCategory) == 0)
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
                                   @endif
                                   @if (count($category->subCategory) > 0)
                                       @foreach ($category->subCategory as $subCategory)
                                          <div class="row mt-4">
                                             <div class="col-md-10">
                                                @if ($loop->iteration == 1)
                                                   <label>Answer</label>
                                                @endif 
                                                <input type="text" class="form-control" value="{{ $subCategory->name }}" name="sub_categories[]">
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
                        <div class="mt-2">
                           <button class="btn btn-primary" id="updateCategoryFormBtn" type="submit">Update</button>
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

   $("#updateCategoryForm").validate({
      rules: {
         name: {
           required: true,
         },                  
         "sub_categories[0]": "required",         
      },
      messages: {
         question: "Please enter question!",
         user: "Please choose user!",
         "sub_categories[0]": "Please enter sub category!"     
      },
      submitHandler: function(form) {
         var serializedData = new FormData(form);
         $("#err_mess").html('');
         $('#updateCategoryFormBtn').attr('disabled', true);
         $('#updateCategoryFormBtn').html('Processing <i class="fa fa-spinner fa-spin"></i>');
         $.ajax({
            headers: {
              'X-CSRF-Token': $('input[name="_token"]').val()
            },
            type: 'post',
            url: "{{ route('category.update', $category->id) }}",
            data: serializedData,
            dataType: 'json',
            processData: false,
            contentType: false,
            cache: false,
            success: function(data) {
               if (data.status == true) {
                  $('#updateCategoryFormBtn').attr('disabled', false);         
                  $('#updateCategoryFormBtn').html('Save Changes');
                  swal("", data.message, "success", {
                     button: "close",
                  });
                  window.location.href = "{{ URL::previous() }}";
               } else {
                  $('#updateCategoryFormBtn').attr('disabled', false);         
                  $('#updateCategoryFormBtn').html('Submit');
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