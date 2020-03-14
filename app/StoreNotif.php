<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreNotif extends Model
{
    //
    protected $fillable=["UserId","NotifStatus","NotifValue"];
}
