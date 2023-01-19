<div class="modal fade custom-model-design show" id="question{{ $personalize }}" tabindex="-1" aria-labelledby="payment-success-label" style="padding-right: 15px; display: none;" aria-modal="true" role="dialog">
   <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            </button>
         </div>
         <div class="modal-body">
            <section class="questions-customization-section section-full-height">
               <div class="container">
                  <div class="d-flex mb-4">
                     <h3 class="section-title">Personalized {{ $personalize }}</h3>
                  </div>
                  {{-- <form action="" method="post" id="{{$personalize}}Form"> --}}
                     <div class="row">
                        {{-- <div class="col-md-6">
                           <input type="hidden" class="{{$personalize}}ClientQues" name="{{$personalize}}ClientQues" value="{{ @checkedAttr($personalize) ? $personalize : '' }}">
                           <div class="form-group">
                              <label for="" class="form-label">Who is this {{ $personalize }} for? <span>(Optional)</span></label>
                              <input
                                 type="text"
                                 name="{{ $personalize }}[for]"
                                 class="form-control" 
                                 value="{{ @$data['for'] }}"
                                 placeholder="John"
                              >
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label for="" class="form-label">Who is this {{ $personalize }} from? <span>(Optional)</span></label>
                              <input
                                 type="text"
                                 name="{{ $personalize }}[from]"
                                 class="form-control"
                                 value="{{ @$data['from'] }}"
                                 placeholder="Smith"
                              >
                           </div>
                        </div> --}}     
                        <div class="col-12">
                           <div class="questions-textarea">
                              <div class="form-group">
                                 <label for="" class="form-label d-flex">
                                    Details for Buyers to follow                                 
                                 </label>
                                 <textarea type="text" name="{{ $personalize }}[desc]" class="form-control max750 {{ $personalize }}Desc" data-type="{{ $personalize }}" placeholder="Enter Question Text..." style="height: 100px;">{{ @$data['desc'] }}</textarea>
                                 <span class="text-danger"></span>
                                 <div class="form-text text-end">Max 750 Characters</div>
                              </div>
                           </div>
                        </div>                
                        @if (isset($data['qus']))
                           <div class="col-12">
                              <div class="questions-textarea question{{ $personalize }}Sec">
                                 <input type="hidden" class="{{$personalize}}ClientQues" name="{{$personalize}}ClientQues" value="{{ @checkedAttr($personalize) ? $personalize : '' }}">
                                    @foreach ($data['qus'] as $qus)
                                       @php
                                          $index = $loop->iteration;
                                       @endphp
                                       @if (isset($qus))
                                       <div class="form-group">
                                          <label for="" class="form-label d-flex">
                                             Insert Question 
                                             <div class="ms-auto qstns-action-btn"> 
                                                <a class="qstn-delete" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#delete-question">
                                                   <i class="fa fa-trash" aria-hidden="true"></i>
                                                </a>
                                             </div>
                                          </label>
                                          <textarea type="text" name="{{ $personalize }}[qus][]" class="form-control max750 {{ $personalize }}Qus{{$index}}" data-type="{{ $personalize }}" placeholder="Enter Question Text..." style="height: 100px;">{{$qus}}</textarea>
                                          <span class="text-danger"></span>
                                          <div class="form-text text-end">Max 750 Characters</div>
                                       </div>
                                       @endif
                                    @endforeach
                              </div>
                           </div>
                        @else
                           <div class="col-12">
                              <div class="questions-textarea">
                                 <input type="hidden" class="{{$personalize}}ClientQues" name="{{$personalize}}ClientQues" value="{{ @checkedAttr($personalize) ? $personalize : '' }}">
                                 <div class="form-group">
                                    <label for="" class="form-label d-flex">
                                       Insert Question 
                                       <div class="ms-auto qstns-action-btn"> 
                                          <a class="qstn-delete" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#delete-question">
                                             <i class="fa fa-trash" aria-hidden="true"></i>
                                          </a>
                                       </div>
                                    </label>
                                    <textarea type="text" name="{{ $personalize }}[qus][]" class="form-control max750 {{ $personalize }}Qus1" data-type="{{ $personalize }}" placeholder="Enter Question Text..." style="height: 100px;"></textarea>
                                    <span class="text-danger"></span>
                                    <div class="form-text text-end">Max 750 Characters</div>
                                 </div>
                                 <div class="questions-textarea question{{ $personalize }}Sec">
                                 <input type="hidden" class="{{$personalize}}ClientQues" name="{{$personalize}}ClientQues" value="{{ @checkedAttr($personalize) ? $personalize : '' }}">
                                 <div class="form-group">
                                    <label for="" class="form-label d-flex">
                                       Insert Question 
                                       <div class="ms-auto qstns-action-btn"> 
                                          <a class="qstn-delete" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#delete-question">
                                             <i class="fa fa-trash" aria-hidden="true"></i>
                                          </a>
                                       </div>
                                    </label>
                                    <textarea type="text" name="{{ $personalize }}[qus][]" class="form-control max750 {{ $personalize }}Qus2" data-type="{{ $personalize }}" placeholder="Enter Question Text..." style="height: 100px;"></textarea>
                                    <span class="text-danger"></span>
                                    <div class="form-text text-end">Max 750 Characters</div>
                                 </div>
                              </div>
                           </div>
                        @endif
                        <div class="col-12 mt-sm-5 d-flex justify-content-end mt-3">
                           <a href="javascript:void(0);" class="custom-btn-outline me-3 append{{ $personalize }}Questions" data-type="{{ $personalize }}">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus">
                                 <line x1="12" y1="5" x2="12" y2="19"></line>
                                 <line x1="5" y1="12" x2="19" y2="12"></line>
                              </svg>
                              Add Question
                           </a>
                           <a href="javascript:void(0);" class="custom-btn-main" id="{{$personalize}}Btn">Save</a>
                        </div>                     
                     </div>                     
                  {{-- </form> --}}
               </div>
            </section>
         </div>
      </div>
   </div>
</div>