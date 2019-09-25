<?php
/**
 * Created by PhpStorm.
 * User: usr0
 * Date: 9/23/19
 * Time: 1:51 AM
 */

namespace App\Repository;

use App\Model\LoginActivity;
use App\Repository\Contracts\LoginActivityRepository;

class LoginActivityEloquent implements LoginActivityRepository
{
    private $model;

    /**
     * LoginActivityEloquent constructor.
     * @param LoginActivity $loginActivity
     */
    public function __construct(LoginActivity $loginActivity)
    {
        $this->model = $loginActivity;
    }


    /**
     * @param $attrs
     */
    public function create($attrs)
    {
        $this->model->create($attrs);
    }
}
