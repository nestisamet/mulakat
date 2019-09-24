<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Validation\Auth\PasswordValidation;
use App\Http\Validation\RequestDataValidation;
use App\Repository\Contracts\AccountRepository;
use Illuminate\Http\Request;

class PasswordController extends Controller
{
    use RequestDataValidation,
        PasswordValidation;

    /**
     * @var AccountRepository
     */
    private $storage;

    /**
     * @param AccountRepository $storage
     */
    public function __construct(AccountRepository $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    protected function update(Request $request)
    {
        $this->rules = [
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required', 'string', 'min:8']
        ];

        $data = $request->only(array_keys($this->rules));
        try {
            $this->validateRequest($data, ['current_password'], 'auth.attr');

            $this->storage->update(auth()->user()->id, [
                'password' => bcrypt($data['password'])
            ]);
            return response()->json([
                'success' => true,
                'message' => [
                    'general' => trans('passwords.reset')
                ]
            ]);
        }
        catch (ApiException $e) {
            return response()->json($e->getMsg(), $e->getResponseCode());
        }
    }
}
