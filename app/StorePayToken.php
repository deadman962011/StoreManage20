<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StorePayToken extends Model
{
    //
    protected $fillable=['ApiSeceret','ApiPub',"UserId"];
}


