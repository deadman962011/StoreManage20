@extends('layout.nativeBase')



@section("content")

<div class='wrapper'>
    @include('includes.resturantNav')
<div class="StoreContent">
    @include('includes.navbar')
    @if (!empty(session('err')))
    @if (session('err')['err'] == "0")
    <div id='StoreAlert' class="alert alert-success col-sm-8 col-sm-offset-2">
     <strong>{{ session('err')['message'] }}</strong>
   </div>
    @endif
    @if (session('err')['err'] == "1")
    <div id='StoreAlert' class="alert alert-danger col-sm-8 col-sm-offset-2" >
     <strong>{{ session('err')['message'] }}</strong>
   </div>
    @endif      
  @endif
    <div class='Dashboard2'>
   @foreach ($Orders as $order)
        <div class="col-sm-11 ">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h4 class='text-center'>Items</h4>
                    <ul class="list-group">
                        @foreach ($order->OrderCart->items as $item)
                        <li class="list-group-item">{{$item['item']->ProdName}}<span class="label label-default pull-left">{{$item['qty']}}</span></li>
                        @endforeach  
                     
                  </ul>
                </div>
                <div class="panel-footer">
                    <h4 class='pull-left'>table> {{($order->OrderInf['TableName'])}}</h4>
                    <form action="{{route("waiterPost",["StoreType"=>$StoreType,"StoreId"=>$StoreId])}}" method="post">
                        <button value="{{$order['id']}}" name='OrderDoneI' class="btn btn-primary EditBtn">ready</button>
                        {{csrf_field()}}
                    </form>

                </div>
              </div>
        </div>
    @endforeach
    </div>

    
    </div>
</div>    

</div>
@endsection

 