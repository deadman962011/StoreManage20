@extends('layout.nativeBase')


@section('title')
    <title>{{ trans('lang.PlanViewTitle') }}</title>
@endsection 

@section('style')
 <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ url("inc/css/planStyling.css") }}">

    

    <style>
     
.test{
  width: 100%;
  height:100%;
}

.planFooter label input[type=radio] { 
  position: absolute;
  opacity: 0;
  width: 0;
  height: 0;

}

.planFooter label input[type=radio]  { 
  cursor: pointer;
}

.planFooter input[type=radio]:checked + .test  {
  outline: 2px solid #f00;

}
    </style>

@endsection

@section('content')
<!-- MultiStep Form -->

<div class="col-sm-12 col-xs-12 col-md-12">
    <form id="msform" class='form-horizontal' method="post">
     <!-- progressbar -->
        <ul id="progressbar">
            <li  class='active' style='width:50%'>{{ trans("lang.PlanViewTitle")}}</li>
            <li style='width:50%'>{{ trans("lang.PayFormPayWay")}}</li>
        </ul>
        <!-- fieldsets -->
        <fieldset>

                

         
<div id="price">
<!--price tab-->
<div class="plan">
  <div class="plan-inner">
    <div class="entry-title">
      <h3>{{ trans('lang.PlanName1') }}</h3>
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
     <label  style='background-color:#53CFE9;border-color:#20bada;' class='btn btn-primary' id='PlanBut1'> 
       <input value='1' type="radio" name="PlanType" >
       <div class="test"></div> {{ trans("lang.Subscribe") }}
     </label>
    </div>
  </div>
</div>
<!-- end of price tab-->
<!--price tab-->
<div class="plan basic">
  <div class="plan-inner">
    <div class="entry-title">
      <h3>{{ trans('lang.PlanName2') }}</h3>
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
   
        <label style='background-color:#75DDD9;border-color:#44CBC6;' class='btn btn-primary' id='PlanBut2'> 
          <input value='2' type="radio" name="PlanType" >
          <div class="test"></div> {{ trans('lang.Subscribe') }}
        </label>
     
    </div>
  </div>
</div>
<!-- end of price tab-->
<!--price tab-->
<div class="plan standard">
  <div class="plan-inner">
    <div class="entry-title">
      <h3>{{ trans('lang.PlanName3') }}</h3>
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
      <label style='background-color:#4484c1;border-color:#3772aa;' class='btn btn-primary' id='PlanBut3'> 
        <input value='3' type="radio" name="PlanType" >
        <div class="test"></div> {{ trans('lang.Subscribe') }}
      </label>
    </div>


     
 
  </div>
</div>
<!-- end of price tab-->
<!--price tab-->
<div class="plan ultimite">
  <div class="plan-inner">
    <div class="entry-title">
      <h3>{{ trans('lang.PlanName4') }}</h3>
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
      <label style='background-color:#F75C70;border-color:#DD4B5E;' class='btn btn-primary' id='PlanBut'> 
        <input value='4' type="radio" name="PlanType" >
        <div class="test"></div> {{ trans('lang.Subscribe') }}
      </label>
    </div>
  </div>
</div> 
</div>

<!-- end of price tab-->
            <input type="button" name="next" class="next action-button btn btn-primary" value="{{ trans("lang.Next")}}"/> 
        </fieldset>
        <fieldset>

            <h2 class="fs-title">{{ trans('lang.PayFormPayWay') }}</h2>
            
             <div class="btn-group">
              <label class="btn btn-default"><input type="radio" name="PayWayI"  data-toggle="collapse" data-target="#PayWayPayPal">{{ trans("lang.PayPayPal") }}</label>
              <label class="btn btn-default"><input type="radio" name="PayWayI"  data-toggle="collapse" data-target="#PayWayCC">{{ trans('lang.PayFormCCSubmit') }}</label>
            </div>
            <br>
            <br>
          

          <div id="PayWayPayPal" class="collapse">
           <div class="links">
              <div id="paypal-button"></div>
           </div>            
          </div>

          <div id="PayWayCC" class="collapse"> 
                         <!-- CREDIT CARD FORM STARTS HERE -->
                         <div class="form-group">
                          <div class="col-sm-3"><label for="cardNumber">{{ trans('lang.PayFormCN') }}</label></div>
                          <div class="col-sm-5"><input type="tel" class="form-control" name="cardNumber" placeholder="{{ trans('lang.PayFormCN') }}" autocomplete="cc-number" required autofocus /></div>
                        </div>                                            
                        <div class="form-group">
                         <div class='col-sm-3'><label for="cardExpiry"><span class="hidden-xs">{{ trans('lang.PayFormExp') }}</span><span class="visible-xs-inline"></span></label> </div>
                         <div class='col-sm-3'><input  type="tel"   class="form-control"  name="cardExpiry" placeholder="MM / YY" autocomplete="cc-exp" required /></div>
                        </div>
                        <div class="form-group">
                          <div class="col-sm-3"><label for="cardCVC">{{ trans("lang.PayFormCVC") }}</label></div>
                          <div class='col-sm-4' > <input type="tel" class="form-control"name="cardCVC"placeholder="{{ trans("lang.PayFormCVC") }}"autocomplete="cc-csc"required /> </div>
                        </div>
               
                <div class="row" style="display:none;">
                    <div class="col-xs-12">
                        <p class="payment-errors"></p>
                    </div>
                </div>
                <button class="subscribe btn btn-primary" type="button">Submit</button>
          </div>
  
    <!-- CREDIT CARD FORM ENDS HERE -->
         
      <br>
      <br>
          <input type="button" name="previous" class="previous btn btn-danger" value="{{ trans('lang.Previous')}}"/>
      </fieldset>
      {{csrf_field()}}
  </form>
</div>


@endsection


@section('script')

<script>
      
$(".collapse").on("show.bs.collapse",function(){
$(".collapse.in").each(function(){
  $(this).collapse("hide");
})
})
</script>


<script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
  <script src="{{ url("inc/js/multiStepForm.js") }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
<script src="https://js.stripe.com/v2/"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.payment/1.2.3/jquery.payment.min.js"></script>
<script src="https://www.paypalobjects.com/api/checkout.js"></script>




@include('includes.localJs')
 




@endsection

