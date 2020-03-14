@extends('layout.nativeBase')

@section("style")
<meta name="csrf-token" content="{{ csrf_token() }}">
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





<div class="Dashboard row">
  <ul class="nav nav-tabs">
    @foreach ($Repos as $repo)
     <li><a data-toggle="tab" href="#{{ $repo['id']}}"><h4>{{ $repo['RepoName'] }}</h4></a></li>
    @endforeach
  </ul>

  <div class="tab-content">
  @foreach ($Repos as $repoProds)
  
    <div id="{{$repoProds['id']}}" class="tab-pane fade">
      <table id="dataTable" class="table  table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>{{ trans("lang.RProdTableName") }}</th>
                <th>{{ trans("lang.RProdTableQuantity") }}</th>
                <th>{{ trans("lang.RProdTableSource") }}</th>
                <th>{{ trans("lang.RProdTableOptions") }}</th>
            </tr>
        </thead>
        <tbody>
          <tr>
            <form action="{{route("AddRProd",["StoreType"=>$StoreType,"StoreId"=>$StoreId])}}" method="post">
             <td><input type="text" name="RProdNameI"  class="form-control"></td>
             <td><input type="text" name="RProdQtyI"  class="form-control"></td>
             <td><input type="text" name="RProdSourceI"  class="form-control"></td>
             <input type="hidden" name="RProdRepoI" value='{{ $repoProds['id'] }}'>
             <td><input type="submit"  class="btn btn-primary" style='width:85px'></td>
            {{ csrf_field() }}
          </form>
          </tr>
          @foreach ($repoProds['Prods'] as $RProd)
          <tr>
            <td>{{ $RProd['RProdName']}}</td> 
            <td>{{$RProd['RProdQty']}}</td>
            <td>{{$RProd['RProdSource']}}</td>
            <td>
              <button class='btn btn-warning UpdateBtn '  data-toggle="modal" data-target="#UpdateRprod" data-RProdId="{{ $RProd['id'] }}">E</button>
              <a href="{{ route("RepoProdDel",['StoreType'=>$StoreType,'StoreId'=>$StoreId,'RProdId'=>$RProd['id']]) }}" class='btn btn-danger'>X</a>
            </td>
          </tr>        
          @endforeach

          
  
        </tbody>
      </table>
    </div>
    @endforeach
  </div>


   <!-- Modal -->
   <div class="modal fade" id="UpdateRprod" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-body">
          <form action="{{route('RprodUpPost',['StoreType'=>$StoreType,'StoreId'=>$StoreId])}}" method="post" class="form-horizontal">
          <div class="form-group">
            <div class="col-sm-3"><label for="RprodNameUp" class="form-label">Product Name:</label></div>
            <div class="col-sm-6"><input type="text" name="RprodNameUp"  class="form-control"></div>
          </div>
          <div class="form-group">
            <div class="col-sm-3"><label for="RprodQtyUp" class="form-label">Product Quantity:</label></div>
            <div class="col-sm-6"><input type="text" name="RprodQtyUp"  class="form-control"></div>
          </div>        
          <div class="form-group">
            <div class="col-sm-3"><label for="RprodSourceUp" class="form-label">Product Source:</label></div>
            <div class="col-sm-6"><input type="text" name="RprodSourceUp"  class="form-control"></div>
            <input type="hidden" name="RprodIdUp">
          </div>
          {{ csrf_field() }}

        </div>

        <div class="modal-footer">
          <input type="submit" value="Update" class="btn btn-primary">
        </form>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>


 

  </div>
 </div>
</div>

@endsection

@section("script")

@include('includes.dataTableJs')

<script >

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).on("click",".UpdateBtn",(function(){

var RProd =$(this).data("rprodid");

$.ajax({
  "method":"post",
  "url":"{{ route('RProdUpData',['StoreType'=>$StoreType,'StoreId'=>$StoreId])}}",
  "data":{RProd:RProd}
}).done(function(data,textStatus){

  if(textStatus == "success"){
  $("input[name='RprodNameUp']").val(data.RProdName);
  $("input[name='RprodQtyUp']").val(data.RProdQty);
  $("input[name='RprodSourceUp']").val(data.RProdSource);
  $("input[name='RprodIdUp']").val(data.id);
  }
})


 })
)



</script>



@endsection
