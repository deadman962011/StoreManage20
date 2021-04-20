<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\carbon;
use Session;
use Stripe\Charge;
use Stripe\Stripe;

use App\Stores;
use App\StoreCatigory;
use App\StoreProduct;
use App\StorePic;
use App\StoreEmployee;
use App\ResTable;
use App\StoreOrder;
use App\Item;
use App\StoreRepo;
use App\StoreRepProds;
use App\StorePayToken;
use App\StoreNotif;
use App\StoreReport;

use Auth;

class StoresController extends Controller
{
    //




public function StoremainGet($StoreType,$StoreId)
{

//get user
$getUser=Auth::guard("StoreUsers")->user();
$userId=$getUser['id'];

//params validation
 if(!empty($StoreId)){

 $monthChartAr=array();
 $getStores=Stores::where([["id",'=',$StoreId],["StoreType","=",$StoreType],["StoreUser",'=',$userId]])->count();
 //Get Product Count
 $ProdCount=StoreProduct::where("ProdStoreId","=",$StoreId)->count();
 
 //get DailyIncome And ORderNum 
$getOrders=StoreOrder::where([["OrderStoreId",$StoreId],['OrderStatus','success']])->whereDay("created_at",carbon::now()->day)->whereMonth("created_at",carbon::now()->month)->whereYear("created_at",carbon::now()->year);
 $OrderCount=$getOrders->count();
 $getIncome=$getOrders->sum("OrderPrice");
  
 if($getStores === 1){
  
    return view("Store.mainStore",['StoreType'=>$StoreType,'StoreId'=>$StoreId,"ProdCount"=>$ProdCount,"DayIncome"=>$getIncome,"OrdersCount"=>$OrderCount]);

 }
 else{
    return abort(404);
 }
 }
}


public function StormainPost(Request $request,$StoreType,$StoreId)
{


 //get Orders and group them by month
 $monthArr=array();
 $dateOrders=StoreOrder::where("OrderStoreId",$StoreId)->orderBy('created_at','ASC')->pluck('created_at');
 $dateOrders=json_decode($dateOrders);
 if(!empty($dateOrders)){
 
    foreach( $dateOrders as $UnfDate){
        $date=new \DateTime($UnfDate);
        $monthNa=$date->format( "M" );
        $monthNo=$date->format( "m" );
        $monthArr[ $monthNo ] = $monthNa; 
    }
 }
//get Orders Count By Months
     
 if(!empty($monthArr)){
    $OrdersCountArr=array();
    $monthNameArr=array();
    foreach ($monthArr as $monthNo => $monthNa) {
        $OrdersCount=StoreOrder::where("OrderStoreId",$StoreId)->WhereMonth("created_at",$monthNo)->count();
        array_push( $OrdersCountArr,$OrdersCount );
        array_push($monthNameArr,$monthNa);
    }
 }
 //max num Of Orders

 if(!empty($OrdersCountArr)){
    $maxOrders=max( $OrdersCountArr);
    $maxOrders=round(($maxOrders + 10/2) /10)*10;
 }

 //month Chart array
 if(!empty($monthNameArr) && !empty($OrdersCountArr) && !empty($maxOrders)){
    $monthChartAr=array(
        "months"=>$monthNameArr,
        "Orders"=>$OrdersCountArr,
        "MaxOrders"=>$maxOrders
    );
}
    else{
        $monthChartAr=array(
            "months"=>["Today"],
            "Orders"=>[0],
            "MaxOrders"=>10
        );
    }



//Pae Chart 

//get Orders And Count Them them By Payment Way
$getOredersPaeC=StoreOrder::where([["OrderStoreId",$StoreId],["OrderPayment","Cash"]])->count();
$getOredersPaeCC=StoreOrder::where([["OrderStoreId",$StoreId],["OrderPayment","CreditCard"]])->count();
$getOredersPaeD=StoreOrder::where([["OrderStoreId",$StoreId],["OrderPayment","CashOnDelivery"]])->count();

$monthChartPae=array(
    "PaymentWay"=>[$getOredersPaeC,$getOredersPaeCC,$getOredersPaeD]
);

 //get Orders and group them by Days
 $DayArr=array();
 $DayOrder=StoreOrder::where("OrderStoreId",$StoreId)->orderBy('created_at','ASC')->pluck('created_at');
 $DayOrder=json_decode($DayOrder);
 if(!empty($DayOrder)){
 
    foreach( $DayOrder as $UnfDateD){
        $date=new \DateTime($UnfDateD);
        $DayNa=$date->format( "D" );
        $DayNo=$date->format( "d" );
        $DayArr[ $DayNo ] = $DayNa; 
    }
 }
//get Orders Count By Months
     
 if(!empty($DayArr)){
    $OrdersCountArrD=array();
    $DayNameArrD=array();
    foreach ($DayArr as $DayNo => $DayNa) {
        $OrdersCountD=StoreOrder::where("OrderStoreId",$StoreId)->WhereMonth("created_at",carbon::now()->month)->WhereDay("created_at",$DayNo)->count();
        array_push( $OrdersCountArrD,$OrdersCountD );
        array_push($DayNameArrD,$DayNa);
    }
 }
 //max num Of Orders

 if(!empty($OrdersCountArrD)){
    $maxOrdersD=max( $OrdersCountArrD);
    $maxOrdersD=round(($maxOrdersD + 10/2) /10)*10;
 }

 //month Chart array
 if(!empty($DayNameArrD) && !empty($OrdersCountArrD) && !empty($maxOrdersD)){
    $DayChartArr=array(
        "Days"=>$DayNameArrD,
        "Orders"=>$OrdersCountArrD,
        "MaxOrders"=>$maxOrdersD
    );
}
    else{
        $DayChartArr=array(
            "Days"=>["Today"],
            "Orders"=>[0],
            "MaxOrders"=>10
        );
    }

  
return response()->json(["AreaChart"=>$monthChartAr,"DayChart"=>$DayChartArr,"PaeChart"=>$monthChartPae], 200);

}







public function PosGet($StoreType,$StoreId)
{


   $CartName="cart".$StoreId;
   $DelCart=Session::has($CartName) ? Session::forget($CartName) :Session::forget($CartName);

   $getCatigory=StoreCatigory::where("CatigoryStoreId","=",$StoreId)->get();
   $getProducts=StoreProduct::where("ProdStoreId",'=',$StoreId)->get();
   $withProds=$getCatigory->load("Products");
   //get delivery employees
   $getEmployee=StoreEmployee::where([["EmployeeStoreId",'=',$StoreId],["EmployeeType",'=','Delivery']])->get();
   //get available Tabls
   $getTables=ResTable::where([['TableStoreId','=',$StoreId],['TableStatus','=','Available']])->get();
   //get ready Orders
   $getReadyOrders=StoreOrder::where([['OrderStoreId','=',$StoreId],['OrderStatus','=',"Done"]])->get();
   $transformReadyOrder= $getReadyOrders->transform(function($order){ 
    $order->OrderCart=unserialize($order->OrderCart);
    return $order;  
  });
  $transformReadyOrderInf= $getReadyOrders->transform(function($order2){ 
    $order2->OrderInf=unserialize($order2->OrderInf);
    return $order2;  
  });

  //get Casher Employees
  $getCasher=StoreEmployee::where([["EmployeeStoreId",'=',$StoreId],['EmployeeType','=','Casher']])->get();
  //
 
  $getUser=Auth::guard("StoreUsers")->user();
  $getUserId=$getUser['id'];

  //get Payment Api Key
  $getKey=StorePayToken::where("UserId","=", $getUserId)->first();
  //
   
//    $oldCart=Session::get('cart');
//    $getCart=new Item($oldCart);
//    $products=$getCart->items;
//    $totalQty=$getCart->totalQty;
//    $totalPrice=$getCart->totalPrice;

    if($StoreType == "restaurant"){
        //return $withProds;
        
        return view("Store.resturant.PosResturant",['StoreType'=>$StoreType,'StoreId'=>$StoreId,"Catigories"=>$withProds,"AllProduct"=>$getProducts,'Employee'=>$getEmployee,'Tables'=>$getTables,'readyOrders'=>$transformReadyOrderInf,'getCasher'=>$getCasher,'ApiKey'=>$getKey]);
    }
    else{

        return view("Store.StorePos ",['StoreType'=>$StoreType,'StoreId'=>$StoreId,"Catigories"=>$withProds,"AllProduct"=>$getProducts,'Employee'=>$getEmployee,'readyOrders'=>$transformReadyOrder,'getCasher'=>$getCasher,'ApiKey'=>$getKey]);
    }

}


public function SalesGet($StoreType,$StoreId)
{


    //get orders
   
    $getOrders=StoreOrder::where("OrderStoreId","=",$StoreId)->get();

    
    return view("Store.Sales",['StoreType'=>$StoreType,'StoreId'=>$StoreId,'Orders'=>$getOrders]);
}




public function ProductGet($StoreType,$StoreId)
{

    $getCatigory=StoreCatigory::where('CatigoryStoreId','=',$StoreId)->get();
    $getProducts=StoreProduct::where("ProdStoreId",'=',$StoreId)->get();
    $withCatigory=$getProducts->load("Catigory");
    $whithPic=$withCatigory->load("Image");
    $getTime=now();
    

    return view("Store.Product",['StoreType'=>$StoreType,'StoreId'=>$StoreId,"Catigories"=>$getCatigory,"Products"=>$whithPic,"now"=>$getTime]);
}





public function AddProdPost(Request $request,$StoreType,$StoreId)
{
    $getUser=Auth::guard("StoreUsers")->user();
    //set Plan Limit
   
    if($getUser['PlanType'] =="1"){
   
      $ProdLimit=24;
    }
    elseif($getUser['PlanType'] =="2"){
     
      $ProdLimit=36;
    }
    elseif($getUser['PlanType'] =="3"){
     
      $ProdLimit=72;
    }
    elseif($getUser['PlanType']=="4"){
    
    $ProdLimit=160;
    }

     //compare StoreLimit with count from DB

     $ProductsCount=StoreProduct::where("ProdStoreId","=",$StoreId)->count();

     if($ProductsCount < $ProdLimit){
         
           //validate Inputs
           $validate=$request->validate([
            "ProdNameI"=>"required",
            "ProdCatigoryI"=>"required",
            "ProdPriceI"=>"required",
            "ProdImgI"=>"image|nullable|max:1999"
            ]);
 
             //Upload image for the Product
              
             if($request->hasFile("ProdImgI")){
                 $ProdImg=$request->file("ProdImgI");
                 
              $fileExt=$ProdImg->getClientOriginalName();
  
              $fileName=pathinfo($fileExt, PATHINFO_FILENAME);
  
              $fileExt=$request->file("ProdImgI")->getClientOriginalExtension();
              
              $fileToStore=$fileName.'_'.time().'.'.$fileExt;
  
              $UploadPath=$request->file("ProdImgI")->StoreAs("public/Products",$fileToStore);
             
              //save Uploaded file to DB
  
              //save file info"s
              $saveFile=new StorePic([
                "PicSource"=>$fileToStore,
                          ]);
              $savedFile=$saveFile->save();
              $getImage=$saveFile['id'];
             }
             else{
                 $getImage="1";
             }
 
      
 
      $saveProd=new StoreProduct([
           'ProdName'=>$request->input("ProdNameI"),
           'ProdCatigory'=>$request->input("ProdCatigoryI"),
           'ProdPrice'=>$request->input("ProdPriceI"),
           'ProdImg'=>$getImage,
           'ProdStoreId'=>$StoreId
                             ]);
      $savedProd=$saveProd->save();
                  
            //get old catigory ProdsNum
            $getCatigory=StoreCatigory::find($request->input("ProdCatigoryI"));
            $oldProdNum=$getCatigory['CatigoryProdsNum'];
 
            //update catigory Porducts Num
             $updateCatigory=$getCatigory->update(["CatigoryProdsNum"=>$oldProdNum+1]);
 
             
            ///Add new notifcation
            $getUser=Auth::guard("StoreUsers")->user();

            $UserId=$getUser['id'];
            $NotifValue="Product ".$saveProd["ProdName"] ." Saved";

            $saveNotif=new StoreNotif([
                "UserId"=>$UserId,
                "NotifStatus"=>"0",
                "NotifValue"=>$NotifValue
            ]);

            $saveNotif->save();

              return redirect()->route("Products",['StoreType'=>$StoreType,'StoreId'=>$StoreId])->with("err",['err'=>"0",'message'=>"ProductCreatedErr"]);
     }
     else{
        return redirect()->route("Products",['StoreType'=>$StoreType,'StoreId'=>$StoreId])->with("err",['err'=>"1",'message'=>"PlanProdErr"]);
     }
 }


public function DelProdGet ($StoreType,$StoreId,$ProdId)
{

    //find Product
    $getProd=StoreProduct::find($ProdId);


    //Delete Picture for the Product if have no deault value

     if($getProd->ProdImg !=="1"){
    
        // product Not using the default Pic so we should delete Them
        
        $getImg=StorePic::find($getProd->ProdImg);

         $delImg=$getImg->delete();

        //delete PIC from storage

        Storage::delete('/public/products/'.$getImg->PicSource);

     }

    //decrease Catigory Product count -1
    $getCatigoryId=$getProd->ProdCatigory;
     
    $getCatigory=StoreCatigory::find($getCatigoryId);

    $decrase1=$getCatigory->update(["CatigoryProdsNum"=>$getCatigory->CatigoryProdsNum-1]);


    //delete Selected Product
    $delProd=$getProd->delete();


        ///Add new notifcation
        $getUser=Auth::guard("StoreUsers")->user();
        $UserId=$getUser['id'];
        $NotifValue="Product ".$delProd["ProdName"] ." Deleted";
        $saveNotif=new StoreNotif([
            "UserId"=>$UserId,
            "NotifStatus"=>"0",
            "NotifValue"=>$NotifValue
        ]);
        $saveNotif->save();
        

   return redirect()->route("Products",['StoreType'=>$StoreType,'StoreId'=>$StoreId])->with("err",['err'=>"0",'message'=>"ProdDeletedErr"]);

}


public function UpdateProdG(Request $request,$StoreType,$StoreId)
{
    // validate inputs
    $validate=$request->validate([
        "ProdId"=>"required"
    ]);
    
    $getProduct=StoreProduct::find($validate['ProdId']);
    if(!empty($getProduct)){
        return $getProduct;
    }
    else{
        return response(404);
    }
}



public function UpdateProd(Request $request,$StoreType,$StoreId)
{

    //validate Inputs And Get Catigory
    $validate=$request->validate([
        "ProdNameUPI"=>"required",
        "ProdIdUpI"=>"required",
        "ProdCatigoryUPI"=>"required",
        "ProdPriceUPI"=>"required"
    ]);

    $getProd=StoreProduct::find($validate['ProdIdUpI']);

    if(!empty($getProd)){
      //get Old Catigory And reduce Products Num by 1
      $oldCatigory=$getProd['ProdCatigory'];
      $getOldCatigory=StoreCatigory::find($oldCatigory);
      $UpdateOldCatigory=$getOldCatigory->update([
          "CatigoryProdsNum"=>$getOldCatigory['CatigoryProdsNum']-1
      ]);

      //increase by 1  Prods Num for new Catigory
      $newCat=StoreCatigory::find($validate["ProdCatigoryUPI"]);
      if(!empty($newCat)){
      
      $newCatUpdate=$newCat->update([
        "CatigoryProdsNum"=>$newCat['CatigoryProdsNum']+1
      ]); 
      }
      
        
      //update Pic 
    if($request->hasFile("ProdPreviewUPI")){

        //Upload NEw Pic
     
  
      $ProdImg=$request->file("ProdPreviewUPI");
          
       $fileExt=$ProdImg->getClientOriginalName();
  
       $fileName=pathinfo($fileExt, PATHINFO_FILENAME);
  
       $fileExt=$request->file("ProdPreviewUPI")->getClientOriginalExtension();
       
       $fileToStore=$fileName.'_'.time().'.'.$fileExt;
  
       $UploadPath=$request->file("ProdPreviewUPI")->StoreAs("public/Products",$fileToStore);
      
       //save Uploaded file to DB
  
       //save file info"s
       $saveFile=new StorePic([
         "PicSource"=>$fileToStore,
                   ]);
       $savedFile=$saveFile->save();
  
      //get New Pic Id
       $getImage=$saveFile['id'];
  
      //get And Delete Old Pic if Not default Pic
  
      $OldPic=$getProd['ProdImg'];
      $delOldPic=StorePic::find($OldPic);
      if($delOldPic['id'] != "1"){
  
          $delOldPic->delete();
      }

      }
      else{
        $getImage=$getProd['ProdImg'];
         }

        //update Product
        $UpdateProd=$getProd->update([
        "ProdName"=>$validate['ProdNameUPI'],
        "ProdCatigory"=>$validate['ProdCatigoryUPI'],
        "ProdPrice"=>$validate['ProdPriceUPI'],
        "ProdImg"=>$getImage
    ]);

        ///Add new notifcation
        $getUser=Auth::guard("StoreUsers")->user();
        $UserId=$getUser['id'];
        $NotifValue="Table ".$UpdateProd["ProdName"] ." Updated";
        $saveNotif=new StoreNotif([
            "UserId"=>$UserId,
            "NotifStatus"=>"0",
            "NotifValue"=>$NotifValue
        ]);
        $saveNotif->save();
        
    return redirect()->route("Products",['StoreType'=>$StoreType,'StoreId'=>$StoreId])->with("err",['err'=>"0","message"=>"ProdUpdatedErr"]);
    }
      else{
          return redirect()->route("Products",['StoreType'=>$StoreType,'StoreId'=>$StoreId])->with("err",['err'=>'1','message'=>'SW']);
      }
    
}








public function CatigoryGet($StoreType,$StoreId)
{


    //get all catigories
    
    $getCatigory=StoreCatigory::where("CatigoryStoreId","=",$StoreId)->get();
    $getTime=now();

    return view("Store.Catigory",['StoreType'=>$StoreType,'StoreId'=>$StoreId,"Catigories"=>$getCatigory,"now"=>$getTime]);
}


public function AddCatigoryPost(Request $request,$StoreType,$StoreId)
{

   $checkCatigory=StoreCatigory::where([['CatigoryStoreId','=',$StoreId],['CatigoryName','=',$request->input("CatigoryNameI")]])->count();
   if($checkCatigory =="1"){
       return  redirect()->route('Catigories',['StoreType'=>$StoreType,'StoreId'=>$StoreId])->with("err",["err"=>"1","message"=>"CatigoryExsistErr"]);
   }
   else{


    $getUser=Auth::guard("StoreUsers")->user();
    //set Plan Limit
   
    if($getUser['PlanType'] =="1"){
   
      $CatigoryLimit=6;
    }
    elseif($getUser['PlanType'] =="2"){
     
      $CatigoryLimit=12;
    }
    elseif($getUser['PlanType'] =="3"){
     
      $CatigoryLimit=24;
    }
    elseif($getUser['PlanType']=="4"){
    
    $CatigoryLimit=50;
    }

    //compare CAtigory limit and CAtigory Count

    $CountCatigory=StoreCatigory::Where("CatigoryStoreId","=",$StoreId)->count();

    if($CountCatigory < $CatigoryLimit){
        $addCatiogry=new StoreCatigory([
            'CatigoryName'=>$request->input("CatigoryNameI"),
            'CatigoryProdsNum'=>0,
            'CatigoryStoreId'=>$StoreId
        ]);
        $addCatiogry->save();



        ///Add new notifcation
        $getUser=Auth::guard("StoreUsers")->user();

        $UserId=$getUser['id'];
        $NotifValue="Catigory ".$addCatiogry["CatigoryName"] ." Saved";

        $saveNotif=new StoreNotif([
            "UserId"=>$UserId,
            "NotifStatus"=>"0",
            "NotifValue"=>$NotifValue
        ]);

        $saveNotif->save();

        return  redirect()->route('Catigories',['StoreType'=>$StoreType,'StoreId'=>$StoreId])->with("err",["err"=>"0","message"=>"CatigoryCreatedErr"]);
    }
    else{
        return  redirect()->route('Catigories',['StoreType'=>$StoreType,'StoreId'=>$StoreId])->with("err",["err"=>"1","message"=>"PlanCatigoryErr"]);
    }
   }
}


public function DelCatigory(Request $request,$StoreType,$StoreId,$CatId)
{

    //delete all Products in selected catigory
     $getProducts=StoreProduct::where("ProdCatigory","=",$CatId)->get();

     foreach( $getProducts as $Prod){
         $delProds=StoreProduct::find($Prod['id']);
         $delProds->delete();
     };

    //delete catigory
    $getCatigory=StoreCatigory::find($CatId);

    $delCatigory=$getCatigory->delete();

        ///Add new notifcation
       $getUser=Auth::guard("StoreUsers")->user();
        $UserId=$getUser['id'];
        $NotifValue="Employee ".$delCatigory["CatigoryName"] ." Delted";
    
        $saveNotif=new StoreNotif([
            "UserId"=>$UserId,
            "NotifStatus"=>"0",
            "NotifValue"=>$NotifValue
        ]);
    
        $saveNotif->save();

    return  redirect()->route('Catigories',['StoreType'=>$StoreType,'StoreId'=>$StoreId])->with("err",["err"=>"0","message"=>"CatigoryDeletedErr"]);
}





public function EmployeeGet($StoreType,$StoreId)
{


    $getEmployees=StoreEmployee::where("EmployeeStoreId","=",$StoreId)->get();
    return view("Store.Employee",['StoreType'=>$StoreType,'StoreId'=>$StoreId,'employees'=>$getEmployees]);
}


public function AddEmployee(Request $request,$StoreType,$StoreId)
{


    $getUser=Auth::guard("StoreUsers")->user();
    //set Plan Limit
   
    if($getUser['PlanType'] =="1"){
   
      $EmployeeLimit=4;
    }
    elseif($getUser['PlanType'] =="2"){
     
      $EmployeeLimit=8;
    }
    elseif($getUser['PlanType'] =="3"){
     
      $EmployeeLimit=16;
    }
    elseif($getUser['PlanType']=="4"){
    
    $EmployeeLimit=35;
    }

    //Compare Employee Limit and Employes Count
    $CountEmp=StoreEmployee::where('EmployeeStoreId','=',$StoreId)->count();

    if($CountEmp < $EmployeeLimit){


    //validate Inputs
    $validate=$request->validate([
        "EmpNameI"=>"required",
        "EmpAgeI"=>"required",
        "EmpGenderI"=>"required",
        "EmpMaritalStatusI"=>"required",
        "EmpTypeI"=>"required",
        "EmpFeeI"=>"required"
    ]);
    //add new Employee
    $saveEmp=new StoreEmployee([
     
    "EmployeeName"=>$validate['EmpNameI'],
    "EmployeeAge"=>$validate['EmpAgeI'],
    "EmployeeGender"=>$validate['EmpGenderI'],
    "EmployeeStatus"=>0,
    "EmployeeFee"=>$validate['EmpFeeI'],
    "EmployeeDP"=>0,
    "EmployeeMS"=>$validate['EmpMaritalStatusI'],
    "EmployeeType"=>$validate['EmpTypeI'],
    "EmployeeStoreId"=>$StoreId
    ]);
    $saveEmp->save();

    ///Add new notifcation

    $UserId=$getUser['id'];
    $NotifValue="Employee ".$saveEmp["EmployeeName"] ." Saved";

    $saveNotif=new StoreNotif([
        "UserId"=>$UserId,
        "NotifStatus"=>"0",
        "NotifValue"=>$NotifValue
    ]);

    $saveNotif->save();

        return  redirect()->route('Employee',["StoreType"=>$StoreType,"StoreId"=>$StoreId])->with("err",['err' => '0',"message"=>"EmployeeCreatedErr"]);
    }
    else{
        return  redirect()->route('Employee',["StoreType"=>$StoreType,"StoreId"=>$StoreId])->with("err",['err' => '1',"message"=>"PlanEmployeeErr"]);
    }


}


public function DelEmployee($StoreType,$StoreId,$EmpId)
{

//find Employee

$getEmployee=StoreEmployee::find($EmpId);

$delEmployee=$getEmployee->delete();

        ///Add new notifcation
        $getUser=Auth::guard("StoreUsers")->user();
        $UserId=$getUser['id'];
        $NotifValue="Product ".$delEmployee["EnployeeName"] ." Deleted";
        $saveNotif=new StoreNotif([
            "UserId"=>$UserId,
            "NotifStatus"=>"0",
            "NotifValue"=>$NotifValue
        ]);
        $saveNotif->save();

  return redirect()->route('Employee',["StoreType"=>$StoreType,"StoreId"=>$StoreId])->with(['err'=>0,'message'=>'EmployeeDeletedErr']);
}



public function TableGet($StoreType,$StoreId)
{
    
  //get all tables

  $getTables=ResTable::where("TableStoreId","=",$StoreId)->get();

    return view("Store.resturant.Tables",["StoreType"=>$StoreType,"StoreId"=>$StoreId,"Tables"=>$getTables]);

}


public function TablePost(Request $request,$StoreType,$StoreId)
{

    //validate inputs
    $validate=$request->validate([
        "TableNameI"=>"required",
        "TableSeatI"=>"required",
        "TableStatusI"=>"required",
    ]);


    // save Table
    $saveTable=new ResTable([
        "TableName"=>$validate['TableNameI'],
        "TableMaxSeat"=>$validate['TableSeatI'],
        "TableStatus"=>$validate['TableStatusI'],
        "TableStoreId"=>$StoreId
    ]);
    $saveTable->save();

    ///Add new notifcation
    $getUser=Auth::guard("StoreUsers")->user();
    $UserId=$getUser['id'];
    $NotifValue="Table ".$saveTable["TableName"] ." Saved";
    $saveNotif=new StoreNotif([
        "UserId"=>$UserId,
        "NotifStatus"=>"0",
        "NotifValue"=>$NotifValue
    ]);
    $saveNotif->save();
    

    return redirect()->route("Tables",["StoreType"=>$StoreType,"StoreId"=>$StoreId])->with("err",["err"=>"0","message"=>"TableCreated"]);
}




public function DelTable($StoreType,$StoreId,$TableId)
{
  

//get Table
$getTable=ResTable::find($TableId);


//deleted selected table

$getTable->delete();

return redirect()->route("Tables",["StoreType"=>$StoreType,"StoreId"=>$StoreId])->with(['err'=>'0','message'=>'TableDeletedErr']);
}



public function UpdateTable(Request $request,$StoreType,$StoreId)
{

    // validate Inputs 
    $validate=$request->validate([
        "TableNameUpI"=>"required",
        "TableStausUpI"=>"required",
        "TableMaxSeatUpI"=>"required",
        "TableId"=>"required"
    ]);

    //get TAble
    $getTable=resTable::find($validate["TableId"]);

    if(!empty($getTable)){
    //update Table
    
     $UpdateTable=$getTable->update([
         "TableName"=>$validate['TableNameUpI'],
         "TableMaxSeat"=>$validate['TableMaxSeatUpI'],
         "TableStatus"=>$validate['TableStausUpI'],
     ]);
     return redirect()->route("Tables",['StoreType'=>$StoreType,'StoreId'=>$StoreId])->with("err",['err'=>"0","message"=>"TableUpdatedErr"]);
    }
    else{
        return redirect()->route("Tables",['StoreType'=>$StoreType,'StoreId'=>$StoreId])->with("err",['err'=>"1","message"=>"SW"]);
    }
}


public function getTable(Request $request)
{
    //validate inputs
    $validate=$request->validate([
        "TableId"=>"required"
    ]);
    //get Table By ID
    $getTable=resTable::find($validate['TableId']);
    if(!empty($getTable)){
       return  response()->json($getTable, 200);
    }
}


public function KitchenMain($StoreType,$StoreId)
{

    //get All Orders where status is Kitchen
    $getOrders=StoreOrder::where([["OrderStoreId",'=',$StoreId],['OrderStatus','=','Kitchen']])->get();
    $transFormOrder=$getOrders->transform(function($order){ 
        $order->OrderCart=unserialize($order->OrderCart);
        return $order;  
      });
    return view("Store.resturant.Kitchen",["StoreType"=>$StoreType,"StoreId"=>$StoreId,'Orders'=>$transFormOrder]);
}


public function OrderKitchen(Request $request,$StoreType,$StoreId)
{
    $orderId=$request->get('id');

    //get Order 
    $getOrder=StoreOrder::find($orderId);

    //update Order (make It ready) And IF OrderType Is TakeAway MakeIt Done

    if($getOrder['OrderType'] != "TakeAway"){
        $UpdateOrder=$getOrder->update([
            'OrderStatus'=>"ready"
        ]);
        return response(200);
    }
    else{
        $UpdateOrder=$getOrder->update([
            'OrderStatus'=>"Done"
        ]);
        return response(200);
    }


}



public function DeliveryMain($StoreType,$StoreId)
{

    //get Delivery Orders
    $getOrders=StoreOrder::where([['OrderStoreId','=',$StoreId],['OrderType','=','Delivery'],['OrderStatus','=','ready']])->get();

   //get ORder Inf
    $transFormOrderInf=$getOrders->transform(function($order){ 
        $order->OrderInf=unserialize($order->OrderInf);
        return $order;  
      });
      //get ORder CArt

    $transFormOrderCart=$transFormOrderInf->transform(function($order2){ 
        $order2->OrderCart=unserialize($order2->OrderCart);
        return $order2;  
      });

    return view("Store.Delivery",["StoreType"=>$StoreType,"StoreId"=>$StoreId,'Orders'=>$transFormOrderCart]);
}



public function DeliveryPost(Request $request,$StoreType,$StoreId)
{
    $getOrder=StoreOrder::find($request->input('DeliveryDone'));

    if(!empty($getOrder)){
       
        $UpdateOrder=$getOrder->update([
            'OrderStatus'=>'Done'
            ]);
        return redirect()->route("Delivery",["StoreType"=>$StoreType,"StoreId"=>$StoreId,])->with("err",['err'=>'0','message'=>'OrderUpdatedErr']);
    }
}

public function WaiterMain($StoreType,$StoreId)
{

    $getDineInOrders=StoreOrder::where([["OrderStoreId","=",$StoreId],["OrderType","=","DineIn"],['OrderStatus',"=","ready"]])->get();
  //  transform Cart
    $transFormOrder=$getDineInOrders->transform(function($order){ 
        $order->OrderCart=unserialize($order->OrderCart);
        return $order;  
      });
  //  transform OrderInf TO Get TableId
    $transFormOrderT=$transFormOrder->transform(function($order2){ 
        $order2->OrderInf=unserialize($order2->OrderInf);
        return $order2;  
      });


  return view("Store.resturant.Waiter",["StoreType"=>$StoreType,"StoreId"=>$StoreId,"Orders"=>$transFormOrderT]);

}



public function AddItem(Request $request,$StoreType,$StoreId)
{

    $CartName="cart".$StoreId;
    $getProduct=StoreProduct::find($request->get("id"));

    $oldCart=Session::has($CartName) ? Session::get($CartName) : null;

        $oldCart= Session::get($CartName);
        $cart=new Item($oldCart);
        $cart->add($getProduct,$getProduct->id);
        $addSes=$request->session()->put($CartName, $cart);
        return $CartName;
}


public function DelItem(Request $request,$StoreType,$StoreId)
{

    $CartName="cart".$StoreId;
    $getProduct=StoreProduct::find($request->get("DelId"));
    $DelId=$getProduct->id;
     $oldCart=Session::has($CartName) ? Session::get($CartName) : null;
     $oldCart= Session::get($CartName);
     $cart=new Item($oldCart);
     $cart->remove($DelId);
     $DelSess=$request->session()->put($CartName, $cart);
     return $DelSess;

}

public function ReduceItem(Request $request,$StoreType,$StoreId)
{
    $CartName="cart".$StoreId;
    $getProduct=StoreProduct::find($request->get("id"));
    $reduceId=$getProduct->id;
    $oldCart=Session::has($CartName) ? Session::get($CartName) : null;
    $oldCart= Session::get($CartName);
    $cart=new Item($oldCart);
    $cart->reduce($reduceId);
    $reduceSess=$request->session()->put($CartName, $cart);
    return $reduceSess;
    
}


public function getItems(Request $request,$StoreType,$StoreId){

$CartName="cart".$StoreId;
$oldCart=Session::get($CartName);
$getCart=new Item($oldCart);
$products=$getCart->items;
$totalQty=$getCart->totalQty;
$totalPrice=$getCart->totalPrice;
$billView=view("Store.bill",['products'=>$products,'totalQty'=>$totalQty,"totalPrice"=>$totalPrice])->render();
   return response()->json($billView, 200);
}



public function CancelItems($StoreType,$StoreId)
{

    
    $CartName="cart".$StoreId;
    $DelCart=Session::has($CartName) ? Session::forget($CartName) :Session::forget($CartName);
}


public function AddOrder(Request $request,$StoreType,$StoreId)
{

 if($request->input('OrderTypeI') == 'Delivery'){
 
    $validate=$request->validate([
        'OrderTypeI'=>"required",
        "PaymentWayI"=>"required",
        "DeliveryEmpI"=>"required",
        "DeliveryAddressI"=>"required",
        "DeliveryPhoneI"=>"required",
        "CasherId"=>"required"
    ]);   
    $OrderInf=['DeliveryEmp'=>$validate['DeliveryEmpI'],'DeliveryAddress'=>$validate['DeliveryAddressI'],'DeliveryPhone'=>$validate['DeliveryPhoneI']];  
 }


 elseif($request->input('OrderTypeI') == 'DineIn'){

    $validate=$request->validate([
        "OrderTableI"=>"required",
        "OrderTableNameI"=>"required",
        "PaymentWayI"=>"required",
        "CasherId"=>"required"
    ]);

    //change Table Status To In use
    $getTable=ResTable::find($validate['OrderTableI']);
    $getTable->update([
        "TableStatus"=>"InUse"
    ]);



    $OrderInf=['TableName'=>$validate['OrderTableNameI'],'TableId'=>$validate['OrderTableI']];
    
 }


 elseif($request->input('OrderTypeI') == 'TakeAway'){

    $validate=$request->validate([
        "PaymentWayI"=>"required",
        "CasherId"=>"required"
    ]);
    $OrderInf=null;
 }


 elseif($request->input('OrderTypeI') == 'Pay'){
    $validate=$request->validate([
        "PaymentWayI"=>"required",
        "CasherId"=>"required"
    ]);
    $OrderInf=null;
    

};


$CartName="cart".$StoreId;

//get iTEMS
   $oldCart=Session::get($CartName);
   $getCart=new Item($oldCart);
//


//Order Payment

if(empty($getCart->items)){
    return redirect()->route("StorePos",["StoreType"=>$StoreType,"StoreId"=>$StoreId])->with("err",["err"=>"1","message"=>"BillEmptyErr"]);
}

//save Order
$saveOrder=new StoreOrder([
    "OrderType"=>$request->input('OrderTypeI'),
    "OrderName"=>uniqid(),
    "OrderStatus"=>"success",
    "OrderCart"=>serialize($getCart),
    "OrderPrice"=>$getCart->totalPrice,
    "OrderBy"=>$validate['CasherId'],
    "OrderPayment"=>$validate['PaymentWayI'],
    "OrderStoreId"=>$StoreId,
    "OrderInf"=>serialize($OrderInf)
]);

$saveOrder->save();

//forget Cart

    $removeBill=Session::forget($CartName);
//

///Add new notifcation
$getUser=Auth::guard("StoreUsers")->user();

$UserId=$getUser['id'];
$NotifValue="Order ".$saveOrder["OrderName"] ." Saved";

$saveNotif=new StoreNotif([
    "UserId"=>$UserId,
    "NotifStatus"=>"0",
    "NotifValue"=>$NotifValue
]);

$saveNotif->save();

//

return redirect()->route("StorePos",["StoreType"=>$StoreType,"StoreId"=>$StoreId])->with("err",["err"=>"0","message"=>'OrderSavedErr',"OrderId"=>$saveOrder['id']]);
 }



public function PrintOrder($StoreType,$StoreId,$OrderId)
{
    $getOrderPrint=StoreOrder::where([["OrderStoreId","=",$StoreId],["id","=",$OrderId]])->get();

  //  transform Cart
    $transFormOrder=$getOrderPrint->transform(function($order){ 
        $order->OrderCart=unserialize($order->OrderCart);
        return $order;  
      });

     return view("includes.PrintBill",["Order"=>$transFormOrder]);
   
}



public function PayOrderStripe(Request $request,$StoreType,$StoreId)
{

    
    $CartName="cart".$StoreId;
    $oldCart=Session::get($CartName);
    $getCart=new Item($oldCart);
        

        if($request->input('OrderTypeI') == 'Delivery'){
 
            $validate=$request->validate([
                'OrderTypeI'=>"required",
                "PaymentWayI"=>"required",
                "DeliveryEmpI"=>"required",
                "DeliveryAddressI"=>"required",
                "DeliveryPhoneI"=>"required",
                "CasherId"=>"required"
            ]);   
            $OrderInf=['DeliveryEmp'=>$validate['DeliveryEmpI'],'DeliveryAddress'=>$validate['DeliveryAddressI'],'DeliveryPhone'=>$validate['DeliveryPhoneI']];  
         }
        
        
         elseif($request->input('OrderTypeI') == 'DineIn'){
        
            $validate=$request->validate([
                "OrderTableI"=>"required",
                "OrderTableNameI"=>"required",
                "PaymentWayI"=>"required",
                "CasherId"=>"required"
            ]);
        
            //change Table Status To In use
            $getTable=ResTable::find($validate['OrderTableI']);
            $getTable->update([
                "TableStatus"=>"InUse"
            ]);
                
            $OrderInf=['TableName'=>$validate['OrderTableNameI'],'TableId'=>$validate['OrderTableI']];
            
         }
        
         elseif($request->input('OrderTypeI') == 'TakeAway'){
        
            $validate=$request->validate([
                "PaymentWayI"=>"required",
                "CasherId"=>"required"
            ]);
            $OrderInf=null;
         }

         elseif($request->input('OrderTypeI') == 'Pay'){
            $validate=$request->validate([
                "PaymentWayI"=>"required",
                "CasherId"=>"required"
            ]);
            $OrderInf=null;
        
        };
 
        
        //get iTEMS
           $oldCart=Session::get($CartName);
           $getCart=new Item($oldCart);
    
    //get Stripe Seceret Key
    $getUser=Auth::guard("StoreUsers")->user();
    $userId=$getUser['id'];


    $getKey=StorePayToken::where("UserId","=",$userId)->first();

    if(!empty($getKey)){
 
    $SecKey=$getKey['ApiSeceret'];
    }
    else{
        return response(404);
    }



        Stripe::setApiKey($SecKey);
    
        Charge::Create(array(
          "amount"=>$getCart->totalPrice*100,
          "currency"=>"usd",
          "source"=>$request->get('token'),
          "description"=>"Payment Done :) "
          ));

        // save Order
        $saveOrder=new StoreOrder([
            "OrderType"=>$request->input('OrderTypeI'),
            "OrderName"=>uniqid(),
            "OrderStatus"=>"success",
            "OrderCart"=>serialize($getCart),
            "OrderPrice"=>$getCart->totalPrice,
            "OrderBy"=>$validate['CasherId'],
            "OrderPayment"=>$validate['PaymentWayI'],
            "OrderStoreId"=>$StoreId,
            "OrderInf"=>serialize($OrderInf)
        ]);
        
        $saveOrder->save();
        
        //forget Cart
        
            $removeBill=Session::forget($CartName);
        //       

        
} 


public function ToKitchen(Request $request,$StoreType,$StoreId)
{

    

    $CartName="cart".$StoreId;
   //get iTEMS
   $oldCart=Session::get($CartName);
   $getCart=new Item($oldCart);

   if(empty($getCart->items)){
       return redirect()->route("StorePos",["StoreType"=>$StoreType,"StoreId"=>$StoreId])->with("err",["err"=>"1","message"=>"BillEmptyErr"]);
   }
   //get Order Type


   if($request->input('OrderTypeI') == "DineIn"){
       $validate=$request->validate([
           "OrderTableI"=>"required",
           "CasherId"=>"required",
           "OrderTableNameI"=>"required"
       ]);
     $getType=['TableId'=>$validate['OrderTableI'],'TableName'=>$validate['OrderTableNameI']];


        //change Table Status To In use
        $getTable=ResTable::find($validate['OrderTableI']);
        $getTable->update([
         "TableStatus"=>"InUse"
        ]);
   }
   elseif($request->input('OrderTypeI')=='Delivery'){
       $validate=$request->validate([
       "DeliveryEmpI"=>"required",
       "DeliveryAddressI"=>"required",
       "DeliveryPhoneI"=>"required",
       "CasherId"=>"required"
       ]);
      $getType=['DeliveryEmp'=>$validate['DeliveryEmpI'],'DeliveryAddress'=>$validate['DeliveryAddressI'],'DeliveryPhone'=>$validate['DeliveryPhoneI']];

      //change Employee Status
   }
   elseif($request->input('OrderTypeI')=="TakeAway"){

       $validate=$request->validate([
        "CasherId"=>"required"
       ]);
       $getType=null;
   }

   //save Order as Kitchen Status

   $saveOrder=new StoreOrder([
    
   'OrderName'=>uniqid(),
   "OrderType"=>$request->input('OrderTypeI'),
   'OrderCart'=>serialize($getCart),
   'OrderStatus'=>"kitchen",
   "OrderPrice"=>$getCart->totalPrice,
   'OrderBy'=>$validate['CasherId'],
   'OrderPayment'=>"0",
   'OrderInf'=>serialize($getType),
   'OrderStoreId'=>$StoreId
   ]);
   $saveOrder->save();


    //remove orders From bill
    $removeBill=Session::forget($CartName);

   return redirect()->route("StorePos",["StoreType"=>$StoreType,"StoreId"=>$StoreId])->with("err",["err"=>"0","message"=>"OrderSavedErr","OrderId"=>$saveOrder['id']]);
}



public function WaitPay(Request $request)
{

    //Pay USing Stripe   

    //get Order
    $getOrder=StoreOrder::find($request->get("idWaiting"));


    if(!empty($getOrder)){
  
//if Payment Way Credit Card Get Key And Do Payment

if($request->get("PaymentWayI") =="CreditCard"){
    //get Stripe Seceret Key
    $getUser=Auth::guard("StoreUsers")->user();
    $userId=$getUser['id'];

    $getKey=StorePayToken::where("UserId","=",$userId)->first();

    if(!empty($getKey)){
 
    $SecKey=$getKey['ApiSeceret'];
    Stripe::setApiKey($SecKey);
    
    Charge::Create(array(
      "amount"=>$getOrder['OrderPrice']*100,
      "currency"=>"usd",
      "source"=>$request->get('token'),
      "description"=>"Payment Done :) "
      ));
    }
    else{
        return response(404);
    }
}

if($request->get("OrderTypeIWaiting") =="DineIn"){
 
    //validate inputs
    $validate=$request->validate([
        "idWaiting"=>"required",
        "TableIdWaiting"=>"required"
    ]);

    //find Table And Update Status To Available
    $getTable=resTable::find($validate['TableIdWaiting']);

      if(!empty($getTable)){
        $getTable->update([
            "TableStatus"=>"Available"
        ]);
      }

} 

     $UpdateOrder=$getOrder->update([
         'OrderStatus'=>"success",
         "OrderPayment"=>$request->get('PaymentWayIWait')
     ]);


     if($request->get('PaymentWayIWait') == "CreditCard"){
        return response(200);
     }
     else{
         return redirect()->back()->with("err",['err'=>'0','message'=>"OrderUpdatedErr","OrderId"=>$getOrder['id']]);
     }
     

      }
      else{
          return redirect()->back()->with("err",['err'=>"1","message"=>"BillEmptyErr"]);
      }
}


public function waiterPost(Request $request,$StoreType,$StoreId)
{
     //validate Input

    if(!empty($request->input("OrderDoneI"))){
 
    //find ORder And Update Status
    $getOrder=StoreOrder::find($request->input("OrderDoneI"));

    if(!empty($getOrder)){
    
    $UpdateOrder=$getOrder->update([
        'OrderStatus'=>"Done"
    ]);
    return redirect()->route("Waiter",["StoreType"=>$StoreType,"StoreId"=>$StoreId])->with("err",['err'=>'0','message'=>'OrderUpdatedErr']);
    }
    else{
        return redirect()->route("Waiter",["StoreType"=>$StoreType,"StoreId"=>$StoreId])->with("err",['err'=>'1','message'=>'SW']);
    }
  }
    
}



public function HoldOrder(Request $request,$StoreType,$StoreId)
{
    
//validate Inputs

if($request->input('OrderTypeI') == 'Delivery'){
 
    $validate=$request->validate([
        'OrderTypeI'=>"required",
        "DeliveryEmpI"=>"required",
        "DeliveryAddressI"=>"required",
        "DeliveryPhoneI"=>"required",
        "CasherId"=>"required"
    ]);   
    $OrderInf=['DeliveryEmp'=>$validate['DeliveryEmpI'],'DeliveryAddress'=>$validate['DeliveryAddressI'],'DeliveryPhone'=>$validate['DeliveryPhoneI']]; 
 }


 elseif($request->input('OrderTypeI') == 'DineIn'){

    $validate=$request->validate([
        "OrderTableI"=>"required",
        "CasherId"=>"required",
        "OrderTableNameI"=>"required"
    ]);

            //change Table Status To In use
            $getTable=ResTable::find($validate['OrderTableI']);
            $getTable->update([
             "TableStatus"=>"InUse"
            ]);
            $OrderInf= $OrderInf=['TableName'=>$validate['OrderTableNameI'],'TableId'=>$validate['OrderTableI']];
    
 }


 elseif($request->input('OrderTypeI') == 'TakeAway'){

    $validate=$request->validate([
        "CasherId"=>"required"
    ]);
    $OrderInf=null;
 }


 elseif($request->input('OrderTypeI') == 'Pay'){
    $OrderInf=null;
    $validate=$request->validate([
        "CasherId"=>"required"
    ]);
};

$CartName="cart".$StoreId;
//get iTEMS
   $oldCart=Session::get($CartName);
   $getCart=new Item($oldCart);

   
   if(empty($getCart->items)){
    return redirect()->route("StorePos",["StoreType"=>$StoreType,"StoreId"=>$StoreId])->with("err",["err"=>"1","message"=>"BillEmptyErr"]);
}
//get
//



//save Order

$saveOrder=new StoreOrder([
    "OrderType"=>$request->input('OrderTypeI'),
    "OrderName"=>uniqid(),
    "OrderStatus"=>"Done",
    "OrderCart"=>serialize($getCart),
    "OrderPrice"=>$getCart->totalPrice,
    "OrderBy"=>$validate['CasherId'],
    "OrderPayment"=>"0",
    "OrderStoreId"=>$StoreId,
    "OrderInf"=>serialize($OrderInf)
]);

$saveOrder->save();

//forget Cart

    $removeBill=Session::forget('cart');
//
return redirect()->route("StorePos",["StoreType"=>$StoreType,"StoreId"=>$StoreId])->with(["err"=>"0","message"=>"OrderSavedErr"]);
}


public function RepoGet($StoreType,$StoreId)
{
    //get Repositories
    
    $getRepo=StoreRepo::where("RepoStoreId","=",$StoreId)->get();
    $withProds=$getRepo->load("Prods");
   
     return view("Store.Repository",["StoreType"=>$StoreType,"StoreId"=>$StoreId,"Repos"=>$withProds]);
}




public function RepoAdd(Request $request,$StoreType,$StoreId)
{
    //validate Inputs

    $validate=$request->validate([
        "RepoNameI"=>"required",
        "RepoAddressI"=>"required"
    ]);



    $getUser=Auth::guard("StoreUsers")->user();
    //set Plan Limit
   
    if($getUser['PlanType'] =="1"){
      $RepoLimit=2;
    }
    elseif($getUser['PlanType'] =="2"){
     
      $RepoLimit=4;
    }
    elseif($getUser['PlanType'] =="3"){
     
      $RepoLimit=6;
    }
    elseif($getUser['PlanType']=="4"){
    
    $RepoLimit=10;
    }

    //Compare Repository Limit and Repo  Count
    $CountRepo=StoreRepo::where('RepoStoreId','=',$StoreId)->count();

    if($CountRepo < $RepoLimit){


   //Add new Repository
    $saveRepo=new StoreRepo([
     "RepoName"=>$validate['RepoNameI'],
     "RepoAddress"=>$validate['RepoAddressI'],
     "RepoStoreId"=>$StoreId
    ]);

    $saveRepo->save();

    ///Add new notifcation

    $UserId=$getUser['id'];
    $NotifValue="Employee ".$saveRepo["RepoName"] ." Saved";

    $saveNotif=new StoreNotif([
        "UserId"=>$UserId,
        "NotifStatus"=>"0",
        "NotifValue"=>$NotifValue
    ]);

    $saveNotif->save();

    return redirect()->route("Repository",["StoreType"=>$StoreType,"StoreId"=>$StoreId])->with("err",['err'=>'0','message'=>"RepoCreatedErr"]);


    }
    else{
        return redirect()->route("Repository",["StoreType"=>$StoreType,"StoreId"=>$StoreId])->with("err",['err'=>'1','message'=>"PlanRepoErr"]);
    }
}



public function RepoOne($StoreType,$StoreId,$RepoOne)
{
    return view("RepoOne",['StoreType'=>$StoreType,'StoreId'=>$StoreId,"RepoId"=>$RepoOne]);
}


public function RepoProdAdd(Request $request,$StoreType,$StoreId)
{
    //validate Inputs
    $validate=$request->validate([
  
    "RProdNameI"=>"required",
    "RProdQtyI"=>"required",
    "RProdSourceI"=>"required",
    "RProdRepoI"=>"required"
    ]);
     $saveProdRepo=new StoreRepProds([
     "RProdName"=>$validate['RProdNameI'],
     "RProdQty"=>$validate['RProdQtyI'],
     "RProdRepo"=>$validate['RProdRepoI'],
     "RProdSource"=>$validate['RProdSourceI']
     ]);
     $saveProdRepo->save();
     return redirect()->route("Repository",['StoreType'=>$StoreType,'StoreId'=>$StoreId])->with("err",['err'=>'0','message'=>'ProdCreatedRepoErr']);
}



public function RepoProdDel($StoreType,$StoreId,$RProdId)
{
    

//get RepoProduct

$getRPRod=StoreRepPRods::find($RProdId);

if(!empty($getRPRod)){

    $delRProd=$getRPRod->delete();

    return redirect()->route("Repository",['StoreType'=>$StoreType,'StoreId'=>$StoreId])->with("err",['err'=>'0','message'=>'ProdDeletedRepoErr']);
}
else{
    return redirect()->route("Repository",['StoreType'=>$StoreType,'StoreId'=>$StoreId])->with("err",['err'=>'1','message'=>'SW']);
 }
}


public function RepoDel($StoreType,$StoreId)
{
    //get Repositories
    $getRepo=StoreRepo::where("RepoStoreId","=",$StoreId)->get();

    return view("Store.DelRepo",["Repos"=>$getRepo,'StoreType'=>$StoreType,'StoreId'=>$StoreId]);

}


public function DelRepo2(Request $request,$StoreType,$StoreId,$RepoId)
{
    if(!empty($RepoId)){

    //get Repo

    $getRepo=StoreRepo::find($RepoId);

    if(!empty($getRepo)){

        //delete Products On Repo

        $delRProd=StoreRepProds::where("RProdRepo","=",$getRepo['id'])->get();

        foreach($delRProd as $Rproduct){
            $delRProd2=StoreRepPRods::where("id","=",$Rproduct['id'])->first();
            $delRProd2->delete();
        }
 
        //Delete Repo
        $delRepo=$getRepo->delete();

        ///Add new notifcation
        $getUser=Auth::guard("StoreUsers")->user();
        $UserId=$getUser['id'];
        $NotifValue="Repository ".$delRepo["RepoName"] ." Deleted";
        $saveNotif=new StoreNotif([
            "UserId"=>$UserId,
            "NotifStatus"=>"0",
            "NotifValue"=>$NotifValue
        ]);
        $saveNotif->save();



        return redirect()->route("DelRepo",["Repos"=>$getRepo,'StoreType'=>$StoreType,'StoreId'=>$StoreId])->with("err",['err'=>'0','message'=>'RepoDeletedErr']);
    }
    }

}


public function RProdUpData(Request $request,$StoreType,$StoreId)
{
    //validate input
    $validate=$request->validate([
        "RProd"=>"required"
    ]);
     //find product
     $getRProd=StoreRepProds::find($validate['RProd']);

     if(!empty($getRProd)){
          return response()->json($getRProd, 200);
     }
     else{
        return response()->json("", 404);
     }


}


public function RprodUpPost(Request $request,$StoreType,$StoreId)
{

    //validate inputs
    $validate=$request->validate([
        "RprodNameUp"=>"required",
        "RprodQtyUp"=>"required",
        "RprodSourceUp"=>"required",
        "RprodIdUp"=>"required"
    ]);

    //get Product 
    $getProd=StoreRepProds::find($validate['RprodIdUp']);

    if(!empty($getProd)){
    //UPDate Product
    $getProd->update([
        "RProdName"=>$validate['RprodNameUp'],
        "RProdQty"=>$validate['RprodQtyUp'],
        "RProdSource"=>$validate['RprodSourceUp']
    ]);


        ///Add new notifcation
        $getUser=Auth::guard("StoreUsers")->user();
        $UserId=$getUser['id'];
        $NotifValue="Product ".$getProd["RProdName"] ." Updated On Repository";
        $saveNotif=new StoreNotif([
            "UserId"=>$UserId,
            "NotifStatus"=>"0",
            "NotifValue"=>$NotifValue
        ]);
        $saveNotif->save();


    return redirect()->route("Repository",['StoreType'=>$StoreType,'StoreId'=>$StoreId])->with("err",['err'=>'0','message'=>'ProdUpdatedErr']);
    }
    else{
        return redirect()->route("Repository",['StoreType'=>$StoreType,'StoreId'=>$StoreId])->with("err",['err'=>'1','message'=>'SW']);
    }
 }




public function ToDelivery(Request $request,$StoreType,$StoreId)
{
    //vaidate Inputs
    $validate=$request->validate([
        "DeliveryEmpI"=>"required",
        "DeliveryAddressI"=>"required",
        "DeliveryPhoneI"=>"required",
        "CasherId"=>"required"
    ]);

    $OrderInf=["DeliveryEmp"=>$validate['DeliveryEmpI'],"DeliveryAddress"=>$validate['DeliveryAddressI'],"DeliveryPhone"=>$validate['DeliveryPhoneI']];


    //get Cart
    $CartName="cart".$StoreId;
    $oldCart=Session::get($CartName);
    $getCart=new Item($oldCart);
    $products=$getCart->items;
    $totalQty=$getCart->totalQty;
    $totalPrice=$getCart->totalPrice;
  
    if(!empty($getCart)){
    //save Order
    $saveOrder=new StoreOrder([
        "OrderType"=>"Delivery",
        "OrderName"=>uniqid(),
        "OrderStatus"=>"ready",
        "OrderCart"=>serialize($getCart),
        "OrderPrice"=>$getCart->totalPrice,
        "OrderBy"=>$validate['CasherId'],
        "OrderPayment"=>0,
        "OrderStoreId"=>$StoreId,
        "OrderInf"=>serialize($OrderInf)
      ]);

    $saveOrder->save();

   return redirect()->route("StorePos",['StoreType'=>$StoreType,"StoreId"=>$StoreId])->with("err",['err'=>"0","message"=>"OrderSavedErr","OrderId"=>$saveOrder['id']]);
    }
    else{
        return redirect()->route("StorePos",['StoreType'=>$StoreType,"StoreId"=>$StoreId])->with("err",['err'=>"1","message"=>"BillEmptyErr"]);
    }
}


// public function ReportsWeek($StoreType,$StoreId)
// {

//     //get Weekly Reports
//     $getRports=StoreReport::where([['ReportStoreId',$StoreId],['ReportType','Weekly']])->get();

//     return view("Store.ReportsWeek",['StoreType'=>$StoreType,"StoreId"=>$StoreId,"Reports"=>$getRports]);
// }

// public function ReportsMonth($StoreType,$StoreId)
// {

//     $getReports=StoreReport::where([['ReportStoreId',$StoreId],['ReportType','Monthly']])->get()->load("getFuck");
    
//     return $getReports;



//     //return view("Store.ReportsMonth",['StoreType'=>$StoreType,'StoreId'=>$StoreId,'Reports'=>$getReports]);


// }






}
