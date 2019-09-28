<?php
/**
 * Created by PhpStorm.
 * User: usr0
 * Date: 9/23/19
 * Time: 10:20 AM
 */

namespace App\Http\Validation\Account;

use Illuminate\Support\Facades\Hash;

trait SignupValidation
{
    /**
     * parolanin hashli halini sakliyoruz
     * @param $val
     */
    public function password(& $val)
    {
        $val = Hash::make($val);
    }

    /**
     * (ebeveyn) uyelik kodunu isaret eden bir ogrenci var mi diye bakiyoruz
     * @param $val
     */
//    public function accountCode($val)
//    {
//        if (is_null($this->storageStudent->getItemByAttr('parent_account_code', $val)))
//        {
//            $this->errors['account_code'][] = trans('account.signup.notExistsCode');
//        }
//    }
}
