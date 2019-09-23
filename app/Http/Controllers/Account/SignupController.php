<?php

namespace App\Http\Controllers\Account;

use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Validation\Account\SignupValidation;
use App\Http\Validation\RequestDataValidation;
use App\Repository\Contracts\AccountRepository;
use App\Repository\Contracts\StudentRepository;
use Illuminate\Http\Request;
use Validator;

class SignupController extends Controller
{
    use RequestDataValidation, SignupValidation;

    /**
     * @var AccountRepository
     */
    private $storage;

    /**
     * @var StudentRepository
     */
    private $storageStudent;

    /**
     * SignupController constructor.
     * @param AccountRepository $storage
     * @param StudentRepository $storageStudent
     */
    public function __construct(AccountRepository $storage, StudentRepository $storageStudent)
    {
        $this->storage = $storage;
        $this->storageStudent = $storageStudent;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    protected function create(Request $request)
    {
        /**
         * validasyon kurallari
         */
        $this->rules = [
            'account_code' => ['required', 'digits:6'],
            'name' => ['required', 'string', 'max:20'],
            'surname' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:tblAccount'],
            'password' => ['required', 'string', 'min:8'], // parola konfirm clientside yapilabilir
            'mobile' => ['digits:10']
        ];

        $data = $request->only(array_keys($this->rules));
        try {
            $this->validateRequest($data, ['password','account_code']);
            $this->storage->create($data);
            return response()->json([
                'success' => true,
                'message' => [
                    'general' => trans('account.signup.success')
                ]
            ]);
        }
        catch (ApiException $e) {
            return response()->json($e->getMsg(), $e->getResponseCode());
        }
    }
}
