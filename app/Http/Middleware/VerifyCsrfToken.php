<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Indicates whether the XSRF-TOKEN cookie should be set on the response.
     *
     * @var bool
     */
    protected $addHttpCookie = true;

    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
       'users/Dashboard/{StoreType}/{SotreId}',
       '/users/Dashboard/{StoreType}/{SotreId}/OrderKitchen',
       '/users/Dashnoard/{StoreType}/{SotreId}/Pos/AddItem',
       '/users/Dashnoard/{StoreType}/{SotreId}/Pos/getItems',
       '/users/Dashnoard/{StoreType}/{SotreId}/Pos/DelItem',
       '/users/Dashnoard/{StoreType}/{SotreId}/Pos/reduceItem',
       '/users/Dashnoard/{StoreType}/{SotreId}/Pos/CancelItems',
       '/users/Dashnoard/{StoreType}/{SotreId}/Pos/WaitingPay',
       '/users/Dashnoard/{StoreType}/{SotreId}/Pos/PayOrderStripe',
       '/users/UpdateNotif/*',
       '/users/PayWithStripe/*',
       '/users/checkForm/*',
       '/users/UpdateNotif/*' 
    ];
}
