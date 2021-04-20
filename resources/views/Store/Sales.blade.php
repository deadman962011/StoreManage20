@extends('layout.nativeBase')



@section('title')
    <title>{{ trans('lang.SalesViewTitle') }}</title>
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
 <div class='Dashboard'>
    <table id="dataTable" class="table  table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>{{ trans("lang.OderTableName") }}</th>
                <th>{{ trans("lang.OrderTableType") }}</th>
                <th>{{ trans("lang.OrderTableTotalPrice") }}</th>
                <th >{{ trans("lang.OrderTableOrderdBy") }}</th>
                <th>Order Status</th>
                <th>{{ trans("lang.OrderTableCreated_At") }}</th>
                <th>{{ trans("lang.OrderTableOptions") }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($Orders as $order)

            @if ($order['OrderStatus'] =="success")
            <tr class="success">
            @endif
            @if ($order['OrderStatus'] =="ready")
            <tr class="warning">               
            @endif
            @if ($order['OrderStatus'] =="Done")
            <tr class="info">               
            @endif           

               <td>{{ $order['OrderName'] }}</td>
                <td>{{ $order['OrderType'] }}</td>
                <td>{{ $order['OrderPrice'] }}</td>
                <td>{{ $order['OrderBy'] }}</td>
                <td>{{ $order['OrderStatus'] }}</td>
                <td>{{ $order['created_at'] }}</td>
                <td><a href="{{ route("PrintOrder",["StoreType"=>$StoreType,"StoreId"=>$StoreId,"OrderId"=>$order['id']]) }}" class="btn btn-info"><span class="glyphicon glyphicon-print"></span></a></td>
              </tr> 
            @endforeach
        </tbody>
    </table>

 </div>
</div>



@section("script")

<script src="http://127.0.0.1/cdn/jquery/jquery.dataTables.min.js"></script>
<script src="http://127.0.0.1/cdn/store-manage/dataTables.bootstrap.min.js"></script>
@include('includes.dataTableJs')

@endsection