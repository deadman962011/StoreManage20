@extends("layout.nativeBase")

@section('title')
    <title>{{ trans('lang.SignInViewTitle') }}</title>
@endsection

<div class="col-sm-9 col-sm-offset-3 col-xs-12">
  <br>
  <br>
  @include('includes.error')
</div>

@section("content")
<div class="container">
<div class="row">
  <div class="col-sm-6 col-sm-offset-3">
   @if(!empty($message))
    <h4>{{$message}}</h4>
   @endif
   <div class="SignIn ">
     <h4>{{ trans('lang.SignInViewTitle') }}</h4>
     <form class="form-horizontal" method="post">
       <br>
       <div class="form-group">
         
         <div class=" col-sm-offset-2 col-sm-8 col-xs-12">
          <input type="text" name="UserNameI" class='form-control' placeholder="{{ trans('lang.FormPlaceHolderUser') }}" required>
         </div>
       </div>
       <br>
       <div class="form-group">
         
         <div class="col-sm-offset-2 col-sm-8 col-xs-12">
           <input type="password" name="PasswordI" class='form-control' placeholder="{{ trans('lang.FormPlaceHolderPass') }}" required>
         </div>
       </div>
      <br>
       <div class="form-group">
         <div class="col-sm-6 col-sm-offset-3">
           <input type="submit" value='Login' class='btn btn-primary  btn-block'>
         </div>
       </div>
       {{ csrf_field()}}
     </form>
     <a href="{{route("RestPassGet")}}">{{ trans('lang.SignInForgotPass') }}</a>
   </div>
  </div>

</div>

</div>
@endsection
