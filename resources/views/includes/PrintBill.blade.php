




<html>
    <head>
        <link rel="stylesheet" href="http://127.0.0.1/cdn/bootstrap/css/bootstrap.min.css">
    </head>
    <body>
        
<br>
<br>
<br>



<div class="col-md-10 col-xs-12 col-sm-10 col-sm-offset-1 col-md-offset-1">
<table class="table ">
    <thead>
        <tr>
            <th>Product Name </th>
            <th>Product Price</th>
            <th>Prdouct Quantity</th>
            <th>Totoal Price</th>
        </tr>
    </thead>
    <tbody>
         @if (!empty($Order))
          @foreach ($Order as $orders)
          @foreach ($orders->OrderCart->items as $item)
          <tr>
            <td>{{$item["item"]->ProdName}}</td>
            <td>{{$item["item"]->ProdPrice}}</td>
            <td>{{$item["qty"]}}</td>
            <td>{{$item["price"]}}</td>
        </tr>
          @endforeach
          @endforeach   
         @endif 
    </tbody>
</table>
</div>
<script src="http://127.0.0.1/cdn/jquery/jquery.min.js"></script>
<script>

$(document).ready(function(){
    window.print()
})
</script>


</body>
</html>
