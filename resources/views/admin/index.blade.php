@extends('admin.layout.master')
@section('content')
	<div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-12">
                        <h3 class="page-title">Welcome Admin!</h3>
                    </div>
                </div>
            </div>
            <div class="row">                
                <div class="col-xl-3 col-sm-6 col-12">                    
                    <div class="card">
                        <a href="{{ route('user.index') }}">
                            <div class="card-body">
                                <div class="dash-widget-header">
                                    <span class="dash-widget-icon bg-primary">
                                       <i class="fas fa-users"></i>
                                    </span>                                    
                                    <div class="dash-widget-info">
                                        <div class="text-dark text-center font-weight-bold">
                                            <span class="py-4">Users</span><br>
                                            <h4 class="text-dark font-weight-bold">{{ @$users }}</h4>
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                        </a>
                    </div>                        
                </div>  
                <div class="col-xl-3 col-sm-6 col-12">                    
                    <div class="card">
                        <a href="{{ route('user.index') }}">
                        <div class="card-body">
                            <div class="dash-widget-header">
                                    <span class="dash-widget-icon bg-primary">
                                       <i class="fas fa-store"></i>
                                    </span>                                    
                                <div class="dash-widget-info">
                                    <div class="text-dark text-center font-weight-bold">
                                        <span class="py-4">Sellers</span><br>
                                        <h4 class="text-dark font-weight-bold">{{ @$seller }}</h4>
                                    </div>
                                </div>                                
                            </div>                                
                        </div>
                        </a>
                    </div>                        
                </div>
                <div class="col-xl-3 col-sm-6 col-12">                    
                    <div class="card">
                        <a href="{{ route('order.index') }}">
                        <div class="card-body">
                            <div class="dash-widget-header">
                                    <span class="dash-widget-icon bg-primary">
                                       <i class="fas fa-shopping-cart"></i>
                                    </span>                                    
                                <div class="dash-widget-info">
                                    <div class="text-dark text-center font-weight-bold">
                                        <span class="py-4">Orders</span><br>
                                        <h4 class="text-dark font-weight-bold">{{ @$order }}</h4>
                                    </div>
                                </div>                                  
                            </div>                                
                        </div>
                        </a>
                    </div>                        
                </div>
                <div class="col-xl-3 col-sm-6 col-12">                    
                    <div class="card">
                        <a href="{{ route('order.index') }}">
                        <div class="card-body">
                            <div class="dash-widget-header">
                                    <span class="dash-widget-icon bg-primary">
                                       <i class="fas fa-users"></i>
                                    </span>                                    
                                <div class="dash-widget-info">
                                    <div class="text-dark text-center font-weight-bold">
                                        <span class="py-4">Revenue</span><br>
                                        <h4 class="text-dark font-weight-bold">{{ @$revenue }}</h4>
                                    </div>
                                </div>                                
                            </div>                                
                        </div>
                        </a>
                    </div>                        
                </div>
                <div class="col-md-12">
                    <div class="card cardSection">
                        <div class="d-flex justify-content-between p-3">
                            <h5>Recent Orders</h5>
                            <a href="{{ route('order.index') }}">View all</a>
                        </div>
                        <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Sr. no.</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>User</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recentOrders as $order)                                    
                                    <tr>
                                      <td>{{ $loop->iteration }}</td>
                                      <td>{{ $order->product }} {{ $order->mark }}</td>
                                      <td>
                                        @switch($order->status)
                                            @case ('pending')
                                                <span class="badge badge-primary">{{ ucfirst($order->status) }}</span>
                                            @break;
                                            @case ('accept')
                                                <span class="badge badge-secondary">{{ ucfirst($order->status) }}</span>
                                            @break;
                                            @case ('decline')
                                                <span class="badge badge-danger">{{ ucfirst($order->status) }}</span>
                                            @break;
                                            @case ('completed')
                                                <span class="badge badge-success">{{ ucfirst($order->status) }}</span>
                                            @break;  
                                            @case ('delivered')
                                                <span class="badge badge-info">{{ ucfirst($order->status) }}</span>
                                            break;     
                                        @endswitch                                        
                                        </td>
                                      <td>{{ getUserNameById($order->user_id) }}</td>   
                                      <td>{{ $order->created_at }}</td>                                  
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>  
                        </div>                      
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card cardSection">
                        <div class="d-flex justify-content-between p-3">
                            <h5>Recent Buyer</h5>
                            <a href="{{ route('user.index') }}">View all</a>
                        </div>
                        <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Sr. no.</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recentBuyers as $buyer)
                                    <tr>
                                      <td>{{ $loop->iteration }}</td>
                                      <td>{{ $buyer->name }}</td>
                                      <td>{{ $buyer->email }}</td>
                                      <td>{{ $buyer->created_at }}</td>                                  
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>       
                        </div>                 
                    </div>
                </div>            
                <div class="col-md-6">
                    <div class="card cardSection">
                        <div class="d-flex justify-content-between p-3">
                            <h5>Recent Seller</h5>
                            <a href="{{ route('user.index') }}">View all</a>
                        </div>
                        <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Sr. no.</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recentSellers as $seller)
                                    <tr>
                                      <td>{{ $loop->iteration }}</td>
                                      <td>{{ $seller->name }}</td>
                                      <td>{{ $seller->email }}</td>
                                      <td>{{ $seller->created_at }}</td>                                  
                                    </tr>
                                @endforeach
                            </tbody>
                        </table> 
                        </div>                       
                    </div>
                </div>            
            </div>                     
        </div>
    </div>
@endsection
@section('customScript')
<script src="https://unpkg.com/apexcharts@3.31.0/dist/apexcharts.min.js') }}"></script>
<script>
  /* Sales Revenue */
  var options = {
     series: [{
        name: "SALES",
        data: [10, 41, 35, 51, 49, 62, 69, 91, 148],
         colors:'#0E48B4'
     }],
     chart: {
        height: 400,
        type: 'line',
        zoom: {
           enabled: false
        }
     },
     dataLabels: {
        enabled: false
     },
     stroke: {
        curve: 'straight',
        colors:'#0E48B4'
     },
     grid: {
        row: {
           colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
           opacity: 0.5
        },
     },
     xaxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
     }
  };
  var chart = new ApexCharts(document.querySelector("#sales"), options);
  chart.render();

  /* Product Services */
  var options = {
      series: [{
      name: 'Product',
      data: [44, 55, 57, 56, 61, 58, 63, 60, 66]
    }, {
      name: 'Services',
      data: [76, 85, 101, 98, 87, 105, 91, 114, 94]
    }, 
    ],
      chart: {
      type: 'bar',
      height: 350
    },
    plotOptions: {
      bar: {
        horizontal: false,
        columnWidth: '55%',
        endingShape: 'rounded'
      },
    },
    dataLabels: {
      enabled: false
    },
    stroke: {
      show: true,
      width: 2,
      colors: ['transparent']
    },
    xaxis: {
      categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],

    },
    yaxis: {
      title: {
        text: 'Product/Services'
      }
    },
    fill: {
      opacity: 1
    },
    tooltip: {
      y: {
        formatter: function (val) {
          return "$ " + val + " Sales"
        }
      }
    }
    };

    var chart = new ApexCharts(document.querySelector("#productservices"), options);
    chart.render();
</script>
@endsection