
<html>
    <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    </head>
    <body>
        
<br>
<br>
<br>



<div class="col-md-10 col-xs-12 col-sm-10 col-sm-offset-1 col-md-offset-1">
<table class="table ">
    <thead>
        <tr>
            <th>{{ trans('lang.billProdName') }}</th>
            <th>{{ trans('lang.billPrice') }}</th>
            <th>{{ trans('lang.billQuant') }}</th>
            <th>{{ trans('lang.billTotalPrice') }}</th>
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
