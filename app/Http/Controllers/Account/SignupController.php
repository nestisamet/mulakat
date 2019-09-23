<?php

namespace App\Http\Controllers\Account;

use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Repository\Contracts\AccountRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SignupController extends Controller
{
    /**
     * @var AccountRepository
     */
    private $storage;

    /**
     * @var array validasyon kurallari
     */
    private $rules = [
        'account_code' => ['required', 'digits:10'],
        'name' => ['required', 'string', 'max:20'],
        'surname' => ['required', 'string', 'max:50'],
        'email' => ['required', 'string', 'email', 'max:100', 'unique:tblAccount'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
        'mobile' => ['digits:10']
    ];

    /**
     * SignupController constructor.
     * @param AccountRepository $storage
     */
    public function __construct(AccountRepository $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @param array $data
     * @return array|void
     * @throws ApiException
     */
    protected function validateRequest(& $data)
    {
        $validator = Validator::make($data, $this->rules);
        if ($validator->failed()) {
            throw new ApiException([
                'success' => false,
                'message' => $validator->messages()->toArray(),
            ], 406);
        }
        $data['password'] = Hash::make($data['password']);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    protected function create(Request $request)
    {
        $data = $request->only(array_keys($this->rules));
        try {
            $this->validateRequest($data);
            $this->storage->create($data);
        }
        catch (ApiException $e) {
            return response()->json($e->getMsg(), $e->getResponseCode());
        }
    }
}
