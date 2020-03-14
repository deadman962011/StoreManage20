@extends('layout.nativeBase')





@section("content")
<div class='wrapper'>
@include('includes.resturantNav')
<div class="StoreContent">
    @include('includes.navbar')
    @include("includes.error")
   <div class='Dashboard'>
    <table id="TablesTable" class="table table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Table Name:</th>
                <th>Table Seat</th>
                <th>Table Status</th>
                <th>Options</th>
            </tr>
        </thead>
        <tbody>
            <tr>
             <form action="{{ route("AddTable",['StoreType'=>$StoreType,'StoreId'=>$StoreId]) }}" method="post">
             <td><input type="text" name="TableNameI"  class="form-control"></td> 
             <td><input type="text" name="TableSeatI"  class="form-control"></td>
            <td>
                <select name="TableStatusI" class='form-control'>
                    <option value="Disabled">Disabled</option>
                    <option value="Available">Available</option>
                    <option value="InUse">In Use</option>
                </select>
            </td>
            <td><input type="submit"  class="btn btn-primary"></td>
            {{ csrf_field() }}
             </form>
            </tr>
            
             @foreach ($Tables as $table)
              <tr> 
                <td>{{ $table['TableName'] }}</td>
                <td>{{ $table['TableMaxSeat']}}</td>
                <td>{{ $table['TableStatus']}}</td>
                <td>
                 <button class="btn btn-warning"><span class="glyphicon glyphicon-edit"></span></button>
                 <a href="{{ route("DelTable",["StoreType"=>$StoreType,"StoreId"=>$StoreId,'TableId'=>$table['id']]) }}" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span></a>
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
<script>
$(document).ready(function() {
    $('#TablesTable').dataTable();

} );

</script>

@endsection