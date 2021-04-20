@extends('layout.nativeBase')


@section('title')
    <title>{{ trans('lang.PosViewTitle') }}</title>
@endsection



@section('style')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection


@section("content")

<div class="container">
    <div class="row">
      <div class="Btns"> 
        <a href='{{ route("StoreMain",['StoreType'=>$StoreType,'StoreId'=>$StoreId])}}' class="btn btn-default btn-lg">{{ trans('lang.DashboardViewTitle') }}</a>
        <a href='{{ route("Delivery",['StoreType'=>$StoreType,'StoreId'=>$StoreId])}}' class="btn btn-default btn-lg">{{ trans('lang.SideNavDelivery') }}</a>
        <a href='{{ route("Products",['StoreType'=>$StoreType,'StoreId'=>$StoreId])}}' class="btn btn-default btn-lg">{{ trans('lang.SideNavProds') }}</a>
        <a href='{{ route("Catigories",['StoreType'=>$StoreType,'StoreId'=>$StoreId])}}' class="btn btn-default btn-lg">{{ trans('lang.SideNavCats') }}</a>
        
        <button data-toggle="modal" data-target="#WaitingPay" class="btn btn-default btn-lg">{{ trans('lang.WatingPaymentBut') }}</button>
      </div>
      @if (!empty(session('err')))
      @if (session('err')['err'] == "0")
      <div id='StoreAlert' class="alert alert-success col-sm-6 col-sm-offset-3">
      <strong>{{ trans("lang.".session('err')['message'])  }}  <a href="{{ route("PrintOrder",["StoreType"=>$StoreType,"StoreId"=>$StoreId,"OrderId"=>session('err')['OrderId']]) }}">Click Here To Print Bill</a> </strong>
      </div>
      @endif
      @if (session('err')['err'] == "1")
      <div id='StoreAlert' class="alert alert-danger col-sm-6 col-sm-offset-3" >
      <strong>{{ trans("lang.".session('err')['message'])  }}</strong>
      </div>
      @endif      
      @endif
        <div class="col-sm-6">
          <div class="Dashboard PosPanel" style='overflow-y: auto;'>
            <div class="btn-group btn-group-justified " style="margin: 8px;width:auto;">
                <div class="btn-group"><button data-toggle="modal" data-target="#PayModal"  class="btn btn-default btn-md"><span class="glyphicon glyphicon-usd"></span>{{ trans('lang.PospayBut') }}</button></div>
                <div class="btn-group"><button data-toggle="modal" data-target="#HoldModal"  class="btn btn-default btn-md"><span class="glyphicon glyphicon-hourglass"></span>{{ trans('lang.PosWaitingBut') }}</button></div>
                <div class="btn-group"><button data-toggle="modal" data-target="#DeliveryModal"  class="btn btn-default btn-md"><span class="glyphicon glyphicon-send"></span>{{ trans('lang.PosDelivery') }}</button></div>
                <div class="btn-group"><button id="cancelOrder"  class="btn btn-default btn-md"><span class="glyphicon glyphicon-trash"></span>{{ trans('lang.PosCancelBut') }}</button></div>
              </div>
    
             <table class="table" style="">
                 <thead>
                         <th>{{ trans('lang.billProdName') }}</th>
                         <th>{{ trans('lang.billPrice') }}</th>
                         <th>{{ trans('lang.billQuant') }}</th>
                         <th>{{ trans('lang.billTotalPrice') }}</th>
                         <th>#</th>
                 </thead>
                 <tbody  class="test">
                 </tbody>
             </table>
             <br>
        </div>
    </div>
        <div class="col-sm-6">
            <div class="Dashboard PosPanel" style='padding:10px'>
                    <div class="tabbable">
                        <ul class="nav nav-tabs">
                          <li class='active'><a href="#all" data-toggle="tab">All</a></li>
                          @foreach ($Catigories as $catigory)
                           <li><a href="#{{ $catigory['id'] }}" data-toggle="tab">{{ $catigory['CatigoryName'] }} ({{ $catigory['CatigoryProdsNum']}})</a></li>
                          @endforeach 
                        </ul>
                        <div class="tab-content itemsTab">
                         <div id="all" class="tab-pane fade in active ">
                          @foreach ($AllProduct as $Product)
                           <div class="col-sm-4" style="padding-right:4px;padding-left:4px">
                            <div class="Prod">
                             <button class='btn btn-link ProdBtn'  value='{{ $Product->id }}'>
                                <img class='img-responsive' src="/storage/products/{{ $Product->Image['PicSource'] }}" alt="">
                                <div class="ProdBody">
                                <h5>{{ $Product->ProdName }}</h5>
                                <h6>{{ $Product->ProdPrice }}</h6>
                                </div>
                             </button>
                            </div>
                           </div>
                          @endforeach
                         </div>
                         @foreach ($Catigories as $PbyC)
                          <div id="{{ $PbyC['id']}}" class="tab-pane fade ">
                            @foreach ($PbyC->products as $Prod)
                            <div class="col-sm-4 col-xs-4" style="padding-right:4px;padding-left:4px">
                                <div class="Prod">
                                <button class='btn btn-link ProdBtn'  value='{{ $Prod['id'] }}'>
                                        <img class='img-responsive' src="/storage/products/{{ $Prod->Image['PicSource'] }}" alt="">
                                        <div class="ProdBody">
                                        <h5>{{ $Prod->ProdName }}</h5>
                                        <h6>{{ $Prod->ProdPrice }}</h6>
                                        </div>
                                    </button>        
                                </div>
                               </div>
                            @endforeach
                          
                          </div>
                         @endforeach
                        </div>
                   </div>                    
            </div>
        </div>
    </div>
