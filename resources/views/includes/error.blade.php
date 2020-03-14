@if (!empty(session('err')))
@if (session('err')['err'] == "0")
<div id='StoreAlert' class="alert alert-success col-sm-6 col-sm-offset-1">
 <strong>{{ session('err')['message'] }}</strong>
</div>
@endif
@if (session('err')['err'] == "1")
<div id='StoreAlert' class="alert alert-danger col-sm-6 col-sm-offset-1" >
 <strong>{{ session('err')['message'] }}</strong>
</div>
@endif      
@endif