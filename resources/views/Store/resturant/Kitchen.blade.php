@extends('layout.nativeBase')

@section('style')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section("content")




@section("content")
<div class='wrapper'>
@include('includes.resturantNav')
<div class="StoreContent">
    @include('includes.navbar')
   <div class='Dashboard2'>

    @foreach ($Orders as $order)
    <div class="col-sm-10">
        
        <div class="panel panel-default">
            <div class="panel-body"><ul class="list-group">  
                @foreach ($order->OrderCart->items as $item)
                <li class="list-group-item">{{ $item['item']->ProdName }}
                  @if( str_replace('_','-',app()->getLocale()) == 'ar' )
                   <span class="label label-default pull-left">{{ $item['qty'] }}</span>
                   @else
                   <span class="label label-default pull-right">{{ $item['qty'] }}</span>
                	@endif
                </li>
                @endforeach
        
              </ul></div>
            <div class="panel-footer">
              <button value="{{ $order['id'] }}" class="btn btn-primary EditBtn">ready</button>
              @if( str_replace('_','-',app()->getLocale()) == 'ar' )
               <h4 class="pull-left">{{ $order['OrderType'] }}</h4>
              @else
               <h4 class='pull-right'>{{ $order['OrderType'] }}</h4>
             @endif
            </div>
          </div>
    </div>
    
    
    @endforeach


    </div>
  </div>
</div>



@endsection


@section('script')
    
<script>

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});





$('.EditBtn').click(function(){

  var orderId= $(this).val();
$.post({
  url:"{{ route('OrderKitchen',['StoreType'=>$StoreType,'StoreId'=>$StoreId]) }}",
  data:{id:orderId,
    _token: '{!! csrf_token() !!}',}
}).done(function(data,textStatus){

var delay = 300; 
var url = '{{ route("Kitchen",['StoreType'=>$StoreType,'StoreId'=>$StoreId]) }}'
setTimeout(function(){ window.location = url; }, delay);

})
})



</script>


@endsection