<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class LoginActivity extends Model
{
    protected $table = 'tblLoginActivity';
    public $guarded = [];
    public $timestamps = false;
}