</div>




{{-- Pay modal --}}
 
<div class="modal fade" id="PayModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
        </div>
        <div class="modal-body">
          <form action="{{ route("AddOrder",['StoreType'=>$StoreType,'StoreId'=>$StoreId]) }}" class='form-horizontal PayForm' method="post">
            <div class="OrderTypeSet">
              <label>
                <input type="radio" name="OrderTypeI"  value='Pay' data-toggle="collapse" data-target="#PayCollapse" checked>
                <img class='img-responsive' style='width:140px' src="http://127.0.0.1/nexo/NexoPOS-3.15.11/public/modules/gastro//img/takeaway.png" > 
              </label>
              <label>
                <input type="radio" name="OrderTypeI" value='Delivery' data-toggle="collapse" data-target="#DeliveryCollapse" >
                <img class='img-responsive' style='width:140px' src="http://127.0.0.1/nexo/NexoPOS-3.15.11/public/modules/gastro//img/delivery.png" alt="">
              </label> 
            </div>
                <div id="PayCollapse" class="collapse"></div>
                <div id="DeliveryCollapse" class="collapse">
                  <div class="form-group">
                    <div class="col-sm-3"><label for="DeliveryEmpI" class="form-label"> Delivery Employee:</label></div>
                    <div class="col-sm-6"><select name="DeliveryEmpI" class="form-control">
                      @foreach ($Employee as $employee)
                       <option value="{{$employee['id']}}">{{ $employee['EmployeeName'] }}</option>                  
                      @endforeach
                    </select></div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-3"><label for="DeliveryAddressI" class="form-label"> Delivery Address:</label></div>
                    <div class="col-sm-6"><input type="text" name="DeliveryAddressI"  class="form-control"></div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-3"><label for="DeliveryPhoneI" class="form-label"> Delivery Phone:</label></div>
                    <div class="col-sm-6"><input name='DeliveryPhoneI' type="text" class="form-control"></div>
                  </div>  
                </div>
  
                {{-- Payment Form --}}
  
                <div class="form-group">
                  <div class="col-sm-3"><label for="PaymentWayI" class="form-label">Payment Way</label></div>
                  <div class="col-sm-8">
                    <div class="btn-group btn-group">
                      <label for="paymentWayI" class="btn btn-default"> <input type="radio" name='PaymentWayI' value='Cash' data-toggle="collapse" data-target="#CashCollapse" >Cash</label>
                      @if (!empty($ApiKey))
                        <label for='PaymentWayI' class="btn btn-default"> <input type="radio" name='PaymentWayI' class="PayCC" value='CreditCard' data-toggle="collapse" data-target="#CrditCardCollapse" >Credit Card</label>
                      @else
                      <label for='PaymentWayI' class="btn btn-default"> <input type="radio" name='PaymentWayI' value='CreditCard' data-toggle="collapse" data-target="#CrditCardCollapse" disabled >Credit Card</label>
                      @endif
                      
  
                      <label for='PaymentWayI' class="btn btn-default"> <input type="radio" name='PaymentWayI' value='CashOnDelivery' data-toggle="collapse" data-target="#CashOnDelivery" disabled>Cash on Delivery</label>
                    </div>
                  </div>
                </div>
  
                {{-- Payment Way Collapse --}}
                <div id="CashCollapse" class="collapse"><input type="submit" value="Cash Payment Submit " class="btn btn-success btn-block"></div>
              @if(!empty($ApiKey))
                <div id="CrditCardCollapse" class="collapse">
  
                  <div class="form-group">
                    <div class="col-sm-3"><label for="cardNumber">Card Number</label></div>
                    <div class="col-sm-5"><input type="tel" class="form-control" name="cardNumber" placeholder="Valid Card Number" autocomplete="cc-number" required autofocus /></div>
                  </div>                                            
                  <div class="form-group">
                   <div class='col-sm-3'><label for="cardExpiry"><span class="hidden-xs">Expiration</span><span class="visible-xs-inline">EXP</span> DATE</label> </div>
                   <div class='col-sm-3'><input  type="tel"   class="form-control"  name="cardExpiry" placeholder="MM / YY" autocomplete="cc-exp" required /></div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-3"><label for="cardCVC">Cvc Code</label></div>
                    <div class='col-sm-4' > <input type="tel" class="form-control"name="cardCVC"placeholder="CVC"autocomplete="cc-csc"required /> </div>
                  </div>
                  <button class="subscribe btn btn-primary btn-block" value='PayForm' type="button">Credit Card Payment Submit</button>
         
                 <div class="row" style="display:none;">
                  <div class="col-xs-12">
                  <p class="payment-errors"></p>
                 </div>
                 <!-- CREDIT CARD FORM ENDS HERE -->          
                </div>
               </div>
              @endif
                <div id="CashOnDelivery" class="collapse"><input type="submit" value="Cash On Delivery Submit" class="btn btn-success btn-block"></div>
                {{-- Payment Way Collapse End --}}
  
              <div class="modal-footer">
                {{ csrf_field() }}
                        
                  <div class="col-sm-4">
                    <select class='form-control' name="CasherId">
                      @foreach ($getCasher as $Casher)
                       <option value="{{$Casher['EmployeeName']}}">{{$Casher['EmployeeName']}}</option>        
                      @endforeach
  
                     </select>
                  </div>    
          </form>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      </div>
    </div>
  </div>

  {{-- Pay modal End --}}



