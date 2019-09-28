<?php
/**
 * Created by PhpStorm.
 * User: usr0
 * Date: 9/23/19
 * Time: 9:46 AM
 */

namespace App\Http\Validation;

use App\Exceptions\ApiException;
use App\Http\Helper\Str;
use Validator;

trait RequestDataValidation
{
    /**
     * dogrulamadan gecemeyen anahtarlar icin biriktirilen mesajlar
     * @var array
     */
    public $errors = [];

    /**
     * kurallar
     * @var array
     */
    public $rules = [];

    /**
     * @throws ApiException
     */
    private function throwExc()
    {
        if (sizeof($this->errors)) {
            throw new ApiException([
                'success' => false,
                'message'  => $this->errors
            ], 406);
        }
    }

    /**
     * @param $requestData
     * @param array $keys validationRules'daki dogrulama sonrasinda ozel olarak kontrol/revize etmek istedigimiz alanlar
     * @param string $langAttrs
     * @param array $customMessages
     * @throws ApiException
     */
    public function validateRequest(& $requestData, array $keys = [], $langAttrs = '', $customMessages = [])
    {
        if (sizeof($this->rules)) {
            $validator = Validator::make(
                $requestData,
                $this->rules,
                $customMessages,
                $langAttrs ? \Lang::get($langAttrs) : []
            );
            if ($validator->fails()) {
                $this->errors = $validator->messages()->toArray();
            }
        }
        $this->throwExc();
        if (sizeof($keys)) {
            foreach ($keys as $key) {
                $method = Str::underscoreToCamelCase($key);
                if (method_exists($this, $method)) {
                    /**
                     * uzayan validation bloklari yerine dogrulanacak field a ozel metot yazmayi tercih ettik
                     */
                    \call_user_func_array([$this, $method], [& $requestData[$key]]);
                }
            }
        }
        $this->throwExc();
    }
}
