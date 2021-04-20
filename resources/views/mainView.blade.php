@extends("layout.nativeBase")


@section('style')
<link rel="stylesheet" href="{{url("inc/css/planStyling.css")}}">
<link rel="stylesheet" href="{{url("inc/my-icons-collection/font/flaticon.css")}}">
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

@endsection

@section("content")
<nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>                        
        </button>

      </div>
      <div class="collapse navbar-collapse" id="myNavbar">
        @if( str_replace('_','-',app()->getLocale()) == 'ar' )
         <ul class="nav navbar-nav navbar-left">
        @else
         <ul class="nav navbar-nav navbar-right">
        @endif
            <li><a href="users/SignIn"><span class="glyphicon glyphicon-log-in"></span> {{ trans("lang.signIn") }}</a></li>
            <li class='active'><a href="users/SignUp"><span class="glyphicon glyphicon-user"></span> {{ trans("lang.signUp") }}</a></li>
            @if( str_replace('_','-',app()->getLocale()) == 'ar' )
             <li><a href="/en">EN</a></li>
            @else
            <li><a href="/ar">العربية</a></li>
           @endif
        </ul>
      </div>
    </div>
  </nav>



<div class="container-fluid">

@include('includes.error')

 <div class="col-sm-12 col-xs-12 col-md-12 " data-aos="fade-up">
   <img class='img-responsive' src="{{ url("inc/images/responsive.jpg")}}" >
 </div>
</div>
  <br>
  <br>
 <div class="container-fluid" style='background-color:white;padding:30px 0px 30px 0px' data-aos="fade-up">
  <div class="col-sm-3">
    <span class="flaticon-pay" style='display: block;padding: 0 30%;' ></span> 
    <h4 class='text-center' style='font-weight:bolder'>{{ trans('lang.ProcCCTitle') }}</h4>
    <h4 style="text-align:center;">{{ trans('lang.ProcCCDesc') }}</h4>
  </div>
  <div class="col-sm-3">
    <span class="flaticon-research" style='display: block;padding: 0 30%;' ></span> 
    <h4 class='text-center' style='font-weight:bolder'>{{ trans('lang.RealTimeRTitle') }}</h4>
    <h4 style="text-align:center;">{{ trans('lang.RealTimeRDesc') }}</h4>
  </div>
  <div class="col-sm-3">
    <span class="flaticon-tablet" style='display: block;padding: 0 30%;'></span> 
    <h4 class='text-center' style='font-weight:bolder'>{{ trans('lang.ResponsiveTitle') }}</h4>
    <h4 style="text-align:center;">{{ trans('lang.ResponsiveDesc') }}</h4>
  </div>
  <div class="col-sm-3">
    <span class="flaticon-store" style='display: block;padding: 0 30%;'></span>
    <h4 class='text-center' style='font-weight:bolder'>{{ trans('lang.MultiStoreTitle') }}</h4> 
    <h4 style="text-align:center;">{{ trans('lang.MultiStoreDesc') }}</h4>
  </div>
 </div>
 <br>
 <br>
 <div class="TextCenter" data-aos="fade-up">
  <h4 class="text-center" style='font-weight:bold'>{{ trans('lang.ExamplesTitle') }}</h4>
 </div>
 <div class="contaner">
     <div class="col-xs-6 col-sm-3 col-md-3" data-aos="fade-up">
        <div class="panel">
            <div class="panel-body">
                <span class="flaticon-eat" style='display: block;padding: 0 20%; '></span> 
                <h4 class='text-center'>{{ trans('lang.Restaurant') }}</h4>
            </div>
        </div>
    </div>
    <div class="col-xs-6 col-sm-3 col-md-3" data-aos="fade-up">
        <div class="panel">
            <div class="panel-body">
                <span class="flaticon-coffee-cup" style='display: block;padding: 0 20%; '></span> 
                <h4 class='text-center'>{{ trans('lang.CoffeShop') }}</h4>
            </div>
        </div>
    </div>
    <div class="col-xs-6 col-sm-3 col-md-3" data-aos="fade-up">
        <div class="panel">
            <div class="panel-body">
                <span class="flaticon-pharmacy" style='display: block;padding: 0 20%; '></span> 
                <h4 class='text-center'>{{ trans('lang.Pharmacy') }}</h4>
            </div>
        </div>
    </div>
    <div class="col-xs-6 col-sm-3 col-md-3" data-aos="fade-up">
        <div class="panel">
            <div class="panel-body">
                <span class="flaticon-gift" style='display: block;padding: 0 20%; '></span> 
                <h4 class='text-center'>{{ trans('lang.GiftShop') }}</h4>
            </div>
        </div>
    </div>
    <div class="col-xs-6 col-sm-3 col-md-3" data-aos="fade-up">
        <div class="panel">
            <div class="panel-body">
                <span class="flaticon-book-shop" style='display: block;padding: 0 20%; '></span> 
                <h4 class='text-center'>{{ trans('lang.BookShop') }}</h4>
            </div>
        </div>
    </div>
    <div class="col-xs-6 col-sm-3 col-md-3" data-aos="fade-up">
        <div class="panel">
            <div class="panel-body">
                <span class="flaticon-tshirt" style='display: block;padding: 0 20%; '></span> 
                <h4 class='text-center'>{{ trans('lang.ClothesShop') }}</h4>
            </div>
        </div>
    </div>
    <div class="col-xs-6 col-sm-3 col-md-3" data-aos="fade-up">
        <div class="panel">
            <div class="panel-body">
                <span class="flaticon-responsive" style='display: block;padding: 0 20%; '></span> 
                <h4 class='text-center'>{{ trans('lang.ElecetronicsShop') }}</h4>
            </div>
        </div>
    </div>
    <div class="col-xs-6 col-sm-3 col-md-3" data-aos="fade-up">
        <div class="panel">
            <div class="panel-body">
               <span class="glyphicon glyphicon-option-horizontal" style='font-size:115px; color: #286090;display: block;padding: 25px 20%; '></span> 
                <h4 class='text-center'>{{ trans('lang.More') }}</h4>
            </div>
        </div>
    </div>
 </div>
  
 

