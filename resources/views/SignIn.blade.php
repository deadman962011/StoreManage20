@extends("layout.nativeBase")



@section("content")
<div class="container">
<div class="row">
  <div class="col-sm-6 col-sm-offset-3">
   @if(!empty($message))
    <h4>{{$message}}</h4>
   @endif
   <div class="SignIn ">
     <h4>Log In</h4>
     <form class="form-horizontal" method="post">
       <br>
       <div class="form-group">
         <div class="col-sm-3"><label for="UserNameI" class="form-label">User Name:</label></div>
         <div class="col-sm-8">
          <input type="text" name="UserNameI" class='form-control' placeholder="Username Input" required>
         </div>
       </div>
       <br>
       <div class="form-group">
         <div class="col-sm-3"><label for="PasswordI" class="form-label">Password:</label></div>
         <div class="col-sm-8">
           <input type="text" name="PasswordI" class='form-control' placeholder="Password Input" required>
         </div>
       </div>
      <br>
       <div class="form-group">
         <div class="col-sm-7 col-sm-offset-3">
           <input type="submit" value='Login' class='btn btn-primary  btn-block'>
         </div>
       </div>
       {{ csrf_field()}}
     </form>
     <a href="{{route("RestPassGet")}}">Forgot Your Rest Password?</a>
   </div>
  </div>

</div>

</div>
@endsection