<!-- Delivery Order Modal -->
  <!-- Modal -->
  <div class="modal fade" id="DeliveryModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Delivery Modal</h4>
        </div>
        <div class="modal-body">
         <form action="{{ route("ToDelivery",['StoreType'=>$StoreType,'StoreId'=>$StoreId]) }}" method="post" class="form-horizontal">
          <div class="form-group">
            <div class="col-sm-3"><label for="DeliveryEmpI" class="form-label"> Delivery Employee:</label></div>
            <div class="col-sm-6"><select name="DeliveryEmpI" class="form-control">
              @foreach ($Employee as $employee)
               <option value="{{$employee['id']}}">{{ $employee['EmployeeName'] }}</option>                  
              @endforeach
            </select></div>
          </div>
          <div class="form-group">
            <div class="col-sm-3"><label for="DeliveryAddressI" class="form-label"> Delivery Address:</label></div>
            <div class="col-sm-6"><input type="text" name="DeliveryAddressI"  class="form-control"></div>
          </div>
          <div class="form-group">
            <div class="col-sm-3"><label for="DeliveryPhoneI" class="form-label"> Delivery Phone:</label></div>
            <div class="col-sm-6"><input name='DeliveryPhoneI' type="text" class="form-control"></div>
          </div> 
          {{ csrf_field() }}
        </div>
        <div class="modal-footer">
          <div class="col-sm-4">
            <select class='form-control' name="CasherId">
              @foreach ($getCasher as $Casher)
               <option value="{{$Casher['EmployeeName']}}">{{$Casher['EmployeeName']}}</option>        
              @endforeach

             </select>
          </div>

        <input type="submit" value="Add To Delivery" class="btn btn-primary">
        </form>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>


