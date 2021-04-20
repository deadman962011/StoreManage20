<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">


    <link rel="stylesheet" href="{{ url('/inc/css/style.css')}}">
  @if( str_replace('_','-',app()->getLocale()) == 'ar' )
    <link rel="stylesheet" href="{{ url('/inc/css/rtlStyle.css')}}">
<!-- compiled and minified CSS -->
<link rel="stylesheet"
  href="{{ url("inc/css/bootstrap-rtl.min.css") }}">
<!-- compiled and minified theme CSS -->
	@endif

   @yield("title")
    
    @yield('style')
</head>
<body>
<div class="wrapper">
  @include('includes.DashboardNav')
  @yield('content')
</div>


 <script src="https://code.jquery.com/jquery-3.4.1.min.js" ></script>
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
 <script src="{{ url("inc/js/script.js") }}"></script>
<script>
</script>


<script>
    $(".NotifBtn").click(function(){
    console.log("test")
  })

  $(".collapse").on("show.bs.collapse",function(){

$(".collapse.in").each(function(){
  $(this).collapse("hide");
})
})





</script>




@yield('script')
 
</body>
</html>
