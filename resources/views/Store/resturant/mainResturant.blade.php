@extends('layout.nativeBase')


@section('title')
    <title>{{ trans('lang.DashboardViewTitle') }}</title>
@endsection

@section("content")
<div class='wrapper'>
@include('includes.resturantNav')
   
  <div class='StoreContent'>
   @include('includes.navbar')
    
   <style>
  .DashboardPanel{
    min-height: 110px;
    padding: 10px;
    border-radius: 0px;
    background: white;
    border-bottom: 2px;
    border-bottom-style: solid;
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
 
    
     <div class="row Dashboard2">
      <div class="col-sm-4 ">
        <div class="DashboardPanel" style="border-bottom-color: #6fcaff;box-shadow: 0 10px 10px -2px rgba(111, 202, 255, 0.22);">
        <p>Orders Today</p>
        <h5><span class="col-sm-offset-1 glyphicon  glyphicon-shopping-cart"></span>  300</h5>
        </div>
      </div>
      <div class="col-sm-4 ">
        <div class="DashboardPanel" style='border-bottom-color: red;box-shadow: 0 10px 10px -2px rgba(255, 0, 0, 0.22);'>
          <p>Total Products</p>
         <h5><span class="col-sm-offset-1 glyphicon glyphicon-apple"></span>  1400</h5>
        </div>
      </div>
      <div class="col-sm-4 ">
        <div class="DashboardPanel" style="border-bottom-color: #94ff71;box-shadow: 0 10px 10px -2px rgba(148, 255, 113, 0.22);">
          <p>Total Income</p>
          <h5><span class="col-sm-offset-1 glyphicon 	glyphicon glyphicon-usd"></span>  45300</h5>
        </div>
      </div>
      

    </div>
     </div>



</div>
@endsection

@section('script')
@include('includes.localJs')   
@endsection

