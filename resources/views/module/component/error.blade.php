<div class="modal fade custom-model-design {{ $session ? 'show' : '' }}" id="errorModel" tabindex="-1" aria-labelledby="payment-success-label" aria-hidden="true" style="display:{{ $session ? 'block' : 'none' }};">
   <div class="modal-dialog modal-dialog-centered">
   <div class="modal-content">
      <div class="modal-header">
         <button type="button" class="btn-close okMsgBtn" data-bs-dismiss="modal" aria-label="Close">
         </button>
      </div>
      <div class="modal-body">
         <div class="custom-model-inner">
             <h4 class="text-error">Whoops</h4>
             <div class="my-4">
                 <img src="{{ asset('assets/img/payment-error.svg') }}">
             </div>
             <h5 class="errorMsg">{{ Session::get('error') }}</h5>
             <p></p>
             <button type="button" class="btn custom-btn-main okMsgBtn" data-bs-dismiss="modal">OK</button>
         </div>
     </div>
   </div>
   </div>
</div>