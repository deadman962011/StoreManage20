


@foreach ($products as $product)
 <tr>
  <td><h5>{{$product["item"]->ProdName}}</h5></td>
  <td>{{ $product["item"]->ProdPrice }}</td>
 <td><button class="IncreaseBtn btn btn-default" value='{{ $product["item"]->id }}'>+</button>  {{   $product['qty']   }} <button value='{{ $product["item"]->id }}' class=" ReduceBtn btn btn-default " >-</button></td>
  <td>{{ $product['price'] }}</td>
 <td><button value='{{ $product["item"]->id }}' class="btn btn-danger DelBtn">X</button></td>


  
</tr>
@endforeach

<tr>
<th> </th>
<th> </th>
<th>{{ $totalQty }}</th>
<th>{{ $totalPrice }}</th>
<th></th>
</tr>



  

    




