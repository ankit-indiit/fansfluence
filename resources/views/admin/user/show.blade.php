@extends('admin.layout.master')
@section('content')
<style type="text/css">
   
</style>
<div class="page-wrapper">
   <div class="content container-fluid">
      <div class="row">
         <div class="col-md-12">
            <div class="card card-table">
               <div class="card-header d-flex justify-content-between align-items-center">
                  <h4 class="card-title">User Detail</h4>
                  <a href="{{ route('user.index') }}" class="btn btn-default btnwhite">Back</a>
               </div>
               
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@section('customScript')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
{{-- <script src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.bundle.min.js'></script> --}}
<script>
   var xValues = ["Italy", "France", "Spain", "USA", "Argentina"];
   var yValues = [55, 49, 44, 24, 15];
   var barColors = ["red", "green","blue","orange","brown"];

   new Chart("myChart", {
     type: "bar",
     data: {
       labels: xValues,
       datasets: [{
         backgroundColor: barColors,
         data: yValues
       }]
     },
     options: {
       legend: {display: false},
       title: {
         display: true,
         text: ""
       }
     }
   });
</script>
@endsection