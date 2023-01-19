<form action="" method="get">  
   <input type="hidden" name="search" value="{{ request()->search }}">
   <div class="d-flex mb-sm-5 mb-3 expoer-top-filtes">
      <!-- categories filter start -->
      <div class="single-sidebar me-3">
         <div class="dropdown">
            <button class="filter-btn dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
               @switch(request()->price)
                  @case(25)
                     $0-$25
                  @break
                  @case(100)
                     $25-$100
                  @break
                  @case(300)
                     $100-$300
                  @break 
                  @case('300+')
                     $300+
                  @break                  
                  @default
                     Budget
               @endswitch            
            </button>
            <div class="dropdown-menu custom-filter-dropdown" aria-labelledby="dropdownMenuButton1">
                  <div class="filter-checkboxes d-flex flex-wrap">
                     <div class="form-check form-check-inline w-50">
                        <input
                           class="form-check-input"
                           type="radio"
                           name="price"
                           id="price1"
                           value="25"
                           {{ request()->price == 25 ? 'checked' : '' }}
                        >
                        <label class="form-check-label" for="price1">$0-$25</label>
                     </div>
                     <div class="form-check form-check-inline  w-50">
                        <input
                           class="form-check-input"
                           type="radio"
                           name="price"
                           id="price2"
                           value="300"
                           {{ request()->price == 300 ? 'checked' : '' }}
                        >
                        <label class="form-check-label" for="price2">$100-$300</label>
                     </div>
                     <div class="form-check form-check-inline  w-50">
                        <input
                           class="form-check-input"
                           type="radio"
                           name="price"
                           id="price3"
                           value="100"
                           {{ request()->price == 100 ? 'checked' : '' }}
                        >
                        <label class="form-check-label" for="price3">$25-$100</label>
                     </div>
                     <div class="form-check form-check-inline  w-50">
                        <input
                           class="form-check-input"
                           type="radio"
                           name="price"
                           id="price4"
                           value="300+"
                           {{ request()->price == '300+' ? 'checked' : '' }}
                        >
                        <label class="form-check-label" for="price4">$300+</label>
                     </div>
                  </div>
                  <div class="filter-inputs">
                     <div class="row  mb-4">
                        <div class="col-md-6">
                           <label for="minPrice" class="form-label">Min</label>
                           <input
                              type="number"
                              class="form-control"
                              id="minPrice"
                              name="minPrice"
                              value="{{ @request()->minPrice }}"
                           >
                        </div>
                        <div class="col-md-6">
                           <label for="maxPrice" class="form-label">Max</label>
                           <input
                              type="number"
                              class="form-control"
                              id="maxPrice"
                              name="maxPrice"
                              value="{{ @request()->maxPrice }}"
                           >
                        </div>
                     </div>
                     <button type="submit" class="apply-btn">Apply</button>
                  </div>                     
            </div>
         </div>
      </div>
      <div class="single-sidebar me-3">
         <div class="dropdown">
            <button class="filter-btn dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
               @switch(request()->speed)
                  @case(1)
                     24 Hours
                  @break
                  @case(2)
                     3 Days
                  @break
                  @case(3)
                     5 Days
                  @break
                  @case(5)
                     Anytime
                  @break                  
                  @default
                     Delivery Speed
               @endswitch
            </button>
            <div class="dropdown-menu custom-filter-dropdown" aria-labelledby="dropdownMenuButton1">
               <div class="filter-checkboxes d-flex flex-wrap">
                  @foreach (deliverySpeed() as $speed)
                  <div class="form-check form-check-inline w-100">
                     <input
                        class="form-check-input"
                        type="radio"
                        name="speed"
                        id="speed{{ $speed->id }}"
                        value="{{ $speed->id }}"
                        {{ request()->speed == $speed->id ? 'checked' : '' }}
                     >
                     <label class="form-check-label" for="speed{{ $speed->id }}">{{ $speed->estimate }}</label>
                  </div>
                  @endforeach
                  
               </div>
               <button class="apply-btn">Apply</button>
            </div>
         </div>
      </div>
      <div class="single-sidebar me-3">
         <div class="dropdown">
            <button class="filter-btn dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
               <span>
                  @if (@in_array(4, request()->ratings))
                     4 Stars
                  @elseif (@in_array(3, request()->ratings))
                     3 Stars
                  @elseif (@in_array(2, request()->ratings))
                     2 Stars
                  @elseif (@in_array(1, request()->ratings))
                     1 Stars
                  @elseif (@in_array(0, request()->ratings))
                     No Reviews Only
                  @else
                     Rating
                  @endif
                  
               </span>            
            </button>
            <div class="dropdown-menu custom-filter-dropdown" aria-labelledby="dropdownMenuButton1">
               <div class="filter-checkboxes d-flex flex-wrap">
                  <div class="form-check form-check-inline w-100">
                     <input
                        class="form-check-input"
                        type="checkbox"
                        name="ratings[]"
                        id="fourPlus"
                        value="4"
                        {{ @in_array(4, request()->ratings) ? 'checked' : '' }}
                     >
                     <label class="form-check-label" for="fourPlus">4 Stars+</label>
                  </div>
                  <div class="form-check form-check-inline  w-100">
                     <input
                        class="form-check-input"
                        type="checkbox"
                        name="ratings[]"
                        id="threePlus"
                        value="3"
                        {{ @in_array(3, request()->ratings) ? 'checked' : '' }}
                     >
                     <label class="form-check-label" for="threePlus">3 Stars</label>
                  </div>
                  <div class="form-check form-check-inline  w-100">
                     <input
                        class="form-check-input"
                        type="checkbox"
                        name="ratings[]"
                        id="twoPlus"
                        value="2"
                        {{ @in_array(2, request()->ratings) ? 'checked' : '' }}
                     >
                     <label class="form-check-label" for="twoPlus">2 Stars</label>
                  </div>
                  <div class="form-check form-check-inline  w-100">
                     <input
                        class="form-check-input"
                        type="checkbox"
                        name="ratings[]"
                        id="onePlus"
                        value="1"
                        {{ @in_array(1, request()->ratings) ? 'checked' : '' }}
                     >
                     <label class="form-check-label" for="onePlus">1 Stars</label>
                  </div>
                  <div class="form-check form-check-inline  w-100">
                     <input
                        class="form-check-input"
                        type="checkbox"
                        name="ratings[]"
                        id="noPlus"
                        value="0"
                        {{ @in_array(0, request()->ratings) ? 'checked' : '' }}
                     >
                     <label class="form-check-label" for="noPlus">No Reviews Only</label>
                  </div>
               </div>
               <button type="submit" class="apply-btn">Apply</button>
            </div>
         </div>
      </div>
      <div class="single-sidebar ms-auto">
         <div class="dropdown">
            <button class="filter-btn recommended-btn dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="{{ asset('assets/img/rcmnd-icon.svg') }}"> 
            <span>
               @switch(request()->recommended)
                  @case('asc-name')
                     Name A-Z
                  @break
                  @case('desc-name')
                     Name Z-A
                  @break
                  @case('asc-price')
                     Price Low-High
                  @break
                  @case('desc-price')
                     Price High-Low
                  @break
                  @default
                     Recommended
               @endswitch
            </span>
            </button>
            <div class="dropdown-menu custom-filter-dropdown" aria-labelledby="dropdownMenuButton1">
               <div class="filter-checkboxes d-flex flex-wrap">
                  <div class="form-check form-check-inline w-100">
                     <input
                        class="form-check-input"
                        type="radio"
                        name="recommended"
                        id="ascName"
                        value="asc-name"
                        {{ request()->recommended == 'asc-name' ? 'checked' : '' }}
                     >
                     <label class="form-check-label" for="ascName">Name A-Z</label>
                  </div>
                  <div class="form-check form-check-inline  w-100">
                     <input
                        class="form-check-input"
                        type="radio"
                        name="recommended"
                        id="descName"
                        value="desc-name"
                        {{ request()->recommended == 'desc-name' ? 'checked' : '' }}
                     >
                     <label class="form-check-label" for="descName">Name Z-A</label>
                  </div>
                  <div class="form-check form-check-inline  w-100">
                     <input
                        class="form-check-input"
                        type="radio"
                        name="recommended"
                        id="ascPrice"
                        value="asc-price"
                        {{ request()->recommended == 'asc-price' ? 'checked' : '' }}
                     >
                     <label class="form-check-label" for="ascPrice">Price Low-High</label>
                  </div>
                  <div class="form-check form-check-inline  w-100">
                     <input
                        class="form-check-input"
                        type="radio"
                        name="recommended"
                        id="descPrice"
                        value="desc-price"
                        {{ request()->recommended == 'desc-price' ? 'checked' : '' }}
                     >
                     <label class="form-check-label" for="descPrice">Price High-Low</label>
                  </div>                      
               </div>
               <button class="apply-btn">Apply</button>
            </div>
         </div>
      </div>      
   </div>
</form>