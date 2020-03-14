@extends("layout.nativeBase")

@section("title")

<title>Set New Password</title>
@endsection




@section('content')
<div class="container">
<div class="row">
    <div class="col-sm-6 col-sm-offset-3">
        <div class="RestPass">
            <form  method="post" class="form-horizontal">
             <div class="form-group">
              <div class="col-sm-10 col-sm-offset-1">
                 <input type="password" name="NewPass" class="form-control" placeholder="Put New Password Here" required>
              </div>
            </div>
            <div class="form-group">
                <div class="col-sm-10 col-sm-offset-1">
                   <input type="password" name="NewPass_confirmation" class="form-control" placeholder="Repeat New Password Here" required>
                </div>
              </div>
            <div class="form-group">
             <div class="col-sm-8 col-sm-offset-2">
                 <input type="submit" value="Save New Password" class="btn btn-primary btn-block">
             </div>
            </div>

            {{ csrf_field() }}



            </form>
        </div>
    </div>
</div>

</div>

@endsection