<!--  End Delivery Order Modal -->




{{-- Hold modal --}}
 
<div class="modal fade" id="HoldModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <form action="{{ route("HoldOrder",['StoreType'=>$StoreType,'StoreId'=>$StoreId]) }}" class='form-horizontal PayForm' method="post">
            <div class="OrderTypeSet">
              <label>
                <input type="radio" name="OrderTypeI"  value='Pay' data-toggle="collapse" data-target="#PayCollapseHold" checked>
                <img class='img-responsive' style='width:140px' src="http://127.0.0.1/nexo/NexoPOS-3.15.11/public/modules/gastro//img/takeaway.png" > 
              </label>
              <label>
                <input type="radio" name="OrderTypeI" value='Delivery' data-toggle="collapse" data-target="#DeliveryCollapseHold" >
                <img class='img-responsive' style='width:140px' src="http://127.0.0.1/nexo/NexoPOS-3.15.11/public/modules/gastro//img/delivery.png" alt="">
              </label> 
            </div>
                <div id="PayCollapseHold" class="collapse"></div>
                <div id="DeliveryCollapseHold" class="collapse">
                  <div class="form-group">
                    <div class="col-sm-3"><label for="DeliveryEmpI" class="form-label"> Delivery Employee:</label></div>
                    <div class="col-sm-6"><select name="DeliveryEmpI" class="form-control">
                      @foreach ($Employee as $employee)
                       <option value="{{$employee['id']}}">{{ $employee['EmployeeName'] }}</option>                  
                      @endforeach
                    </select></div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-3"><label for="DeliveryAddressI" class="form-label"> Delivery Address:</label></div>
                    <div class="col-sm-6"><input type="text" name="DeliveryAddressI"  class="form-control"></div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-3"><label for="DeliveryPhoneI" class="form-label"> Delivery Phone:</label></div>
                    <div class="col-sm-6"><input name='DeliveryPhoneI' type="text" class="form-control"></div>
                  </div>  
                </div>
          </div>
          <div class="modal-footer">
            {{ csrf_field() }}
            <div class="col-sm-4">
              <select class='form-control' name="CasherId">
                @foreach ($getCasher as $Casher)
                 <option value="{{$Casher['EmployeeName']}}">{{$Casher['EmployeeName']}}</option>        
                @endforeach
  
               </select>
            </div>
             <input type="submit" value="Add To Waiting" class="btn btn-primary">  
             
            </form>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>

  {{-- Hold modal End --}}



