<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use PayPal\Api\Item;
use PayPal\Api\Payer;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Payment;
use PayPal\Api\ItemList;
use PayPal\Api\WebProfile;
use PayPal\Api\InputFields;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\PaymentExecution;


use App\StoreUser;
use App\Stores;
use App\StoreProduct;
use App\StoreCatigory;
use App\StoreEmployee;
use App\resTable;
use App\StorePic;
use App\StoreOrder;
use Auth;
use Stripe\Charge;
use Stripe\Stripe;





class DashboardController extends Controller
{


public function mainDashboard()
{
  $chekPlan=Auth::guard("StoreUsers")->user();
  $getUser=Auth::guard("StoreUsers")->user();
  $userId=$getUser["id"];

  //if No Plan activated redirect to Set Plan Route
  if($chekPlan['PlanType'] == "0"){
    
   return redirect()->route('SetPlan');  
  }
  else{

    $getStores=Stores::where("StoreUser",'=',$userId)->get();
    return view('Dashboard.main',['Stores'=>$getStores]);
  }

  
}


public function SetPlanGet()
{

$getUser=Auth::guard("StoreUsers")->user();

if($getUser['PlanType'] =="0"){

  return view("Dashboard.PlanView");

}
else{

  return redirect()->route("Dashboard");
}





}




public function PayStripe(Request $request)
{
 

  Stripe::setApiKey(config("app.StripeSecKey"));




if($request->get('planType') == "1"){
  $amount="30";
  $Days="30";
}
elseif($request->get('planType') == "2"){
$amount="60";
$Days="90";
}
elseif($request->get('planType') == "3"){
  $amount="120";
  $Days="270";
}
elseif($request->get('planType') == "4"){
  $amount="250";
  $Days="365";
}


  Charge::Create(array(
    "amount"=>$amount*100,
    "currency"=>"usd",
    "source"=>$request->get('token'),
    "description"=>"Payment Done :) "
    ));
  
    $getUser=Auth::guard("StoreUsers")->user();
    $userId=$getUser["id"];
    $getU=StoreUser::find($userId);
    $updatePlan=$getU->update(["PlanType"=>$request->get('planType'),"PlanDayLeft"=>$Days]);

    return response('success',200);



}




public function PayPayPal(Request $request)
{



//get Plan Type

$validate=$request->validate([
  "PlanType"=>"required",
]);


if($validate['PlanType'] =="1"){
   
  $PlanName="Basic";
  $PlanPrice=30;
}
elseif($validate['PlanType'] =="2"){

  $PlanName="Premium";
  $PlanPrice=60;
}
elseif($validate['PlanType'] =="3"){

  $PlanName="EnterPrice";
  $PlanPrice=120;
}
elseif($validate['PlanType']=="4"){

  $PlanName="Professional";
  $PlanPrice=250;

}


$apiContext = new \PayPal\Rest\ApiContext(
  new \PayPal\Auth\OAuthTokenCredential(
   config("app.PayPalId"),
   config("app.PayPalSeceret")
  )
);

$payer = new Payer();
$payer->setPaymentMethod("paypal");



$Plan = new Item();
$Plan->setName($PlanName)
    ->setCurrency('USD')
    ->setQuantity(1)
    ->setSku($validate['PlanType']) // Similar to `item_number` in Classic API
    ->setPrice($PlanPrice);

$itemList = new ItemList();
$itemList->setItems(array($Plan));



$amount = new Amount();
$amount->setCurrency("USD")
    ->setTotal($PlanPrice);


$transaction = new Transaction();
$transaction->setAmount($amount)
    ->setItemList($itemList)
    ->setDescription($PlanName . "Plan Payment")
    ->setInvoiceNumber(uniqid());

$redirectUrls = new RedirectUrls();
$redirectUrls->setReturnUrl(route("Dashboard"))
    ->setCancelUrl(route("SetPlan"));

// Add NO SHIPPING OPTION
$inputFields = new InputFields();
$inputFields->setNoShipping(1);

$webProfile = new WebProfile();
$webProfile->setName('test' . uniqid())->setInputFields($inputFields);

$webProfileId = $webProfile->create($apiContext)->getId();

$payment = new Payment();
$payment->setExperienceProfileId($webProfileId); // no shipping
$payment->setIntent("sale")
    ->setPayer($payer)
    ->setRedirectUrls($redirectUrls)
    ->setTransactions(array($transaction));

try {
    $payment->create($apiContext);
} catch (Exception $ex) {
    echo $ex;
    exit(1);
}

return $payment;

}




public function ExecPayment(Request $request)
{
  
  $apiContext = new \PayPal\Rest\ApiContext(
    new \PayPal\Auth\OAuthTokenCredential(
        'AdN894k0KvLi6iqmp4GJzE30bRNuXSlzkzt6FzD-Ee3gzVss15-V4uUhKb1Hc7WQi-slrWL4nUHChklx',     // ClientID
        'EGWsnPb15rEcVbrOaplbJuQhVV3S-soEFSVJNpCDEu5wrkRCOxKsusf8PsRXjL26ZeI3041tTdkNKOQc'      // ClientSecret
    )
);

$paymentId = $request->paymentID;
$payment = Payment::get($paymentId, $apiContext);

$execution = new PaymentExecution();
$execution->setPayerId($request->payerID);


try {
    $result = $payment->execute($execution, $apiContext);

//get Plan And Update User

$validate=$request->validate([
      "PlanType"=>"required"
      ]);




if($validate['PlanType'] =="1"){
   
  $PlanDays=30;

}
elseif($validate['PlanType'] =="2"){

  $PlanName="Premium";
  $PlanDays=90;
}
elseif($validate['PlanType'] =="3"){

  $PlanName="EnterPrice";
  $PlanDays=270;
}
elseif($validate['PlanType']=="4"){

  $PlanName="Professional";
  $PlanDays=365;

}

$getUser=Auth::guard("StoreUsers")->user();
$userId=$getUser["id"];

$findUser=StoreUser::find($userId);

$UpdateUser=$findUser->update([
  "PlanType"=>$validate['PlanType'],
  "PlanDayLeft"=>$PlanDays
]);


} catch (Exception $ex) {
    echo $ex;
    exit(1);
}


return response()->json("good", 200);


}





public function AddStorePost(Request $request)
{
 

 $getUser=Auth::guard("StoreUsers")->user();
 $userId=$getUser['id'];

 //set Plan Limit

 if($getUser['PlanType'] =="1"){

   $StoreLimit=1;
 }
 elseif($getUser['PlanType'] =="2"){
  
   $StoreLimit=2;
 }
 elseif($getUser['PlanType'] =="3"){
  
   $StoreLimit=4;
 }
 elseif($getUser['PlanType']=="4"){
 
 $StoreLimit=6;
 }

 //compare StoreLimit with count from DB
 $StoreCount=Stores::where("StoreUser",'=',$userId)->count();

 if($StoreCount < $StoreLimit){
  
   $getStores=Stores::where("StoreName","=",$request->input("StoreNameI"))->count();
 
   if($getStores == 1){
     return redirect()->route("Dashboard")->with('err',["err"=>"1","message"=>"StoreNameErr"]);
   }
   else{
    $saveStore=new Stores([
      "StoreName"=>$request->input("StoreNameI"),
      "StoreType"=>$request->input("StoreTypeI"),
      "StoreUser"=>$userId
    ]);
    $saveStore->save();
    return redirect()->route("Dashboard")->with('err',["err"=>"0","message"=>"StoreCreatedErr"]);
   }
 }
 else{
  return redirect()->route("Dashboard")->with('err',["err"=>"1","message"=>"PlanStoreErr"]);
 }
  
}




public function DelStoreGet()
{
 $getUser=Auth::guard("StoreUsers")->user();
 $userId=$getUser['id'];

 $getStores=Stores::where("StoreUser",'=',$userId)->get();

 return view("Dashboard.DelStore",['Stores'=>$getStores]);
}



public function DelStoreGet2($StoreId)
{

  $getStore=Stores::find($StoreId);
  //Delete everyThing related of That Store

  //DeleteProducts with Pic
  $getProducts=StoreProduct::where("ProdStoreId","=",$StoreId)->get();

  foreach($getProducts as $ProdId){
    //DeletePrducts Pics
  $getPic=StorePic::where([['id','=',$ProdId['ProdImg']],['id','!=','1']])->delete();
  $delProd=StoreProduct::find($ProdId['id'])->delete();
  }

  //DelOrdes
  $getOrders=StoreOrder::where("OrderStoreId","=",$StoreId)->delete();

  //DeleteCatigories
  $getCatigories=StoreCatigory::where("CatigoryStoreId",'=',$StoreId)->delete();

  //DeleteEmployees
  $getEmployee=StoreEmployee::where("EmployeeStoreId",'=',$StoreId)->delete();

  //Delete Tables if StoreType is resturant
  if($getStore['StoreType']=="restaurant"){
  
    $getTable=resTable::where("TableStoreId","=",$StoreId)->delete();

  }


  $getStore->delete();


  return redirect()->route("DelStore")->with('err',["err"=>"0","message"=>"StoreDeletedErr"]);

}
}
