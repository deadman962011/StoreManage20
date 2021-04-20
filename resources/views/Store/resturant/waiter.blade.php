@extends('layout.nativeBase')

@section('title')
    <title>{{ trans('lang.WatiersViewTitle') }}</title>
@endsection


@section("content")

<div class='wrapper'>
    @include('includes.resturantNav')
<div class="StoreContent">
    @include('includes.navbar')
    @include('includes.error')
    <div class='Dashboard2'>
   @foreach ($Orders as $order)
        <div class="col-sm-11 ">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h4 class='text-center'>Items</h4>
                    <ul class="list-group">
                        @foreach ($order->OrderCart->items as $item)
                        <li class="list-group-item">{{$item['item']->ProdName}}
                            @if( str_replace('_','-',app()->getLocale()) == 'ar' )
                             <span class="label label-default pull-left">{{$item['qty']}}</span></li>
                            @else
                             <span class="label label-default pull-right">{{$item['qty']}}</span></li>
                            @endif
                        @endforeach  
                  </ul>
                  <h4 class="text-center">Order Name: <span>{{$order->OrderName}}</span></h4>
                </div>
                <div class="panel-footer">
                    @if( str_replace('_','-',app()->getLocale()) == 'ar' )
                     <h4 class='pull-left'>table> {{($order->OrderInf['TableName'])}}</h4>
                    @else
                     <h4 class='pull-right'>table> {{($order->OrderInf['TableName'])}}</h4>
                    @endif
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

 