{{-- Waiting For Payment Moda Start --}}

 
<div class="modal fade" id="WaitingPay" role="dialog">
  <div class="modal-dialog modal-lg">
  
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">

        <div class="OrderTabs">
        <ul>
          @foreach ($readyOrders as $order)
           <li ><a data-toggle="tab" href="#ready{{$order['id']}}">{{ $order['OrderName']}}</a></li>
          @endforeach
        </ul>
      
       <div class="tab-content OrderTabsCont">
        @if (!empty($readyOrders))

            
   
        @foreach ($readyOrders as $orderD)
            
         <div id="ready{{ $orderD['id']}}" class="tab-pane fade in ">
     
          <h3 class='text-center'>{{ trans('lang.WaitngModalTitleDetails') }}</h3>
           @if (app()->getLocale() =="en")
            <div class="OrderDetails" style='direction:rtl'> 
           @else
            <div class="OrderDetails" >
           @endif
           <h3>{{ trans('lang.WaitngModalCahsherTitle') }}    <span>{{ $orderD['OrderBy'] }}</span>   {{ trans('lang.WaitngModalLabelDate') }}  <span>{{ $orderD['created_at']}}</span>{{ trans('lang.WaitngModalLabelAmount') }}   <span>{{ $orderD['OrderPrice']}}</span></h3> 
           <h3>{{ trans('lang.WaitngModalLabelCode') }}   <span>{{ $orderD['OrderName']}}</span>   {{ trans('lang.WaitngModalLabelOrderType') }}    <span>{{$orderD['OrderType']}}</span></h3>
          @if ($orderD['OrderType'] == "Delivery")
          <h3>  {{ trans('lang.FormDeliveryPhone') }}   <span>{{$orderD['OrderInf']['DeliveryPhone']}}</span>  </h3>
          <h3> {{ trans('lang.FormDeliveryAddress') }}  <span>{{$orderD['OrderInf']['DeliveryAddress']}}</span>  </h3>
         
          @endif
          </div>
          <h3 class='text-center'>{{ trans('lang.WaitngModalTitleProd') }}</h3>
          <div class="orderProducts">
            <table class='table'>
              <thead>
                <tr>
                  <th>{{ trans('lang.billProdName') }}</th>
                  <th>{{ trans('lang.billPrice') }}</th>
                  <th>{{ trans('lang.billQuant') }}</th>
                  <th>{{ trans('lang.billTotalPrice') }}</th>
                </tr>
              </thead>

              <tbody>
                @foreach ($orderD->OrderCart->items as $item)
                <tr>
                  <td>{{$item['item']->ProdName}}</td>
                  <td>{{$item['item']->ProdPrice}}</td>
                  <td>{{$item['qty']}}</td>
                  <td>{{$item['price']}}</td>
                </tr>
                @endforeach

              </tbody>
            </table>
          </div>

           <form action="{{ route("WaitPay",["StoreType"=>$StoreType,"StoreId"=>$StoreId])}}" method="post" class="WaitingForm  form-horizontal">
            <h4 class="text-center">{{ trans('lang.PayFormPayWay') }}</h4>
                            {{-- Payment Form --}}
  
                            <div class="form-group">
                              <div class="col-sm-3"><label for="PaymentWayI" class="form-label">{{ trans('lang.PayFormPayWay') }}</label></div>
                              <div class="col-sm-8">
                                <div class="btn-group btn-group">
                                  <label for="paymentWayI" class="btn btn-default"> <input type="radio" name='PaymentWayIWait' value='Cash' data-toggle="collapse" data-target="#CashCollapseWaiting{{$orderD['id']}}" >Cash</label>
                                  @if (!empty($ApiKey))
                                    <label for='PaymentWayI' class="btn btn-default"> <input type="radio" name='PaymentWayIWait' value='CreditCard' data-toggle="collapse" data-target="#CreditCardCollapseWaiting{{$orderD['id']}}" >Credit Card</label>
                                  @else
                                  <label for='PaymentWayI' class="btn btn-default"> <input type="radio" name='PaymentWayIWait' class='WatingCC' value='CreditCard' data-toggle="collapse" data-target="#CreditCardCollapseWaiting{{$orderD['id']}}" disabled >Credit Card</label>
                                  @endif
                                  @if($orderD["OrderType"] =="Delivery")
                                    <label for='PaymentWayI' class="btn btn-default"> <input type="radio" name='PaymentWayIWait' value='CashOnDelivery' data-toggle="collapse" data-target="#CashOnDeliveryWaiting{{$orderD['id']}}">Cash on Delivery</label>
                                    @else
                                    <label for='PaymentWayI' class="btn btn-default"> <input type="radio" name='PaymentWayIWait' value='CashOnDelivery' data-toggle="collapse" data-target="#CashOnDeliveryWaiting{{$orderD['id']}}" disabled>Cash on Delivery</label>
                                  @endif                             
                                </div>
                              </div>
                            </div>
                            {{-- Payment Way Collapse --}}
                            <div id="CashCollapseWaiting{{$orderD['id']}}" class="collapse"><input type="submit" value="Cash Payment Submit " class="btn btn-success btn-block"></div>
                            <div id="CashOnDeliveryWaiting{{$orderD['id']}}" class="collapse"><input type="submit" value="Cash On Delivery Submit" class="btn btn-success btn-block"></div>
                            {{-- Payment Way Collapse End --}}
                            @if(!empty($ApiKey))
                            <div id="CreditCardCollapseWaiting{{$orderD['id']}}" class="collapse">                            
                              <div class="form-group">
                              <div class="col-sm-3"><label for="cardNumber">{{ trans('lang.PayFormCN') }}</label></div>
                              <div class="col-sm-9"><input type="tel" class="form-control" name="cardNumber" placeholder="Valid Card Number" autocomplete="cc-number" required autofocus /></div>
                            </div>
                    
                            <div class="form-group">
                              <div class='col-sm-4'><label for="cardExpiry"><span class="hidden-xs">{{ trans('lang.PayFormExp') }}</span><span class="visible-xs-inline">EXP</span> DATE</label> </div>
                              <div class='col-sm-8'><input  type="tel"   class="form-control"  name="cardExpiry" placeholder="MM / YY" autocomplete="cc-exp" required /></div>
                            </div>
                    
                            <div class="form-group">
                              <div class="col-sm-3"><label for="cardCVC">{{ trans('lang.PayFormCVC') }}</label></div>
                              <div class='col-sm-9' > <input type="tel" class="form-control"name="cardCVC"placeholder="CVC"autocomplete="cc-csc"required /> </div>
                            </div> 
                    
                            <button class="subscribe btn btn-primary btn-block" type="button">{{ trans('lang.PayFormCCSubmit') }}</button>
                    
                            <div class="row" style="display:none;">
                              <div class="col-xs-12">
                              <p class="payment-errors"></p>
                            </div>
                            <!-- CREDIT CARD FORM ENDS HERE -->          
                          </div>
                          </div>
            
                        @endif

                        @if ($orderD['OrderType'] == "DineIn")
                          <input name='TableIdWaiting' type='hidden' value='{{$orderD['OrderInf']['TableId']}}'>
                        @endif
                        <input type="hidden" name="idWaiting" value='{{ $orderD['id'] }}'>
                        <input type="hidden" name="OrderTypeIWaiting" value='{{ $orderD['OrderType']}}'>
                        {{ csrf_field()}}
                        </form>
                       </div>
                   @endforeach
                 </div>
          @endif
        </div>
      </div>
      </div>
    </div>
  </div>
