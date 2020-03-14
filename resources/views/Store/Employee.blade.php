@extends('layout.nativeBase')


@section('style')
<link rel="stylesheet" href="http://127.0.0.1/cdn/store-manage/dataTables.bootstrap.min.css">
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

 <div class='Dashboard'>
    <table id="dataTable" class="table table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>{{ trans("lang.EmployeeTableName") }}</th>
                <th>{{ trans("lang.EmployeeTableFee") }}</th>
                <th>{{ trans("lang.EmployeeTablePTM") }}</th>
                <th>{{ trans("lang.EmployeeTableType") }}</th>
                <th>{{ trans("lang.EmployeeTableStatus") }}</th>
                <th>{{ trans("lang.EmployeeTableOptions") }}</th>
    
            </tr>
        </thead>
        <tbody>
            @foreach ($employees as $employee)
             <tr>
             <td>{{ $employee['EmployeeName'] }}</td>
                <td>{{ $employee['EmployeeFee'] }}</td>
                <td>{{ $employee['EmployeeDP'] }}</td>
                <td>{{ $employee['EmployeeType'] }}</td>
                <td>{{ $employee['EmployeeMS'] }}</td>
                <td style="width:90px">
                 <button class="btn btn-warning"><span class="glyphicon glyphicon-edit"></span></button>
                 <a href="{{ route("DelEmployee",["EmpId"=>$employee['id'],'StoreType'=>$StoreType,'StoreId'=>$StoreId]) }}" class="btn btn-danger">X </a>
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

<script src="http://127.0.0.1/cdn/jquery/jquery.dataTables.min.js"></script>
<script src="http://127.0.0.1/cdn/store-manage/dataTables.bootstrap.min.js"></script>
@include('includes.dataTableJs')

@endsection
