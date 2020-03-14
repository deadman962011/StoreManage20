<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreEmployee extends Model
{
    //
    protected $fillable=['EmployeeName','EmployeeGender','EmployeeAge','EmployeeStatus','EmployeeFee','EmployeeDP','EmployeeMS','EmployeeStoreId','EmployeeType'];
}
