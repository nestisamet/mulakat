<?php
/**
 * Created by PhpStorm.
 * User: usr0
 * Date: 9/23/19
 * Time: 10:40 AM
 */

namespace App\Repository;


use App\Http\Resources\Account;
use App\Model\Student;
use App\Repository\Contracts\StudentRepository;

class StudentEloquent implements StudentRepository
{
    private $model;

    /**
     * StudentEloquent constructor.
     * @param Student $student
     */
    public function __construct(Student $student)
    {
        $this->model = $student;
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
     * belirli bir ailenin cocuklari
     * @param $parentAccountCode
     * @return mixed
     */
    public function getItems($parentAccountCode)
    {
        return $this->model->where('parent_account_code', $parentAccountCode)->get();
    }

    /**
     * tum cocuklar
     * @param $parentAccountCode
     * @return mixed
     */
    public function getAll()
    {
        return $this->model->with([
            /**
             * aile bireyine dair her anahari sunmak istemeyiz
             */
            'parents' => function($q) {
                $q->select(['account_code','name','surname','mobile','email','created_at']);
            }
        ])
        ->get();
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
        $this->model->create($attrs);
    }

    /**
     * @param $attr
     * @param $val
     * @return mixed
     */
    public function getItemByAttr($attr, $val)
    {
        return $this->model->where($attr, $val)->first();
    }
}