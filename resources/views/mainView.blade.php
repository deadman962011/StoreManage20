@extends("layout.nativeBase")


@section("content")

<h4>{{ trans("lang.hi") }}</h4>

<a href="users/SignIn">{{ trans("lang.signIn") }}</a>
<a href="users/SignUp">{{ trans("lang.signUp") }} </a>

@endsection
