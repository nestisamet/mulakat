<?php

namespace App\Http\Controllers\Account;

use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Validation\RequestDataValidation;
use App\Repository\Contracts\AccountRepository;
use Illuminate\Http\Request;
use App\Http\Resources\Account as AccountResource;

class ProfileController extends Controller
{
    use RequestDataValidation;

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

    public function index()
    {
        return response()->json(new AccountResource(auth()->user()));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\ApiException
     */
    protected function store(Request $request)
    {
        $this->rules = [
            'name' => ['required', 'string', 'max:20'],
            'surname' => ['required', 'string', 'max:50']
        ];

        $data = $request->only(array_keys($this->rules));
        try {
            $this->validateRequest($data);
            $this->storage->update(auth()->user()->id, $data);
            return response()->json([
                'success' => true,
                'message' => [
                    'general' => trans('account.profile.updated')
                ]
            ]);
        }
        catch (ApiException $e) {
            return response()->json($e->getMsg(), $e->getResponseCode());
        }
    }
}
