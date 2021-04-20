@extends("layout.nativeBase")

@section("title")

<title>{{ trans('lang.signUpViewTitle')  }} </title>
@endsection



@section('content')
<div class="container">

<!-- MultiStep Form -->
<div class="row">
    <div class="col-sm-offset-1 col-sm-10 col-xs-12">
        <form id="msform" class='form-horizontal' method="post">
            <!-- progressbar -->
            <ul id="progressbar">
                <li class="active" style="width:50%">{{ trans("lang.signUpField1Title")}}</li>
                <li style="width:50%;">{{ trans('lang.signUpField2Title') }}</li>
            </ul>
            <!-- fieldsets -->
            <fieldset>

                <h2 class="fs-title">{{ trans("lang.signUpField1Title") }}</h2>
                <br>
                <div class="form-group">
                <div class="col-sm-2"><label for="FullNameI" class="form-label">{{ trans("lang.formFullNameTitle") }}</label></div>
                <div class="col-sm-9"><input type="text" name="FullNameI" placeholder="{{ trans('lang.FormPlaceHolderFullName') }}" class="form-control" required></div>
                </div>
                <div class="form-group">
                    <div class="col-sm-2"><label for="PhoneI" class="form-label">{{ trans("lang.formPhoneNumTitle") }}</label></div>
                    <div class="col-sm-9"><input type="text" name="PhoneI" placeholder="{{ trans('lang.FormPlaceHolderPhone') }}" class="form-control" required></div>
                </div>
                <div class="form-group">
                    <div class="col-sm-2"><label for="AddressI" class="form-label">{{ trans("lang.formAddressTitle") }}</label></div>
                    <div class="col-sm-9"><input type="text" name="AddressI" placeholder="{{ trans('lang.FormPlaceHolderAddress') }}" class="form-control" required></div>
                </div>  

                <input type="button" name="next" class="next action-button btn btn-primary" value="{{ trans("lang.Next") }}"/>
            </fieldset>
            <fieldset>
                <h2 class="fs-title">{{ trans('lang.signUpField2Title')}}</h2>
                <br>
                <div class="form-group " id='emailCheckG'>
                    <div class="col-sm-2"><label for="EmailI" class="form-label">{{ trans("lang.formEmailTitle") }}</label></div>
                    <div class="col-sm-8"><input id='emailCheck' type="email" name="EmailI" placeholder="{{ trans('lang.FormPlaceHolderEmail') }}" class="form-control" required></div>
                    <span id='emailMessage'></span>
                   </div>
                <div class="form-group " id='UserCheckG'>
                    <div class="col-sm-2"><label for="UserNameI" class="form-label">{{ trans("lang.formUserNameTitle") }}</label></div>
                    <div class="col-sm-8"><input id='UserNameCheck' type="text" name="UserNameI" placeholder="{{ trans('lang.FormPlaceHolderUser') }}" class="form-control" required></div>
                    <span id='userNameMessage'></span>
                   </div>
                   <div class="form-group" id='firstPassG'>
                    <div class="col-sm-2"><label for="PasswordI" class="form-label">{{ trans("lang.formPaswordTitle") }}</label></div>
                    <div class="col-sm-8"><input type="password" name="PasswordI" placeholder="{{ trans('lang.FormPlaceHolderPass') }}" class="form-control" id='firstPass' required></div>
                   </div> 
                   <div class="form-group" id='SecPassG'>
                    <div class="col-sm-2"><label for="Passwor2I" class="form-label" >{{ trans("lang.formPasswordRTitle") }}</label></div>
                    <div class="col-sm-8"><input type="password" name="Passwor2I" placeholder="{{ trans('lang.FormPlaceHolderPassRp') }}" class="form-control" id='password2' required></div>
                   </div> 
                <input type="submit" value="{{ trans("lang.Register") }}"  class="btn btn-primary">
                <input type="button" name="previous" class="previous btn btn-danger" value="{{ trans('lang.Previous') }}"/>

            </fieldset>

            {{csrf_field()}}
        </form>
  



</div>
@section('script')
  
<script>

$(document).ready(function(){

$('#UserNameCheck').change(function(){
    var username= $('#UserNameCheck').val();
    if(username != '' && username.length >6){
     
        $.ajax({url:'http://127.0.0.1:8000/users/checkForm',
                method:"POST",
                data:{username:username,
                      _token:"{{ csrf_token()}}"
                },
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

  if(email != '' && email.length >10){
    $.ajax({url:'{{ route("CheckSignUp") }}',
            method:'POST',
            data:{email:email,
                _token:"{{ csrf_token()}}"
            },
            success:function(data){
             
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script> 
<script src="{{ url("inc/js/multiStepForm.js") }}"></script>
@endsection




@endsection