<form class="d-flex header-search-form position-relative ms-auto">
   <input type="hidden" name="status" value="{{ request()->status }}">
   <input
      class="form-control"
      type="search"
      name="search"
      placeholder="Search"
      value="{{ request()->search ? request()->search : '' }}"
      aria-label="Search"
   >
   <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search">
      <circle cx="11" cy="11" r="8"></circle>
      <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
   </svg>
</form>