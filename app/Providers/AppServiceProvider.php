<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\StoreNotif;

use Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //

        view()->composer("includes.navbar",function($view){

            $getUser=Auth::user();
            $UserId=$getUser['id'];
            $UserDays=$getUser['PlanDayLeft'];
            $Notifs=StoreNotif::where("UserId",$UserId)->orderBy("created_at","DESC")->get();
            $NotifCount=$Notifs->count();
            $view->with(["Notifs"=>$Notifs,"NotifCount"=>$NotifCount,"UserInf"=>$getUser]);
        });
    }
}
