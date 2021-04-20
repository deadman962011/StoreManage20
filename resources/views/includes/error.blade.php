@if (!empty(session('err')))
@if (session('err')['err'] == "0")
<div id='StoreAlert' class="alert alert-success col-sm-6 col-sm-offset-1">
 <strong>{{  trans("lang.".session('err')['message'])  }}</strong>
</div>
@endif
@if (session('err')['err'] == "1")
<div id='StoreAlert' class="alert alert-danger col-sm-6 col-sm-offset-1" >
 <strong>{{ trans("lang.".session('err')['message'])  }}</strong>
</div>
@endif      
@endif

@if (!empty(session("PlanErr")))
<div id="StoreAlert" style="display:block;" class="alert alert-danger col-sm-8 col-sm-offset-1">
    <strong>{{ trans("lang.PlanErr")}} {{session("PlanErr")['DayLeft']}} {{ trans("lang.PlanErr2") }}</strong>
   </div>     
@endif

