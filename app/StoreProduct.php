<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreProduct extends Model
{
    //

    protected $fillable=['ProdName','ProdPrice','ProdCatigory',"ProdStoreId","ProdImg"];

public function Catigory()
{
    return $this->belongsTo('App\StoreCatigory', 'ProdCatigory','id');
}

public function Image()
{
    return $this->hasOne('App\StorePic', 'id', 'ProdImg');
}

}
