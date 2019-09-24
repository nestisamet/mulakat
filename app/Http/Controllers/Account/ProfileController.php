<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Validation\RequestDataValidation;
use App\Repository\Contracts\AccountRepository;
use Illuminate\Http\Request;
use Validator;
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
     */
    protected function store(Request $request)
    {

    }
}
