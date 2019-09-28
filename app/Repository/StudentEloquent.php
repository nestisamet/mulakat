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
     * @param $params limit-offset'lendirme, siralama ve arama parametreleri
     * ( soyad ve aileHesapKodu a gore filtrelenebilir )
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll($params)
    {
        $items = $this->model->with([
            'parents' => function ($q) {
                $q->select(['account_code','name','surname','mobile','email','created_at']);
            }
        ]);
        /**
         * parametreler
         */
        if (isset($params->parent_account_code)) {
            $items->where('parent_account_code', 'like', "%{$params->parent_account_code}%");
        }
        if (isset($params->surname)) {
            $items->where('surname', 'like', "%{$params->surname}%");
        }
        if (isset($params->order)) {
            $items->orderBy(
                $params->order,
                (!isset($params->order_type)) ? 'asc' : $params->order_type
            );
        }
        if (isset($params->offset)) {
            $items->skip($params->offset);
        }
        if (isset($params->limit)) {
            $items->take($params->limit);
        }

        return  $items->get();
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
