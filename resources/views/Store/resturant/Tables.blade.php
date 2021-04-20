@extends('layout.nativeBase')

@section('title')
    <title>{{ trans('lang.TablesViewTitle') }}</title>
@endsection



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
                 <button data-toggle="modal" data-TableId="{{$table['id']}}" data-target="#UpdateTableModal" class="btn btn-warning getTable"><span class="glyphicon glyphicon-edit"></span></button>
                 <a href="{{ route("DelTable",["StoreType"=>$StoreType,"StoreId"=>$StoreId,'TableId'=>$table['id']]) }}" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span></a>
                </td>
              </tr>
             @endforeach 
           
        </tbody>
    </table>
  </div>
</div>


  <!-- Modal -->
  <div class="modal fade" id="UpdateTableModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Update Table Modal</h4>
        </div>
        <div class="modal-body"> 
          <form action="{{ route("UpdateTable",["StoreType"=>$StoreType,"StoreId"=>$StoreId])}}" method="post" class="form-horizontal">
            <div class="form-group">
                <div class="col-sm-3"><label for="TableNameUpI">Table Name:</label></div>
                <div class="col-sm-6"><input type="text" name="TableNameUpI"  class="form-control"></div>
            </div>
            <div class="form-group">
                <div class="col-sm-3"><label for="TableStausUpI">Table Status</label></div>
                <div class="col-sm-6"><select name="TableStausUpI" class='form-control'><option value="AvailAble">Available</option><option value="InUse">InUSe</option>In Use<option value="Disabled">Disabled</option></select></div>
            </div>
            <div class="form-group">        
                <div class="col-sm-3"><label for="TableMaxSeatUpI">Max Seats:</label></div>
                <div class="col-sm-6"><input type="text" name="TableMaxSeatUpI"  class="form-control"></div>
                <input type="hidden" name="TableId">
            </div>
            
        </div>
        <div class="modal-footer">
          <input type="submit" value="Update Table" class="btn btn-primary">
        {{ csrf_field()}}
        </form>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>


</div>
@endsection


@section("script")

@include('includes.dataTableJs')
<script>
$(document).ready(function() {
    $('#TablesTable').dataTable();


$(document).on("click",".getTable",function(){

var TableId=$(this).data("tableid");

$.post({
    url:"{{ route('getTable',["StoreType"=>$StoreType,"StoreId"=>$StoreId])}}",
    data:{TableId:TableId,
          _token:"{{csrf_token()}}"
    }
}).done(function(response,textStatus){

$("input[name='TableNameUpI']").val(response.TableName);
$("input[name='TableMaxSeatUpI']").val(response.TableMaxSeat);
$("input[name='TableId']").val(response.id);



})

})



});








</script>

@endsection