@extends("layout.nativeBase")

@section("title")

<title>{{ trans('lang.signUpViewTitle')  }} </title>
@endsection



@section('content')
<div class="container">

<!-- MultiStep Form -->
<div class="row">
    <div class="col-sm-12">
        <form id="msform" class='form-horizontal' method="post">
            <!-- progressbar -->
            <ul id="progressbar">
                <li class="active" style="width:50%">{{ trans("lang.signUpField1Title")}}</li>
                <li style="width:50%;">{{ trans('lang.signUpField2Title') }}</li>
            </ul>
            <!-- fieldsets -->
            <fieldset>
                @if(!empty($message))
                 <h2 class="fs-title">{{$message}}</h2>
                @endif
                <h2 class="fs-title">{{ trans("lang.signUpField1Title") }}</h2>
                <h3 class="fs-subtitle">{{trans("lang.signUpField1Desc") }}</h3>
                <div class="form-group">
                <div class="col-sm-2"><label for="FullNameI" class="form-label">{{ trans("lang.formFullNameTitle") }}</label></div>
                    <div class="col-sm-8"><input type="text" name="FullNameI" placeholder="ادخل الاسم الكامل هنا" class="form-control" required></div>
                </div>
                <div class="form-group">
                    <div class="col-sm-2"><label for="PhoneI" class="form-label">{{ trans("lang.formPhoneNumTitle") }}</label></div>
                    <div class="col-sm-8"><input type="text" name="PhoneI" placeholder="ادخل رقم الهاتف  هنا" class="form-control" required></div>
                </div>
                <div class="form-group">
                    <div class="col-sm-2"><label for="AddressI" class="form-label">{{ trans("lang.formAddressTitle") }}</label></div>
                    <div class="col-sm-8"><input type="text" name="AddressI" placeholder="ادخل العنوان هنا" class="form-control" required></div>
                </div>  

                <input type="button" name="next" class="next action-button btn btn-primary" value="Next"/>
            </fieldset>
            <fieldset>
                <h2 class="fs-title">{{ trans('lang.signUpField2Title')}}</h2>
                <h3 class="fs-subtitle">{Your presence on the social network}</h3>
                <div class="form-group " id='emailCheckG'>
                    <div class="col-sm-2"><label for="EmailI" class="form-label">{{ trans("lang.formEmailTitle") }}</label></div>
                    <div class="col-sm-6"><input id='emailCheck' type="email" name="EmailI" placeholder="(ادخل الايميل  يمكنك  (تسجيل الدخول من خلاله" class="form-control" required></div>
                    <span id='emailMessage'></span>
                   </div>
                <div class="form-group " id='UserCheckG'>
                    <div class="col-sm-2"><label for="UserNameI" class="form-label">{{ trans("lang.formUserNameTitle") }}</label></div>
                    <div class="col-sm-6"><input id='UserNameCheck' type="text" name="UserNameI" placeholder="(ادخل اسم المستخدم  يمكنك  (تسجيل الدخول من خلاله" class="form-control" required></div>
                    <span id='userNameMessage'></span>
                   </div>
                   <div class="form-group" id='firstPassG'>
                    <div class="col-sm-2"><label for="PasswordI" class="form-label">{{ trans("lang.formPaswordTitle") }}</label></div>
                    <div class="col-sm-6"><input type="password" name="PasswordI" placeholder="ادخل كلمة المرور هنا" class="form-control" id='firstPass' required></div>
                   </div> 
                   <div class="form-group" id='SecPassG'>
                    <div class="col-sm-2"><label for="Passwor2I" class="form-label" >{{ trans("lang.formPasswordRTitle") }}</label></div>
                    <div class="col-sm-6"><input type="password" name="Passwor2I" placeholder="كرر كلمة المرور" class="form-control" id='password2' required></div>
                   </div> 
                <input type="submit"  class="btn btn-primary">
                <input type="button" name="previous" class="previous btn btn-danger" value="Previous"/>

            </fieldset>

            {{csrf_field()}}
        </form>
  



</div>
@section('script')
  
<script>

$(document).ready(function(){

$('#UserNameCheck').change(function(){
    var username= $('#UserNameCheck').val();
    if(username != ''){
     
        $.ajax({url:'http://127.0.0.1:8000/users/checkForm',
                method:"GET",
                data:{username:username},
                success:function(dataU){
                if(dataU.err == 0){
                    $('#UserCheckG').removeClass('has-error')
                    $('#UserCheckG').addClass('has-success')
                    $('#userNameMessage').html(dataU.message)
                }
                else{
                  $('#UserCheckG').removeClass('has-success')
                  $('#UserCheckG').addClass('has-error')
                  $('#userNameMessage').html(dataU.message)  
                 }
        }
        })
         }
         else{
            $('#UserCheckG').removeClass('has-success')
            $('#UserCheckG').removeClass('has-error')
          }
})




$('#emailCheck').change(function(){
  var email = $('#emailCheck').val();

  if(email != ''){
    $.ajax({url:'{{ route("CheckSignUp") }}',
            method:'POST',
            data:{email:email},
            success:function(data){
                console.log(data)
             
             if(data.err == 0){
               $('#emailCheckG').removeClass('has-error')
               $('#emailCheckG').addClass('has-success')
               $('#emailMessage').html(data.message)
             }
             else{
                  $('#emailCheckG').removeClass('has-success')
                  $('#emailCheckG').addClass('has-error')
                  $('#emailMessage').html(data.message)  
                 }
            }
           })
          }
          else{
            $('#emailCheckG').removeClass('has-success')
            $('#emailCheckG').removeClass('has-error')
          }
})



$('#password2').change(function(){
    var firstPass = $('#firstPass').val();
    var SecPass = $('#password2').val();
    console.log(firstPass)
    console.log(SecPass)
  if(SecPass != ''){
    if( firstPass === SecPass){
        $('#firstPassG').removeClass('has-error')
        $('#SecPassG').removeClass('has-error')
        $('#firstPassG').addClass('has-success')
        $('#SecPassG').addClass('has-success')
    }
    else{
        $('#firstPassG').addClass('has-error')
        $('#SecPassG').addClass('has-error')
    }
   }
   else{
    $('#firstPassG').removeClass('has-success')
    $('#SecPassG').removeClass('has-success')
    $('#firstPassG').removeClass('has-error')
    $('#SecPassG').removeClass('has-error')
   } 
})

$('#firstPass').change(function(){
    var firstPass = $('#firstPass').val();
    var SecPass = $('#password2').val();
    if(SecPass !=''){
    if(  SecPass === firstPass ){
        $('#firstPassG').removeClass('has-success')
        $('#SecPassG').removeClass('has-success')
        $('#firstPassG').removeClass('has-error')
        $('#SecPassG').removeClass('has-error')
    }
    else{
    $('#firstPassG').removeClass('has-success')
    $('#SecPassG').removeClass('has-success')
    $('#firstPassG').addClass('has-error')
    $('#SecPassG').addClass('has-error')

    }
    }
    else{
    $('#firstPassG').removeClass('has-success')
    $('#SecPassG').removeClass('has-success')
    $('#firstPassG').removeClass('has-error')
    $('#SecPassG').removeClass('has-error')

    }
})





})







</script>
<script src="http://127.0.0.1/cdn/jquery/jquery.easing.min.js"></script>
<script src="http://127.0.0.1/cdn/store-manage/multiStepForm.js"></script>
@endsection




@endsection