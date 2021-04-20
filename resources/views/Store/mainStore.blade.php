
@extends('layout.nativeBase')


@section('title')
    <title>{{ trans('lang.DashboardViewTitle') }}</title>
@endsection


@section('style')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection


@section("content")
<div class='wrapper'>
   @if ($StoreType === "restaurant")
   @include('includes.resturantNav')
  @else
   @include('includes.sideNav')   
  @endif
   
  <div class='StoreContent'>
   @include('includes.navbar')
   @include("includes.error")
    
   <style>
  .DashboardPanel{
    min-height: 110px;
    padding: 10px;
    border-radius: 0px;
    background: white;
    border-bottom: 2px;
    border-bottom-style: solid;
    margin-top:12px;
    margin-bottom:12px;
}
.DashboardPanel h5{
  font-size: 38px;
    font-weight: bold;
}
.DashboardPanel p{
    color:gray;
    font-weight: bold;
}


   </style>
 
    
     <div class=" Dashboard2">


      <div class="col-sm-4 col-md-4 col-xs-12">
        <div class="DashboardPanel" style="border-bottom-color: #6fcaff;box-shadow: 0 10px 10px -2px rgba(111, 202, 255, 0.22);">
        <p>Orders Today</p>
        <h5><span class="col-sm-offset-1 glyphicon  glyphicon-shopping-cart"></span>  {{$OrdersCount}}</h5>
        </div>
      </div>
      <div class="col-sm-4 col-md-4 col-xs-12">
        <div class="DashboardPanel" style='border-bottom-color: red;box-shadow: 0 10px 10px -2px rgba(255, 0, 0, 0.22);'>
          <p>Total Products</p>
         <h5><span class="col-sm-offset-1 glyphicon glyphicon-apple"></span>  {{$ProdCount}}</h5>
        </div>
      </div>
      <div class="col-sm-4 col-md-4 col-xs-12">
        <div class="DashboardPanel" style="border-bottom-color: #94ff71;box-shadow: 0 10px 10px -2px rgba(148, 255, 113, 0.22);">
          <p>Total Income</p>
          <h5><span class="col-sm-offset-1 glyphicon 	glyphicon glyphicon-usd"></span>  {{$DayIncome}}</h5>
        </div>
       </div>
        <div class="col-sm-12 col-md-12 col-xs-12">
         <div class="panel">
        <div class="panel-body">
          <p>Orders This Month</p>
        <canvas id="DayAreaChart" width= "695px"  height="380" class="chartjs-render-monitor" style="display: block; width:100%;  height:100%;"></canvas>
        </div>
        </div>
       </div>
       <div class="col-sm-8 col-md-8 col-xs-12">
        <div class="panel">
        <div class="panel-body">
          <p>Orders This Year</p>
        <canvas id="monthAreaChart" width= "695px"  height="380" class="chartjs-render-monitor" style="display: block; width:100%;  height:100%;"></canvas>
        </div>
        </div>
       </div>
       <div class="col-sm-4 col-md-4 col-xs-12">
        <div class="panel">
         <div class="panel-body">
           <p>Payment Ways Usage</p>
         <canvas id="myPieChart" width="315px";  height="390" class="chartjs-render-monitor" style="display: block; width:100%; height:100%;"></canvas>
         </div>
        </div>
     </div>
    </div>





</div>
@endsection

@section('script')
  



<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>

<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});






$.post({
  url:"{{ route("StoreMainPost",['StoreType'=>$StoreType,'StoreId'=>$StoreId]) }}",
  data:{ _token: '{{ csrf_token() }}'}
}).done(function(resp,textStatus){

console.log(resp)

// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';

// Area Chart Example
var ctx = document.getElementById("monthAreaChart");
var myLineChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: resp.AreaChart.months,
    datasets: [{
      label: "Orders",
      lineTension: 0.3,
      backgroundColor: "rgba(2,117,216,0.2)",
      borderColor: "rgba(2,117,216,1)",
      pointRadius: 5,
      pointBackgroundColor: "rgba(2,117,216,1)",
      pointBorderColor: "rgba(255,255,255,0.8)",
      pointHoverRadius: 5,
      pointHoverBackgroundColor: "rgba(2,117,216,1)",
      pointHitRadius: 50,
      pointBorderWidth: 2,
      data:resp.AreaChart.Orders,
    }],
  },
  options: {
    scales: {
      xAxes: [{
        time: {
          unit: 'date'
        },
        gridLines: {
          display: false
        },
        ticks: {
          maxTicksLimit: 8
        }
      }],
      yAxes: [{
        ticks: {
          min: 0,
          max: resp.AreaChart.MaxOrders,
          maxTicksLimit: 8
        },
        gridLines: {
          color: "rgba(0, 0, 0, .125)",
        }
      }],
    },
    legend: {
      display: false
    }
  }
});


// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';

// Pie Chart Example
var ctx = document.getElementById("myPieChart");
var myPieChart = new Chart(ctx, {
  type: 'pie',
  data: {
    labels: ["Cash", "Credit Card", "Cash On Delivery"],
    datasets: [{
      data:resp.PaeChart.PaymentWay,
      backgroundColor: ['#0cc300','#007bff','#ffc107'],
    }],
  },
});


// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';

// Area Chart Example
var ctx = document.getElementById("DayAreaChart");
var myLineChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: resp.DayChart.Days,
    datasets: [{
      label: "Orders",
      lineTension: 0.3,
      backgroundColor: "rgba(2,117,216,0.2)",
      borderColor: "rgba(2,117,216,1)",
      pointRadius: 5,
      pointBackgroundColor: "rgba(2,117,216,1)",
      pointBorderColor: "rgba(255,255,255,0.8)",
      pointHoverRadius: 5,
      pointHoverBackgroundColor: "rgba(2,117,216,1)",
      pointHitRadius: 50,
      pointBorderWidth: 2,
      data:resp.DayChart.Orders,
    }],
  },
  options: {
    scales: {
      xAxes: [{
        time: {
          unit: 'date'
        },
        gridLines: {
          display: false
        },
        ticks: {
          maxTicksLimit: 8
        }
      }],
      yAxes: [{
        ticks: {
          min: 0,
          max: resp.DayChart.MaxOrders,
          maxTicksLimit: 8
        },
        gridLines: {
          color: "rgba(0, 0, 0, .125)",
        }
      }],
    },
    legend: {
      display: false
    }
  }
});
})






</script>
@endsection

