<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerfMail;
use App\Mail\RestPass;
use Auth;
use App;
use App\User;
use App\StoreUser;
use App\StoreNotif;
use App\StorePayToken;


class UsersController extends Controller
{



  public function usersGet()
  {
    return redirect()->route('main',['lang'=>'ar']);
  }

  public function SignInGet()
  {
    if(!empty(Auth::guard("StoreUsers")->user())){
      return redirect()->route('Dashboard');
    }
    else{
      return view("SignIn");
         }
  }

  public function SignInPost(Request $request)
  {



    if(Auth::guard("StoreUsers")->attempt(
      array(
      'StoreUserName'=>$request->input("UserNameI"),
      'password'=>$request->input('PasswordI'),
      'UserStatus'=>"1"
      )
      )){
        $checkPlan=StoreUser::where('StoreUserName','=',$request->input('UserNameI'))->first();
        if($checkPlan['PlanType'] == 0){
           return redirect()->route('SetPlan');
        }else{
          return  redirect()->route('Dashboard');
        }
        
    }
    else
    {
    return redirect()->route("SignIn")->with("err",['err'=>'1','message'=>'SignInErr']);
    };
  }



public function SignUpGet()
{
  if(!empty(auth::guard("StoreUsers")->user())){
    return redirect()->route('Dashboard');
        }
    else{
      return view("signUpView");
    }                                 
}

public function SignUpPost(Request $request)
{


  //

//generate random verifection code
$validatonCode= md5(rand(1, 10) . microtime());

//

//back-end validation

$validate=$request->validate([

  "EmailI"=>"required",
  "UserNameI"=>"required",
  "PasswordI"=>"required",
  "FullNameI"=>"required",
  "AddressI"=>"required",
]);
$uniqueUserName=StoreUser::Where('StoreUserName','=',$request->input("UserNameI"));

if($uniqueUserName->count() ==1){

  return view("signUpView")->with(['err'=>'1','message'=>"SignUpUserNameErr"]);
}


$uniqueEmail=StoreUser::where('StoreEmail','=',$request->input("EmailI"));

if($uniqueEmail->count() ==1){

  return view("signUpView")->with("err",['err'=>'1','message'=>"SignUpUserNameErr"]);
}

if($request->input("PasswordI") != $request->input("Passwor2I")){
  return view("signUpView")->with("err",['err'=>'1','message'=>"كلمات السر غير متطابقة"]);
}

//

// save user to db
$saveUser= new StoreUser([
  "StoreEmail"=>$validate["EmailI"],
  "StoreUserName"=>$validate["UserNameI"],
  "StorePassword"=>bcrypt($validate["PasswordI"]),
  "StoreFullName"=>$validate["FullNameI"],
  "StoreAddress"=>$validate["AddressI"],
  "PlanType"=>0,
  "PlanDayLeft"=>0,
  "validationToken"=>$validatonCode,
  "UserStatus"=>0
]);

  $saveUser->save();
//

//send verfection email to email user (when user verfected the UserStatus will be 1)
$verf=$validatonCode;
Mail::to($validate["EmailI"])->send(new VerfMail($verf));

//
return redirect()->route('SignIn')->with("err",['err'=>"0","message"=>"MailAcSended"]);

}

public function chekFormPost( Request $request)
{

  //get lang
  $lang=session()->get('locale');

  if($lang == "ar"){
    $usernameMessage="عذرا اسم المستخدم موجود بالفعل";
    $usernameAvail="اسم المستخدم متاح";
    $emailMessage="عذرا الايميل مستخدم بالفعل";
    $emailAvail="الايميل متاح";
  }
  elseif($lang =="en"){
    $usernameMessage="Sorry, User Name Is Already Exists";
    $usernameAvail="User Name Is Available";
    $emailMessage="Sorry, Email Is Already Exists";
    $emailAvail="Email Is Available";
  }




  if(!empty($request->get('email'))){

  $validate=$request->validate([
    "email"=>"required|min:8",
  ]);

  $checkEmail=StoreUser::where('Storeemail','=',$validate['email'])->get();
  if($checkEmail->count() == 1){
   return response()->json(["err"=>"1",'message'=>$emailMessage], 200);
  }
  else{
  return response()->json(['err'=>"0","message"=>$emailAvail],200);
  }
  }

  if(!empty($request->get('username'))){
    $validate=$request->validate([
      "username"=>"required|min:6",
    ]);
    $checkUserName=StoreUser::where('StoreUserName','=',$validate['username'])->get();
    if($checkUserName->count() == 1){
      return response()->json(['err'=>'1','message'=>$usernameMessage], 200);
    }
    else{
      return response()->json(['err'=>"0","message"=>$usernameAvail],200);
    }
  }
}



public function ActivateGet($token)
{
  

// find User Have the Token And Change UserStatus To 1 (Activated)

$getUser=StoreUser::where('validationToken','=',$token)->first();


if($getUser['UserStatus'] =="0"){

  $update=$getUser->update([
    "UserStatus"=>"1"
  ]);
  return redirect()->route("SignIn")->with("err",['err'=>"0","message"=>"AccountActivatedErr"]);
}
else{
  return redirect()->route("SignIn")->with("err",['err'=>"1","message"=>"SW"]);
}
}




public function RestPassGet()
{
  

return view("RestPass");

}



public function RestPassPost(Request $request)
{
  
  $validate=$request->validate([
  "RestEmail"=>"required"
  ]);
//find email and send Rest Email To It

$getUser=StoreUser::where("StoreEmail","=",$validate['RestEmail'])->first();

if(!empty($getUser)){

//send Password Mail
 $UserToken=$getUser['validationToken'];
 Mail::to($validate["RestEmail"])->send(new RestPass($UserToken));
}
return redirect()->route("SignIn")->with("err",['err'=>'0','message'=>'MailSendedErr']);

}


public function RestPassNew($token)
{
  
 return view("NewRestPass");

}

public function RestPassNewP(Request $request,$token)
{
 
  
$getUser=StoreUser::where("validationToken","=",$token)->first();

if(!empty($getUser)){
//validate Inputs
  $validate=$request->validate([
    "NewPass"=>"required|confirmed",
  ]);

  //update Passworrd

  $getUser->update(['password'=>bcrypt($validate['NewPass'])]);

  return redirect()->route("SignIn")->with("err",["err"=>"0","message"=>"PasswordRestedErr"]);


}
else{

  return redirect()->route("main",["lang"=>session()->get('locale')])->with("err",["err"=>"1","message"=>"SW"]);
}
}



public function UpdateGet()
{
  
  $getUser=Auth::guard("StoreUsers")->User();

  $getApi=StorePayToken::where("UserId",$getUser['id'])->first();
  if(!empty($getApi)){
  $getkey=$getApi;
  }
  else{
    $getkey=["ApiPub"=>null,"ApiSeceret"=>null];
  }
  return view("UpdateUser",['User'=>$getUser,"ApiKey"=>$getkey]);  
}

public function UpdateUserPost(Request $request)
{

  //validate Inputs
  $validate=$request->validate([
    "FullNameI"=>"required",
    "UserNameI"=>"required",
    "AddressI"=>"required",
    "EmailI"=>"required",
    "UserId"=>"required",
    "PasswordI"=>"required",
    "Password2I"=>"required"
  ]);

  if($validate['PasswordI'] != $validate['Password2I']){
  return redirect()->route("UpdateUser")->with("err",["err"=>"1","message"=>"Password not match"]);
  }

   //Check Password
   $CheckPassword=StoreUser::where([["StorePassword",$validate['Password2I'],['id',$validate['UserId']]]])->first();

   


  //get User
  $getUser=StoreUser::find($validate['UserId']);
  if(!empty($getUser)){

    //Update User
    $UpdateUser=$getUser->update([
      "StoreFullName"=>$validate['FullNameI'],
      "StoreUserName"=>$validate['UserNameI'],
      "StoreAddress"=>$validate['AddressI'],
      "StoreEmail"=>$validate['EmailI'],
    ]);
    return redirect()->route("UpdateUser")->with("err",['err'=>"0","message"=>"User Updated Successully"]);
  }
  
  
  
  


}


public function UpdateNotif()
{

$getUser=Auth::guard("StoreUsers")->user();
$userId=$getUser['id'];
$getNotifs=StoreNotif::where("UserId",$userId)->get();

foreach ($getNotifs as $notif){
  $UpdateNotifs=$notif->update([
    "NotifStatus"=>"1"
  ]);
};
return response(200);

}


  public function LogOut()
  {
      Auth::logout();
      return redirect()->route('SignIn');
  }


public function SetApiPost(Request $request)
{


//validate Inputs
$validate=$request->validate([
  "ApiPublish"=>"required",
  "ApiSecret"=>"required"
]);

 //if No Old Api Save The NEw Key

 $getUser=Auth::guard("StoreUsers")->User();
 $UserId=$getUser['id'];

 $StoreKey=StorePayToken::where("UserId",$UserId)->first();

 if(!empty($StoreKey)){

  $UpdateKey=$StoreKey->update([
    "ApiSeceret"=>$validate['ApiSecret'],
    "ApiPub"=>$validate['ApiPublish']
  ]);
  return redirect()->route("UpdateUser")->with("err",['err'=>"0","message"=>"ApiKeysUpdated"]);
 }
 else{
 
  $SaveKey=new StorePayToken([
    "ApiSeceret"=>$validate['ApiSecret'],
    "ApiPub"=>$validate['ApiPublish'],
    "UserId"=>$UserId
  ]);
  $SaveKey->save();

  return redirect()->route("UpdateUser")->with("err",['err'=>"0","message"=>"ApiKeysSaved"]);
 }
}



}
