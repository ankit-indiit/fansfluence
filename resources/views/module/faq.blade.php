@extends('layout.master')
@section('content')
<section class="pt-5 pb-5 faq-section">
   <div class="container">
      <div class="d-flex justify-content-between mb-4 page-head-title align-items-center">
         <h3 class="section-title">Frequently Asked Questions</h3>
         <form class="d-flex header-search-form position-relative">
            <input class="form-control searchFaq" type="search" placeholder="Search your issue" aria-label="Search">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search">
               <circle cx="11" cy="11" r="8"></circle>
               <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
         </form>
      </div>
      <div class="faq-lists">
         <h5 class="my-4">Buyers</h5>
         @foreach ($buyerFaqs as $faq)
            <div class="faq-accordian accordion" id="{{$faq->id}}Example">
               <div class="accordion-item">
                  <h2 class="accordion-header" id="headingOne">
                     <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$faq->id}}" aria-expanded="false" aria-controls="collapse{{$faq->id}}">
                     <span><img src="{{ asset('assets/img/faq-icon.svg') }}   " class="img-fluid"></span> {{ $faq->question }}
                     </button>
                  </h2>
                  <div id="collapse{{$faq->id}}" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#{{$faq->id}}Example">
                     <div class="accordion-body">
                        <ol class="list-group list-group-numbered">
                           @foreach ($faq->faq as $ans)
                              <li class="list-group-item">{{ $ans->answer }}</li>
                           @endforeach
                        </ol>
                     </div>
                  </div>
               </div>               
            </div>
         @endforeach
         <h5 class="my-4">Influencer</h5>
         @foreach ($influencerFaqs as $faq)
            <div class="faq-accordian accordion" id="{{$faq->id}}Example">
               <div class="accordion-item">
                  <h2 class="accordion-header" id="headingOne">
                     <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$faq->id}}" aria-expanded="false" aria-controls="collapse{{$faq->id}}">
                     <span><img src="{{ asset('assets/img/faq-icon.svg') }}   " class="img-fluid"></span> {{ $faq->question }}
                     </button>
                  </h2>
                  <div id="collapse{{$faq->id}}" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#{{$faq->id}}Example">
                     <div class="accordion-body">
                        <ol class="list-group list-group-numbered">
                           @foreach ($faq->faq as $ans)
                              <li class="list-group-item">{{ $ans->answer }}</li>
                           @endforeach
                        </ol>
                     </div>
                  </div>
               </div>               
            </div>
         @endforeach
         <div class="text-center mt-sm-5 mt-4">
            <a href="{{ route('contact-us') }}" class="custom-btn-main">Contact Us</a>
         </div>    
      </div>
   </div>
</section>
@endsection
@section('customScript')
<script type="text/javascript">
   $(document).on('keyup', '.searchFaq', function(){
      var faq = $(this).val();
      $.ajax({
         type: 'get',
         url: "{{ route('searchFaq') }}",
         data: {
            faq: faq,
         },
         dataType: 'json',
         success: function(data) {
            if (data.status == true) { 
              $('.faq-lists').html(data.faqs);
            }
         }
      });
   });
</script>
@endsection