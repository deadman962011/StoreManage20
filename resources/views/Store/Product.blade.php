@extends('layout.nativeBase')


@section('style')
<link rel="stylesheet" href="http://127.0.0.1/cdn/store-manage/dataTables.bootstrap.min.js">
<link rel="stylesheet" href="http://127.0.0.1/cdn/datatables-responsive/dataTables.responsive.css">
<meta name="csrf-token" content="{{ csrf_token() }}">
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

<div class='Dashboard '>

    
  <table id="dataTable" class="table table-bordered" style='width:100%' >
    <thead>
        <tr>
          <th>{{ trans("lang.ProdTablePreview") }}</th>
            <th>{{ trans("lang.ProdTableName") }}</th>
            <th>{{ trans("lang.ProdTableCatigory") }}</th>
            <th >{{ trans("lang.ProdTablePrice") }}</th>
            <th>{{ trans("lang.ProdTableCreatedAt") }}</th>
            <th>{{ trans("lang.ProdTableOptions") }}</th>

        </tr>
    </thead>
    <tbody>
      <tr>
        <form action="{{ route("AddProd",["StoreType"=>$StoreType,"StoreId"=>$StoreId]) }}" enctype='multipart/form-data' method="post">
            <td><input type="file" name="ProdImgI" style='width:100px' ></td>
            <td><input type="text" name="ProdNameI"    placeholder="Product Name" class="form-control"></td>
            <td>
              <select name="ProdCatigoryI"  class="form-control">
                @foreach ($Catigories as $catigory)
              <option value="{{ $catigory['id'] }}">{{ $catigory['CatigoryName'] }}</option> 
                @endforeach
              </select>
            </td>
            <td ><input style=" width:90px;" type="text" name="ProdPriceI" placeholder="Price"  class="form-control"></td>
              <td>{{ $now }} {{ csrf_field()}}</td>
            <td>
                <input style='width:90px;' type='submit' class="btn btn-primary ">
            </td>
         </form>
        </tr>
      @foreach ($Products as $Product)
       <tr>
        <td><img src="{{ Storage::url("products/{$Product->Image["PicSource"]}")  }}" class='img-responsive'>  </td>
         <td>{{ $Product['ProdName']}}</td>
         <td>{{$Product->Catigory['CatigoryName']}}</td>
         <td >{{ $Product['ProdPrice']}}</td>
         <td>{{ $Product['created_at']}}</td>
         <td>
          <button class="btn btn-warning UpdateBtn" data-toggle="modal" data-target="#UpProdModal" data-ProdId="{{ $Product['id'] }}" ><span class='glyphicon glyphicon-edit'></span></button>
          <a href="{{ route("DelProd",['StoreType'=>$StoreType,'StoreId'=>$StoreId,"ProdId"=>$Product['id']]) }}" class="btn btn-danger"><span class="glyphicon glyphicon-eject"></span></a>
        </td>
 
       </tr>
      @endforeach


    </tbody>

</table>


<!-- Update Product Modal Modal -->
<div class="modal fade" id="UpProdModal" role="dialog">
  <div class="modal-dialog">
  
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body">
        <br>
        <br>
        <form action="{{ route("UpdateProd",['StoreType'=>$StoreType,'StoreId'=>$StoreId]) }}" method='POST' enctype='multipart/form-data' class="form-horizontal">
         
          <div class="form-group">
            <div class="col-sm-3"><label for="ProdPreviewUPI" class="form-label">Product Preview</label></div>
            <div class="col-sm-6"><input type="file" name="ProdPreviewUPI"  ></div>

          </div>

          <div class="form-group">
            <div class="col-sm-3"><label for="ProdNameUPI" class="form-label">Product Name</label></div>
            <div class="col-sm-6"><input type="text" name="ProdNameUPI" class="form-control" required></div>
            <input type="hidden" name="ProdIdUpI" >
          </div>
          <div class="form-group">
            <div class="col-sm-3"><label for="ProdCatigoryUPI" class="form-label">Product Catigory</label></div>
            <div class="col-sm-4"><select name="ProdCatigoryUPI" class="form-control" required> 
              @foreach ($Catigories as $catigory2)
               <option value="{{ $catigory2['id'] }}">{{ $catigory2['CatigoryName']}}</option>             
              @endforeach


              </select>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-3"><label for="ProdPriceUPI" class="form-label">Product Price</label></div>
            <div class="col-sm-6"><input type="text" name="ProdPriceUPI"  class="form-control"  required></div>

          </div>   
          {{csrf_field()}}      
        

      </div>
      <div class="modal-footer">
        <input type="submit" value='Update'  class="btn btn-primary">
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



<script>


$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


$(document).on("click",".UpdateBtn",function(){
  var ProdId=$(this).data("prodid");
  
$.ajax({
    method:"post",
    url:"{{route('UpdateProdG',['StoreType'=>$StoreType,'StoreId'=>$StoreId])}}",
    data:{ProdId:ProdId}
   }).done(function(data,textStatus){

$("input[name='ProdIdUpI']").val(data.id);
$("input[name='ProdNameUPI']").val(data.ProdName);
$("input[name='ProdPriceUPI']").val(data.ProdPrice);


})

})






</script>

@endsection

