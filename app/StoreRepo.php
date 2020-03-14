<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreRepo extends Model
{
    //
    protected $fillable=['RepoName','RepoAddress','RepoStoreId'];



    public function Prods()
    {
        return $this->hasMany('App\StoreRepProds', 'RProdRepo', 'id');
    }

}




