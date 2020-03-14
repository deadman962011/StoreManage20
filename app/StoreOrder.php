<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\ResTable;

class StoreOrder extends Model
{
    protected $fillable=['OrderName','OrderType','OrderCart','OrderStatus','OrderPrice','OrderBy','OrderPayment','OrderInf','OrderStoreId'];


}
