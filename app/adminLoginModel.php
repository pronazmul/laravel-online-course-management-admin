<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class adminLoginModel extends Model
{
    protected $table ='login';
    protected $primaryKey ='id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = false;
}
