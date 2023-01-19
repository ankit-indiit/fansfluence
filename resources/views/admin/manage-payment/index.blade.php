@extends('admin.layout.master')
@section('content')
<div class="page-wrapper">
   <div class="content container-fluid">
      <div class="row">
         <div class="col-md-12">
            <div class="card">
               <div class="card-header d-flex justify-content-between align-items-center">
                  <h4 class="card-title">All Payments</h4>
               </div>
            </div>
            <form action="" method="get">
               <div class="row">
                  <div class="col-md-4">
                     <input type="date" class="form-control" name="start_date" value="{{ @request()->start_date }}">
                  </div>
                  <div class="col-md-4">
                     <input type="date" class="form-control" name="end_date" value="{{ @request()->end_date }}">
                  </div>
                  <div class="col-md-4">
                     <button type="submit" class="btn-primary btn-sm search w-50 mb-4">Search</button>
                  </div>               
               </div>
            </form>
            {!! $dataTable->table() !!}
         </div>
      </div>
   </div>
</div>
@endsection
@section('customScript')
{!! $dataTable->scripts() !!}
<script type="text/javascript">
   
</script>
@endsection