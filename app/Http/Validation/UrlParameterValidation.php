<?php

namespace App\Http\Validation;


/**
 * mevcut uygulamada bir ebeveynin cocuk sayisi cok fazla sonuc dondurmeyecegi icin limitlendirme tercih edilmedi
 * request URL'indeki queryString'leri de kontrol ettigimizi belirtmek istedim
 *
 * Trait UrlParameterValidation
 * @package App\Http\Validation
 */
trait UrlParameterValidation
{
    /**
     * @param $params
     */
    public function validateSearch(& $params)
    {
        if (isset($params->order_type) && !in_array(mb_strtolower($params->order_type), ['asc', 'desc'])) {
            $this->errors['general'][] = trans('validation.in_array', ['attribute'=> trans('order'), 'items'=>implode(',', ['asc', 'desc'])]);
        }
        if (isset($params->offset) && intval($params->offset) < 0) {
            $this->errors['general'][] = trans('validation.min.numeric', ['attribute'=>trans('offset'), 'min'=>0]);
        }
        if (isset($params->limit)) {
            if ($params->limit < 1) {
                $this->errors['general'][] = trans('validation.min.numeric', ['attribute'=>trans('limit'), 'min'=>1]);
            }
            if (intval($params->limit) > 200)
                $params->limit = 200;
        }
        else {
            $params->limit = 200;
        }

        $this->throwExc();
    }
}