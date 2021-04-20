@extends('layout.nativeBase')

@section('title')
    <title>{{ trans('lang.CatigoryViewTitle') }}</title>
@endsection

@section('style')

<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
<link rel="stylesheet" href="http://127.0.0.1/cdn/datatables-responsive/dataTables.responsive.css">
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
    @include("includes.error")

<div class='Dashboard ' style="padding: 20px; min-height: 100vh;">

    
  <table id="dataTable" class="table table-responsive table-bordered" style="width:100%">
    <thead>
        <tr>
            <th>{{ trans("lang.CatTableName") }}</th>
            <th>{{ trans("lang.CatTableProdNum")}}</th>
            <th>{{ trans("lang.CatTableCreatedAt") }}</th>
            <th>{{ trans("lang.CatTableOptions") }}</th>

        </tr>
    </thead>
    <tbody>
        <tr>
            <form method="post" action="{{ route("AddCatigory",['StoreType'=>$StoreType,'StoreId'=>$StoreId]) }}">
               <td><input type="text" name="CatigoryNameI"    placeholder="{{ trans('lang.CatigoryPlaceHolderName') }}" class="form-control"></td>
               <td>0</td>
           <td>{{ $now }}  {{ csrf_field() }}</td>
               <td>
                   <input style='width:90px' type='submit' class="btn btn-primary ">
               </td>
            </form>
           </tr>
        @foreach ($Catigories as $catigory)
        <tr>
            <td>{{ $catigory['CatigoryName']}}</td>
            <td>{{ $catigory['CatigoryProdsNum']}}</td>
            <td>{{ $catigory['created_at']}}</td>
            <td>
              
            <a href='{{ route("DelCatigory",['StoreType'=>$StoreType,'StoreId'=>$StoreId,'CatId'=>$catigory['id']]) }}' class="btn btn-danger"><span class="glyphicon glyphicon-eject "></span></a>
            </td>
        </tr>   
        @endforeach
    </tbody>

</table>
     

    </div>
</div>

</div>
@endsection


@section("script")
@include('includes.dataTableJs')
@endsection

