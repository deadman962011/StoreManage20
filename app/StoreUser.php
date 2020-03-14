<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class StoreUser extends Authenticatable
{
    use Notifiable;
    
   
        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'StoreFullName', 'StoreEmail','StoreUserName','StoreAddress','PlanType','PlanDayLeft',
        'UserStatus','validationToken','StorePassword'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        "StorePassword"
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];//

    public function getAuthPassword()
    {
        return $this->StorePassword;
    }

}
