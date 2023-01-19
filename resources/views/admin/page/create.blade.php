@extends('admin.layout.master')
@section('content')
<div class="page-wrapper">
   <div class="content container-fluid">
      <div class="row">
         <div class="col-md-12">
            <div class="card card-table">
               <div class="card-header d-flex justify-content-between align-items-center">
                  <h4 class="card-title">{{ isset($page->id) ? 'Update' : 'Add' }} Page</h4>
                  <a href="{{ route('page.index') }}" class="btn btn-default btnwhite">Back</a>
               </div>
               <div class="card-body">
                  <div class="padBox">
                     <form action="{{ route('page.store') }}" id="addPageForm" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                           <div class="col-md-12">
                              <div class="form-group">
                                 <h1>Page Information</h1>
                              </div>
                           </div>
                           <div class="col-md-12">
                              <div class="form-group">
                                 <label>Title</label>
                                 <input class="form-control" name="title" type="text" value="{{ @$page->title }}" placeholder="Enter Title">
                              </div>
                           </div>
                           <div class="col-md-12">
                              <div class="form-group">
                                 <label>Content</label>
                                 <textarea name="content" id="content" rows="10" cols="80">{{ @$page->content }}</textarea>
                              </div>
                           </div> 
                        </div>
                        <input type="hidden" name="id" value="{{ @$page->id }}">
                        <div class="mt-2">
                           <button class="btn btn-primary" id="addPageFormBtn" type="submit">
                              {{ isset($page->id) ? 'Update' : 'Submit' }}
                           </button>
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
<script src="{{ asset('admin/assets/ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript">
   var editor1 =  CKEDITOR.replace('content', {});
   editor1.on('change', function() {
     editor1.updateElement();
   });

   $("#addPageForm").validate({
      rules: {
         title: {
           required: true,
         },
         content: {
           required: true,
         },                
      },
      messages: {
         title: "Please enter title",
         content: "Please enter content",                            
      },      
      submitHandler: function(form) {
         var serializedData = new FormData(form);
         $("#err_mess").html('');
         $('#addPageFormBtn').attr('disabled', true);
         $('#addPageFormBtn').html('Processing <i class="fa fa-spinner fa-spin"></i>');
         $.ajax({
            headers: {
              'X-CSRF-Token': $('input[name="_token"]').val()
            },
            type: 'post',
            url: "{{ route('page.store') }}",
            data: serializedData,
            dataType: 'json',
            processData: false,
            contentType: false,
            cache: false,
            success: function(data) {
               if (data.status == true) {
                  $('#addPageFormBtn').attr('disabled', false);         
                  $('#addPageFormBtn').html('Save Changes');
                  swal("", data.message, "success", {
                     button: "close",
                  });
                  $('.swal2-confirm').on('click', function(){
                     window.location.href = "";
                  });
               } else {
                  $('#addPageFormBtn').attr('disabled', false);         
                  $('#addPageFormBtn').html('Submit');
                  swal("", data.errors, "error", {
                     button: "close",
                  });
               }
            }
         });
      return false;
      }
   });
</script>
@endsection