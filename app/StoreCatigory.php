<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreCatigory extends Model
{
    //
  protected  $fillable=['CatigoryName','CatigoryStoreId',"CatigoryProdsNum"];


public function Products()
{
    return $this->hasMany('App\StoreProduct', 'ProdCatigory', 'id');
}



}