<div class="container-fluid" data-aos="fade-up">
 <div class="TextCenter">
  <h4 style='font-weight:bolder;' class="text-center">{{ trans('lang.PlansTitle') }}</h4>
 </div>

<div id="price">
    <!--price tab-->
    <div class="plan" data-aos="fade-up">
      <div class="plan-inner">
        <div class="entry-title">
          <h3>{{ trans("lang.PlanName1") }}</h3>
          <div class="price">$30
          </div>
        </div>
        <div class="entry-content">
          <ul>
            <li><strong>  1 x</strong>{{ trans("lang.StoresNum")}}</li>
            <li><strong> 24 x </strong>{{ trans("lang.ProductsNum") }}</li>
            <li><strong> 12 x </strong>{{ trans("lang.CatigoryNum")}}</li>
            <li><strong> 4 x </strong> {{ trans("lang.EmployeeNum") }}</li>
            <li><strong> 2 x </strong>{{ trans("lang.ReposNum") }}</li>
            <li><strong> 30 </strong> {{ trans("lang.Days") }} </li>
          </ul>
        </div>
        <div class="planFooter">
         <a href="users/SignUp" style='background-color:#53cfe9;border-color:#20bada' class='btn btn-primary'>{{ trans('lang.Subscribe') }}</a>
        </div>
      </div>
    </div>
    <!-- end of price tab-->
    <!--price tab-->
    <div class="plan basic" data-aos="fade-up">
      <div class="plan-inner">
        <div class="entry-title">
          <h3>{{ trans("lang.PlanName2") }}</h3>
          <div class="price">$60
          </div>
        </div>
        <div class="entry-content">
          <ul>
            <li><strong>  2 x</strong>{{ trans("lang.StoresNum")}}</li>
            <li><strong> 36 x </strong>{{ trans("lang.ProductsNum") }}</li>
            <li><strong> 12 x </strong>{{ trans("lang.CatigoryNum")}}</li>
            <li><strong>  8 x </strong> {{ trans("lang.EmployeeNum") }}</li>
            <li><strong>  4 x </strong>{{ trans("lang.ReposNum") }}</li>
            <li><strong> 90 </strong> {{ trans("lang.Days") }} </li>
          </ul>
        </div>
        <div class="planFooter">
            <a href="users/SignUp" style='background-color:#75ddd9;border-color:#44cbc6' class='btn btn-primary'>{{ trans('lang.Subscribe') }}</a>
        </div>
      </div>
    </div>
    <!-- end of price tab-->
    <!--price tab-->
    <div class="plan standard" data-aos="fade-up">
      <div class="plan-inner">
        <div class="entry-title">
          <h3>{{ trans("lang.PlanName3") }}</h3>
          <div class="price">$120
          </div>
        </div>
        <div class="entry-content">
          <ul>
            <li><strong>  3 x</strong>{{ trans("lang.StoresNum")}}</li>
            <li><strong> 72 x </strong>{{ trans("lang.ProductsNum") }}</li>
            <li><strong> 24 x </strong>{{ trans("lang.CatigoryNum")}}</li>
            <li><strong> 16 x </strong> {{ trans("lang.EmployeeNum") }}</li>
            <li><strong>  6 x </strong>{{ trans("lang.ReposNum") }}</li>
            <li><strong> 270 </strong> {{ trans("lang.Days") }} </li>
          </ul>
        </div>
        <div class="planFooter">
            <a href="users/SignUp" style='background-color:#4484c1;border-color:#3772aa' class='btn btn-primary'>{{ trans('lang.Subscribe') }}</a>
        </div>
    
    
         
     
      </div>
    </div>
    <!-- end of price tab-->
    <!--price tab-->
    <div class="plan ultimite" data-aos="fade-up">
      <div class="plan-inner">
        <div class="entry-title">
          <h3>{{ trans("lang.PlanName4") }}</h3>
          <div class="price">$250
          </div>
        </div>
        <div class="entry-content">
          <ul>
            <li><strong>  4 x</strong>{{ trans("lang.StoresNum")}}</li>
            <li><strong> 150 x </strong>{{ trans("lang.ProductsNum") }}</li>
            <li><strong> 50 x </strong>{{ trans("lang.CatigoryNum")}}</li>
            <li><strong> 35 x </strong> {{ trans("lang.EmployeeNum") }}</li>
            <li><strong> 10 x </strong>{{ trans("lang.ReposNum") }}</li>
            <li><strong> 365 </strong> {{ trans("lang.Days") }} </li>
          </ul>
        </div>
        <div class="planFooter">
            <a href="users/SignUp" style='background-color:#f75c70;border-color:#DD4B5E' class='btn btn-primary'>{{ trans('lang.Subscribe') }}</a>
        </div>
      </div>
    </div>
    <!-- end of price tab-->
    </div>
  </div>
<br>
<br>
<div class="Footer"  >
  <h5> Copyright at 2020 Store Manage </h5>
</div>




@endsection


@section('script')
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init()
    </script>
@endsection