</div>
{{-- Waiting For Payment Moda End --}}

@endsection
@section('script')
    

<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});




//get items 
$.get({
        url:"{{ route('getItems',['StoreType'=>$StoreType,'StoreId'=>$StoreId]) }}"
    }).done(function(data,textStatus){
         $(".test").html(data);
        
        })
        


    //save Item
$(".ProdBtn").click(function(){

    var test=$(this).val();
    $.post({
        url:"{{ route('AddItem',['StoreType'=>$StoreType,'StoreId'=>$StoreId]) }}",
        data:{id:test}
    }).done(function(data,textStatus){
        
    });

    $.get({
        url:"{{ route('getItems',['StoreType'=>$StoreType,'StoreId'=>$StoreId]) }}",
    }).done(function(data2,textStatus2){
        $(".test").html(data2);
    })
    })


//del item
$(document).on("click",".DelBtn",function(){
  
  var DelId=$(this).val();
  $.post({
      url:"{{ route('DelItem',['StoreType'=>$StoreType,'StoreId'=>$StoreId]) }}",
      data:{DelId:DelId}
  }).done(function(data,textData){
    $.get({
        url:"{{ route('getItems',['StoreType'=>$StoreType,'StoreId'=>$StoreId]) }}",
    }).done(function(data3,textStatus3){
        $(".test").html(data3);
    })
  })
})


