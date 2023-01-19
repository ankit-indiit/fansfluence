@extends('admin.layout.master')
@section('content')
<div class="page-wrapper">
   <div class="content container-fluid">
      <div class="row">
         <div class="col-md-12">
            <div class="card">
               <div class="card-header d-flex justify-content-between align-items-center">
                  <h4 class="card-title">Pages Detail</h4>
                  <a href="{{ route('page.index') }}" class="btn btn-default btnwhite">Back</a>
               </div>
            </div>
            <h4>{{ $page->title }}</h4>
            <p>{!! $page->content !!}</p>
         </div>
      </div>
   </div>
</div>
@endsection
@section('customScript')
<script type="text/javascript">
   
</script>
@endsection