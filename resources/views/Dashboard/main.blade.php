@extends("layout.base")


@section('title')
<title>    {{ trans('lang.StoresViewTitle') }}</title>

@endsection 


@section("content")

 <div  class="StoreContent" >


@include('includes.navbar')
    <div class="row Dashboard2 ">
     @include("includes.error")




@foreach ($Stores as $store)
   <div class="col-sm-4">
     <div class="panel">
      <div class="panel-body">
       <img class='img-responsive' src="http://127.0.0.1/cdn/images/1.jpg" alt="">
       <h4 style='text-align:center;'>{{ $store['StoreName'] }}</h4>
      <a href="/users/Dashboard/{{ $store['StoreType'] }}/{{ $store['id'] }}" style="display:block; " class='btn btn-primary'> enter</a>
      </div>
     </div>
    </div>
@endforeach
</div>
</div>

@endsection

