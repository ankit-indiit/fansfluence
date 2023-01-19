<div class="modal fade custom-model-design show" id="add-collection" tabindex="-1" aria-labelledby="payment-success-label" aria-modal="true" role="dialog" style="display: none; padding-right: 15px;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <form action="{{ route('storeCollection') }}" method="post" id="starInfluencer">
                    @csrf
                    <div class="custom-model-inner text-center">
                        <h4>                            
                            Choose your collection
                        </h4>
                        <div class="form-group my-4 collectionList">
                            <select class="form-control collectionId" name="collection_id">
                                <option value="">Select collection</option>
                                @foreach (getCollections() as $collection)
                                    <option value="{{ $collection->id }}">{{ $collection->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" name="influencer_id" class="influencerId">
                        <input type="hidden" name="addToCollection" value="addToCollection">
                    </div>
                    <div class="custom-model-inner text-center">
                        <h4>
                            <span class="addCollection" style="cursor: pointer;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                            </span>
                            Name your new collection
                        </h4>
                        <div class="addCollectionSec">
                            
                        </div>
                    </div>                    
                    <div class="custom-model-inner text-center">
                        <button type="submit" id="starInfluencerBtn" class="btn custom-btn-main">Done</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade custom-model-design delete-option-popup" id="loginAlert" tabindex="-1" aria-labelledby="payment-success-label" aria-hidden="true" style="display: none;">
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
                    <h5>Please <a href="{{ route('login') }}" style="color: inherit;">Login</a> First!</h5>
                    <button type="button" class="btn custom-btn-main okMsgBtn" data-bs-dismiss="modal">OK</button>
                </div>                 
            </div>
        </div>
    </div>
</div>

<div class="modal fade custom-model-design delete-option-popup" id="confirmAlert" tabindex="-1" aria-labelledby="payment-success-label" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close okMsgBtn" data-bs-dismiss="modal" aria-label="Close">
                 </button>
            </div>
            <div class="modal-body">
                <div class="custom-model-inner">
                    <h4 class="text-error">Remove</h4>
                    <div class="my-4">
                        <i class="fa-4x fa fa-exclamation-triangle text-error" aria-hidden="true"></i>
                        {{-- <img src="{{ asset('assets/img/delete-icon.svg') }}"> --}}
                    </div>
                    <h5 class="mb-4">Are you sure?<br>This action cannot be undone.</h5>
                    <input type="hidden" name="influencer_id" class="influencerId">
                    <input type="hidden" name="collection_id" class="collectionId">
                    <div class="modal-btn-group">
                        <button type="submit" class="btn custom-btn-main confirmDeleteBtn" id="">Yes</button>
                        <button type="button" class="btn custom-btn-outline" data-bs-dismiss="modal">No</button>
                    </div>
                </div>                 
            </div>
        </div>
    </div>
</div>