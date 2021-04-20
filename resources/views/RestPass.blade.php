@extends("layout.nativeBase")

@section("title")

<title>{{ trans('lang.RestPassView') }}</title>
@endsection




@section('content')
<div class="container">
<div class="row">
    <div class="col-sm-6 col-sm-offset-3">
        <div class="RestPass">
            <h4 class="text-center">{{ trans('lang.RestPass') }}</h4>
            <br>

            <form action="" method="post" class="form-horizontal">
             <div class="form-group">
              <div class="col-sm-10 col-sm-offset-1">
                 <p>{{ trans('lang.RestPassDesc') }}</p>
                 <input type="email" name="RestEmail" class="form-control" placeholder="{{ trans('lang.FormPlaceHolderEmail') }}" required>
              </div>
            </div>
            <div class="form-group">
             <div class="col-sm-8 col-sm-offset-2">
                 <input type="submit" value="Rest Password" class="btn btn-primary btn-block">
             </div>
            </div>

            {{ csrf_field() }}



            </form>
        </div>
    </div>
</div>

</div>

@endsection