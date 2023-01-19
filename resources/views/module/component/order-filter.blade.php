<div class="dropdown">
   <button class="filter-btn recommended-btn dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
   <img src="{{ asset('assets/img/rcmnd-icon.svg') }}">
   @if (request()->sortOrder == 'newOld')
      New - Old
   @elseif (request()->sortOrder == 'oldNew')
      Old - New
   @else
      New - Old
   @endif
   </button>
   <div class="dropdown-menu custom-filter-dropdown" aria-labelledby="dropdownMenuButton1" style="">
      <form action="" method="get" id="orderFilter">
         <input type="hidden" name="status" value="{{ request()->status }}">
         <div class="filter-checkboxes d-flex flex-wrap">
            <div class="form-check form-check-inline w-100">
               <input
                  class="form-check-input"
                  type="radio"
                  name="sortOrder"
                  id="newOldOrder"
                  value="newOld"
                  {{ request()->sortOrder == 'newOld' ? 'checked' : '' }}
               >
               <label class="form-check-label" for="newOldOrder">New - Old</label>
            </div>
            <div class="form-check form-check-inline  w-100">
               <input
                  class="form-check-input"
                  type="radio"
                  name="sortOrder"
                  id="oldNewOrder"
                  value="oldNew"
                  {{ request()->sortOrder == 'oldNew' ? 'checked' : '' }}
               >
               <label class="form-check-label" for="oldNewOrder">Old - New</label>
            </div>
         </div>
         <button class="apply-btn" type="submit" id="orderFilterBtn">Apply</button>          
      </form>
   </div>
</div>
