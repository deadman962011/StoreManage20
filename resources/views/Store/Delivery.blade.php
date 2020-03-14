@extends('layout.nativeBase')


@section("content")

<div class='wrapper'>
    @if ($StoreType === "restaurant")
    @include('includes.resturantNav')
   @else
    @include('includes.sideNav')   
   @endif

   <div class="StoreContent">
  @include('includes.navbar')
  @include("includes.error")
   

    <div class='Dashboard2'>
        @foreach ($Orders as $order)
         <div class="cols-m-10">
             <div class="panel">
                 <div class="panel-body">
                     <h4 class="text-center">Items</h4>
                    <ul class="list-group">
                        @foreach ($order->OrderCart->items as $item)
                        <li class="list-group-item">{{$item['item']->ProdName}}<span class="label label-default pull-left">{{$item['qty']}}</span></li>
                        @endforeach  
                    </ul>
                    <h4 class='text-center'>Deliver Informations</h4>
                    <br>
                    <br>
                    <h4 class="text-center"><span style="font-weight:bold">Order Name:</span>   {{$order['OrderName']}}</h4>
                    <h4 class="text-center"><span style="font-weight:bold">Delivery Phone:</span>   {{$order['OrderInf']['DeliveryPhone'] }}</h4>
                    <h4 class="text-center"><span style="font-weight:bold">Delivery Address: </span>   {{$order['OrderInf']['DeliveryAddress']}}</h4>

                 </div>
                 <div class="panel-footer">
                     <h4 class='pull-left'><span>Delivery></span>DName</h4>

                     <form action="{{ route("DeliveryPost",["StoreType"=>$StoreType,"StoreId"=>$StoreId]) }}" method="post">
                        <button class="btn btn-primary" name='DeliveryDone' value='{{ $order['id'] }}'>Deliver</button>
                        {{ csrf_field() }}                
                    </form>

                 </div>
             </div>
         </div>

    
        @endforeach
  </div>
 </div>
</div>
@endsection

 