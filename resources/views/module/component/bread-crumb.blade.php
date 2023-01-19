@unless($breadcrumbs->isEmpty())
   <section class="breadcrumb-section pt-5">
      <div class="container">
         <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
               <li class="breadcrumb-item">
                  <a href="{{ route('home') }}">Home</a>
               </li>
               @foreach($breadcrumbs as $breadcrumb)
                  @if(!is_null($breadcrumb->url) && !$loop->last)
                     <li class="breadcrumb-item">
                        <a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a>
                     </li>
                  @else
                     <li class="breadcrumb-item active" aria-current="page">
                        {{ $breadcrumb->title }}
                     </li>
                  @endif
               @endforeach
            </ol>
         </nav>
      </div>
   </section>
@endunless
