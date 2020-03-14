<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


public function mainGetR(){
  
	return redirect()->route('main',["lang"=>'ar']);
}


public function mainGet($lang)
{

  if( $lang =='ar' or $lang =='en'){
    App::setLocale($lang);
    session()->put('locale',$lang);
    return view("mainView");
 
  }
  else{
    return redirect()->route('main',["lang"=>'ar']);
     }
}

}
