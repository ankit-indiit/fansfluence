@extends('admin.layout.master')
@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-table">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">FAQ Answer</h4>
                        <a href="{{ route('faq.index') }}" class="btn btn-default btnwhite">Back</a>
                    </div>
                    <div class="card-body">
                        <div class="padBox">
                            <form action="{{ route('faq.update') }}" id="addFaqAnsForm" method="post">
                              @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <h1>FAQ Information</h1>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                       <h5 class="text-center">{{ $faq->question }}</h5>
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
                                                   <div class="row">
                                                      <div class="col-md-10">
                                                          <label>Answer</label>
                                                          <input type="text" class="form-control" value="{{ $ans->answer }}" name="answer[]">
                                                      </div>
                                                      <div class="col-md-2">
                                                          <button type="button" class="btn btn-{{ $loop->iteration == 1 ? 'primary' : 'danger' }} mt-4 {{ $loop->iteration == 1 ? 'addFaqAns' : 'removeAnswer' }}">
                                                          <i class="fa fa-{{ $loop->iteration == 1 ? 'plus' : 'trash' }}"></i>
                                                          </button>
                                                      </div>
                                                  </div>
                                                @endforeach
                                            @endif                                     
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="type" value="answer">
                                <input type="hidden" name="qus_id" value="{{ $faq->id }}">
                                <div class="mt-2">
                                    <button class="btn btn-primary" id="addFaqAnsFormBtn" type="submit">Update</button>
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

   $("#addFaqAnsForm").validate({
       rules: {
          // question: {
          //   required: true,
          // },         
          // user: {
          //   required: true,
          // },         
       },
       messages: {
          // question: "Please enter question!",
          // user: "Please choose user",         
       },
       submitHandler: function(form) {
          var serializedData = new FormData(form);
          $("#err_mess").html('');
          $('#addFaqAnsFormBtn').attr('disabled', true);
          $('#addFaqAnsFormBtn').html('Processing <i class="fa fa-spinner fa-spin"></i>');
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
                   $('#addFaqAnsFormBtn').attr('disabled', false);         
                   $('#addFaqAnsFormBtn').html('Save Changes');
                   swal("", data.message, "success", {
                      button: "close",
                   });
                   window.location.reload();
                } else {
                   $('#addFaqAnsFormBtn').attr('disabled', false);         
                   $('#addFaqAnsFormBtn').html('Submit');
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
      return '<div class="row answerField"> <div class="col-md-10"> <label>Attribute</label> <input type="text" class="form-control" name="answer['+index+']"> </div> <div class="col-md-2"> <button type="button" class="btn btn-danger mt-4 removeAnswer"> <i class="fa fa-trash"></i> </button> </div> </div>';
   }
</script>
@endsection