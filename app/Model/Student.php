<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'tblStudent';
    public $guarded = [];


    public function parents()
    {
        return $this->hasMany('App\Model\Account', 'account_code', 'parent_account_code');
    }
}
