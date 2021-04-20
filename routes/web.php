<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/',['uses'=>'Controller@mainGetR']);

Route::get('/{lang}',["uses"=>"Controller@mainGet","as"=>"main"]);



Route::prefix('users')->group(function(){

Route::get('/SignIn',['uses'=>'UsersController@SignInGet','as'=>'SignIn']);

Route::post('/SignIn',['uses'=>'UsersController@SignInPost']);

Route::get('/SignUp',['uses'=>'UsersController@SignUpGet','as'=>'signUp'  ]);

Route::post('/SignUp',['uses'=>'UsersController@SignUpPost']);

Route::get('/Activate/{token}',['uses'=>"UsersController@ActivateGet",'as'=>"Activate"]);

Route::get('/RestPass',['uses'=>"UsersController@RestPassGet","as"=>"RestPassGet"]);

Route::post("/RestPass",['uses'=>"UsersController@RestPassPost","as"=>"RestPassPost"]);

Route::get("/RestPass/{token}",["uses"=>'UsersController@RestPassNew',"as"=>"RestPassNewG"]);

Route::post("/RestPass/{token}",["uses"=>'UsersController@RestPassNewP',"as"=>"RestPassNewP"]);

// this route for ajax sign up form queries

Route::post('checkForm',['uses'=>'UsersController@chekFormPost',"as"=>"CheckSignUp"]);

//	

Route::group(['middleware'=>['auth:StoreUsers']],function(){

    Route::get('/users',["uses"=>"USersController@usersGet"]);

    Route::get("/UpdateUser",['uses'=>"UsersController@UpdateGet","as"=>"UpdateUser"]);

    Route::post("/UpdateUser",['uses'=>"UsersController@UpdateUserPost","as"=>"UpdateUserPost"]);

     Route::post("/SetApi",['uses'=>"UsersController@SetApiPost","as"=>"SetApi"]);

    Route::post("UpdateNotif",["uses"=>"UsersController@UpdateNotif","as"=>"UpdateNotif"]);

    Route::group(['prefix' => 'Dashboard',"middleware"=>"CheckPlan"], function () {


        Route::get('/',['uses'=>'DashboardController@mainDashboard','as'=>'Dashboard']);

        Route::post("/AddStore",['uses'=>"DashboardController@AddStorePost",'as'=>"AddStore"]);

        Route::get("/DelStore",['uses'=>"DashboardController@DelStoreGet",'as'=>"DelStore"]);

        Route::get('/DelStore/{StoreId}',['uses'=>"DashboardController@DelStoreGet2"]);

        Route::group(['prefix' => '{StoreType}/{StoreId}'],             function () {

        Route::get("/",['uses'=>"StoresController@StoremainGet",'as'=>"StoreMain"]);

        Route::post("/",['uses'=>"StoresController@StormainPost","as"=>"StoreMainPost"]);


        Route::group(['prefix' => 'Pos'], function () {

            Route::get('/',['uses'=>"StoresController@PosGet","as"=>"StorePos"]);

            Route::post('AddItem', ["uses"=>"StoresController@AddItem","as"=>"AddItem"]);

            Route::post("DelItem",['uses'=>"StoresController@DelItem","as"=>"DelItem"]);

            Route::post("reduceItem",["uses"=>"StoresController@ReduceItem","as"=>"ReduceItem"]);
            
            Route::get('getItems',['uses'=>"StoresController@getItems","as"=>"getItems"]);

            Route::post('CancelItems',['uses'=>'StoresController@CancelItems','as'=>"CancelItems"]);

            Route::post('AddOrder',['uses'=>"StoresController@AddOrder","as"=>"AddOrder"]);

            Route::post("PayOrderStripe",['uses'=>"StoresController@PayOrderStripe","as"=>"PayOrderStripe"]);

            Route::post('ToKicthen',['uses'=>"StoresController@ToKitchen","as"=>"ToKitchen"]);

            Route::post("HoldOrder",['uses'=>'StoresController@HoldOrder','as'=>'HoldOrder']);

            Route::post('WaitingPay',['uses'=>"StoresController@WaitPay",'as'=>"WaitPay"]);

            Route::post("ToDelivery",['uses'=>"StoresController@ToDelivery","as"=>"ToDelivery"]);
            
            Route::get("PrintOrder/{OrderId}",['uses'=>"StoresController@PrintOrder","as"=>"PrintOrder"]);
        });

        Route::get("Products",["uses"=>"StoresController@ProductGet","as"=>"Products"]);

        Route::post("Products",['uses'=>"StoresController@AddProdPost","as"=>"AddProd"]);

        Route::get("DelProd/{ProdId}",['uses'=>"StoresController@DelProdGet","as"=>"DelProd"]);

        Route::post("UpdateProd",['uses'=>'StoresController@UpdateProd','as'=>'UpdateProd']);

        Route::post("UpdateProdG",['uses'=>"StoresController@UpdateProdG","as"=>"UpdateProdG"]);

        Route::get("Catigories",["uses"=>"StoresController@CatigoryGet","as"=>"Catigories"]);
        
        Route::post('Catigories',['uses'=>"StoresController@AddCatigoryPost","as"=>"AddCatigory"]);

        Route::get('DelCatigory/{CatId}',["uses"=>"StoresController@DelCatigory","as"=>"DelCatigory"]);

        Route::get("Employees",['uses'=>"StoresController@EmployeeGet","as"=>"Employee"]);

        Route::post("Employees",['uses'=>"StoresController@AddEmployee","as"=>"AddEmployee"]);

        Route::get("DelEmployee/{EmpId}",['uses'=>"StoresController@DelEmployee","as"=>"DelEmployee"]);

        Route::get("Repository",['uses'=>"StoresController@RepoGet","as"=>"Repository"]);

        Route::post("AddRepo",['uses'=>"StoresController@RepoAdd","as"=>"AddRepo"]);
  
        Route::get("DelRepo",['uses'=>"StoresController@RepoDel","as"=>"DelRepo"]);

        Route::get("DelRepo/{RepoId}",['uses'=>'StoresController@DelRepo2','as'=>'DelRepo2']);

        Route::post("AddRProd",['uses'=>"StoresController@RepoProdAdd","as"=>"AddRProd"]);

        Route::get("DelRProd/{RProdId}",["uses"=>"StoresController@RepoProdDel","as"=>"RepoProdDel"]);

        Route::post("RProdUpData",['uses'=>"StoresController@RProdUpData","as"=>"RProdUpData"]);
   
        Route::post("RprodUpPost",["uses"=>"StoresController@RprodUpPost","as"=>"RprodUpPost"]);

        Route::get("Tables",['uses'=>"StoresController@TableGet","as"=>"Tables"]);

        Route::post("Tables",['uses'=>"StoresController@TablePost","as"=>"AddTable"]);

        Route::get("DelTable/{TableId}",['uses'=>"StoresController@DelTable","as"=>"DelTable"]);

        Route::post("getTable",['uses'=>"StoresController@getTable",'as'=>"getTable"]);

        Route::post("UpdateTable",['uses'=>"StoresController@UpdateTable","as"=>"UpdateTable"]);

        Route::get("kitchen",['uses'=>"StoresController@KitchenMain",'as'=>"Kitchen"]);

        Route::post('OrderKitchen',['uses'=>"StoresController@OrderKitchen","as"=>"OrderKitchen"]);

        Route::get('Delivery',['uses'=>'StoresController@DeliveryMain','as'=>'Delivery']);

        Route::post('Delivery',['uses'=>'StoresController@DeliveryPost','as'=>'DeliveryPost']);

        Route::get('Waiter',['uses'=>'StoresController@WaiterMain','as'=>'Waiter']);
 
        Route::post('Waiter',['uses'=>"StoresController@WaiterPost","as"=>"waiterPost"]);

        Route::get("Sales",['uses'=>"StoresController@SalesGet","as"=>"Sales"]);

        // Route::get("ReportsWeek",['uses'=>"StoresController@ReportsWeek","as"=>"ReportsWeek"]);

        // Route::get("ReportsMonth",["uses"=>"StoresController@ReportsMonth","as"=>"ReportsMonth"]);


       });
    });

    Route::get('/SetPlan',['uses'=>'DashboardController@SetPlanGet','as'=>'SetPlan']);
    
    Route::post('/payWithStripe',['uses'=>'DashboardController@PayStripe','as'=>"PayWithStripe"]);

    Route::post('/CheckPayWithPayPal',['uses'=>"DashboardController@PayPayPal",'as'=>"CheckPayment"]);

    Route::post("/PayWithPayPal",['uses'=>"DashboardController@ExecPayment","as"=>"ExecPayment"]);
    
    Route::get('/LogOut',['uses'=>'UsersController@LogOut','as'=>'LogOut']);
    
    });
    
	
});


