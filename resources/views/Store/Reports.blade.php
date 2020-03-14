@extends('layout.nativeBase')


@section('style')
<link rel="stylesheet" href="http://127.0.0.1/cdn/store-manage/dataTables.bootstrap.min.js">
@endsection



@section("content")

<div class='wrapper'>
 
@if ($StoreType === "restaurant")
 @include('includes.resturantNav')
@else
 @include('includes.sideNav')   
@endif


<div class="StoreContent">
  @include('includes.navbar')

  <div class="Dashboard2">
    
    

  </div>

</div>