@extends('layout.nativeBase')

@section('title')
    <title>{{ trans('lang.RepoDelViewTitle') }}</title>
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

    @foreach ($Repos as $repo)
    <div class="col-sm-4">
      <div class="panel">
        <div class="panel-body">
          <h4 style='margin:30px;display:inline-block;font-weight: bold;'>{{ $repo['RepoName']}}</h4>
          <a href="{{ route("DelRepo2",["RepoId"=>$repo['id'],'StoreType'=>$StoreType,'StoreId'=>$StoreId])}}" class='btn btn-danger'>X</a>
        </div>
      </div>
    </div>    
    @endforeach


  </div>
 </div>
</div>