//increase Button effect
$(document).on("click",".IncreaseBtn",function(){
    var increase=$(this).val();
    $.post({
        url:"{{ route('AddItem',['StoreType'=>$StoreType,'StoreId'=>$StoreId]) }}",
        data:{id:increase}
    });

    $.get({
        url:"{{ route('getItems',['StoreType'=>$StoreType,'StoreId'=>$StoreId]) }}",
    }).done(function(data2,textStatus2){
        $(".test").html(data2);
    })


})


//reduce Button effect
$(document).on("click",".ReduceBtn",function(){

var reduce=$(this).val();

     $.post({
      url:"{{  route('ReduceItem',['StoreType'=>$StoreType,'StoreId'=>$StoreId])  }}",
      data:{id:reduce}
      });

    $.get({
        url:"{{ route('getItems',['StoreType'=>$StoreType,'StoreId'=>$StoreId]) }}",
    }).done(function(data2,textStatus2){
        $(".test").html(data2);
    })

})



//cancel Order

$("#cancelOrder").click(function(){

$.post({
  url:"{{ route('CancelItems',['StoreType'=>$StoreType,'StoreId'=>$StoreId]) }}"
}).done(function(data4,textStatus4){
  $(".test").html(data4);
})

})

</script>

<script src="https://js.stripe.com/v2/"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.payment/1.2.3/jquery.payment.min.js"></script>

<script>


$("input[name='OrderTypeI']").change(function(){
  var OrderTypex=$("input[name='OrderTypeI']:checked").val();

  if(OrderTypex=="Delivery"){
 
   $("input[name='PaymentWayI'][value='CashOnDelivery']").removeAttr("disabled");
  }
  else{
    $("input[name='PaymentWayI'][value='CashOnDelivery']").prop("disabled",true);
  }
})








</script>

@if (!empty($ApiKey))   
<script>


