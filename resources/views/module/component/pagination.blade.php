<div class="pagination-section">
   <nav aria-label="Page navigation example">
      <ul class="pagination">
         <li class="page-item {{ $pagination->previousPageUrl() ? '' : 'disable' }}">
            <a class="page-link" href="{{ $pagination->previousPageUrl() }}" aria-label="Previous">
               <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left">
                  <polyline points="15 18 9 12 15 6"></polyline>
               </svg>
            </a>
         </li>
         @for ($page = 1; $page <= $pagination->lastPage(); $page++)
            <li class="page-item {{ $page == $pagination->currentPage() ? 'active' : '' }}">
               <a class="page-link" href="{{ $pagination->url($page) }}">{{ $page }}</a>
            </li>
         @endfor
         <li class="page-item {{ $pagination->nextPageUrl() ? '' : 'disable' }}">
            <a class="page-link" href="{{ $pagination->nextPageUrl() }}" aria-label="Previous">
               <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                  <polyline points="9 18 15 12 9 6"></polyline>
               </svg>
            </a>
         </li>
      </ul>
   </nav>
</div>