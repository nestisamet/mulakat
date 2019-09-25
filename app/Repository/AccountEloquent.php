<?php
/**
 * Created by PhpStorm.
 * User: usr0
 * Date: 9/23/19
 * Time: 1:51 AM
 */

namespace App\Repository;

use App\Model\Account;
use App\Repository\Contracts\AccountRepository;

class AccountEloquent implements AccountRepository
{
    private $model;

    /**
     * AccountEloquent constructor.
     * @param Account $account
     */
    public function __construct(Account $account)
    {
        $this->model = $account;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getItem($id)
    {
        return $this->model->find($id);
    }

    /**
     * @param $id
     * @param $attrs
     */
    public function update($id, $attrs)
    {
        $item = $this->model->findOrFail($id);
        $item->update($attrs);
    }

    /**
     * @param $attrs
     */
    public function create($attrs)
    {
        return $this->model->create($attrs);
    }
}