$(document).on("click","button",function(){
var target =$(this).data("target")


if(target =="#WaitingPay"){
var $form = $('.WaitingForm');
}

if(target =="#PayModal"){
var $form = $('.PayForm');
}
      
      $form.find('.subscribe').on('click', payWithStripe);
      
      /* If you're using Stripe for payments */
      function payWithStripe(e) {
          e.preventDefault();
          
          /* Abort if invalid form data */
          if (!validator.form()) {
              return;
          }
    
      
          /* Visual feedback */
          $form.find('.subscribe').html('Validating <i class="fa fa-spinner fa-pulse"></i>').prop('disabled', true);
      
          var PublishableKey = '{{$ApiKey["ApiPub"]}}'; // Replace with your API publishable key
          Stripe.setPublishableKey(PublishableKey);
          
          /* Create token */
          var expiry = $form.find('[name=cardExpiry]').payment('cardExpiryVal');
          var ccData = {
              number: $form.find('[name=cardNumber]').val().replace(/\s/g,''),
              cvc: $form.find('[name=cardCVC]').val(),
              exp_month: expiry.month, 
              exp_year: expiry.year
          };
          
          Stripe.card.createToken(ccData, function stripeResponseHandler(status, response) {
              if (response.error) {
                  /* Visual feedback */
                  $form.find('.subscribe').html('Try again').prop('disabled', false);
                  /* Show Stripe errors on the form */
                  $form.find('.payment-errors').text(response.error.message);
                  $form.find('.payment-errors').closest('.row').show();
              } else {
                  /* Visual feedback */
                  $form.find('.subscribe').html('Processing <i class="fa fa-spinner fa-pulse"></i>');
                  /* Hide Stripe errors on the form */
                  $form.find('.payment-errors').closest('.row').hide();
                  $form.find('.payment-errors').text("");
                  // response contains id and card, which contains additional card details            
                  var token = response.id;




if(target =="#PayModal"){
var data={ 
          token:token,
          OrderTypeI:$("input[name='OrderTypeI']:checked").val(),
          DeliveryEmpI:$("select[name='DeliveryEmpI']").val(),
          DeliveryAddressI:$("input[name='DeliveryAddressI']").val(),
          DeliveryPhoneI:$("input[name='DeliveryPhoneI']").val(),
          OrderTableI:$("input[name='OrderTableI']:checked").val(),
          OrderTableNameI:$("input[name='OrderTableNameI']").val(),
          PaymentWayI:$("input[name='PaymentWayI']:checked").val(),
          CasherId:$("input[name='PaymentWayI']").val(),
          _token: '{!! csrf_token() !!}',
        };
       }
      if(target =="#WaitingPay"){
      var data={
        token:token,
        idWaiting:$("input[name='idWaiting']").val(),
        OrderTypeIWaiting:$("input[name='OrderTypeIWaiting']").val(),
        PaymentWayIWait:$form.find("input[name='PaymentWayIWait']:checked").val(),
        _token: '{!! csrf_token() !!}',
      };

        
      }
      console.log(target)

      if(target =="#PayModal"){
                            var PayPost = '{{ route("PayOrderStripe",["StoreType"=>$StoreType,"StoreId"=>$StoreId]) }}';
                            }
                            if(target =="#WaitingPay"){
                              var PayPost = '{{ route("WaitPay",["StoreType"=>$StoreType,"StoreId"=>$StoreId]) }}' 
                            }
                  // AJAX - you would send 'token' to your server here.
                  $.post(PayPost,data)
                      // Assign handlers immediately after making the request,
                      .done(function(data, textStatus, jqXHR) {
                        $form.find('.subscribe').html('Payment successful you will redirect to Dashboard Soon <i class="fa fa-check"></i>');
                          var delay = 2000; 
                          var url = '{{ route("StorePos",["StoreType"=>$StoreType,"StoreId"=>$StoreId]) }}'
                          setTimeout(function(){ window.location = url; }, delay);
                      })
                      .fail(function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                          $form.find('.subscribe').html('There was a problem').removeClass('success').addClass('error');
                          /* Show Stripe errors on the form */
                          $form.find('.payment-errors').text('Try refreshing the page and trying again.');
                          $form.find('.payment-errors').closest('.row').show();
                      });
              }
          });
      }
      /* Fancy restrictive input formatting via jQuery.payment library*/
      $('input[name=cardNumber]').payment('formatCardNumber');
      $('input[name=cardCVC]').payment('formatCardCVC');
      $('input[name=cardExpiry').payment('formatCardExpiry');
      
      /* Form validation using Stripe client-side validation helpers */
      jQuery.validator.addMethod("cardNumber", function(value, element) {
          return this.optional(element) || Stripe.card.validateCardNumber(value);
      }, "Please specify a valid credit card number.");
      
      jQuery.validator.addMethod("cardExpiry", function(value, element) {    
          /* Parsing month/year uses jQuery.payment library */
          value = $.payment.cardExpiryVal(value);
          return this.optional(element) || Stripe.card.validateExpiry(value.month, value.year);
      }, "Invalid expiration date.");
      
      jQuery.validator.addMethod("cardCVC", function(value, element) {
          return this.optional(element) || Stripe.card.validateCVC(value);
      }, "Invalid CVC.");
      
      validator = $form.validate({
          rules: {
              cardNumber: {
                  required: true,
                  cardNumber: true            
              },
              cardExpiry: {
                  required: true,
                  cardExpiry: true
              },
              cardCVC: {
                  required: true,
                  cardCVC: true
              }
          },
          highlight: function(element) {
              $(element).closest('.form-control').removeClass('success').addClass('error');
          },
          unhighlight: function(element) {
              $(element).closest('.form-control').removeClass('error').addClass('success');
          },
          errorPlacement: function(error, element) {
              $(element).closest('.form-group').append(error);
          }
      });
      
      paymentFormReady = function() {
          if ($form.find('[name=cardNumber]').hasClass("success") &&
              $form.find('[name=cardExpiry]').hasClass("success") &&
              $form.find('[name=cardCVC]').val().length > 1) {
              return true;
          } else {
              return false;
          }
      }
      
      $form.find('.subscribe').prop('disabled', true);
      var readyInterval = setInterval(function() {
          if (paymentFormReady()) {
              $form.find('.subscribe').prop('disabled', false);
              clearInterval(readyInterval);
          }
      }, 250);


    })

</script>
@endif



@endsection

