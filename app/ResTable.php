<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class resTable extends Model
{
    //
    protected $fillable=['TableStoreId','TableName','TableMaxSeat',"TableStatus",'TableOrder'];

    
}
