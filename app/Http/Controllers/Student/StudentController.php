<?php

namespace App\Http\Controllers\Student;

use App\Exceptions\ApiException;
use App\Http\Validation\Student\StudentValidation;
use App\Http\Validation\RequestDataValidation;
use App\Repository\Contracts\StudentRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StudentController extends Controller
{
    use RequestDataValidation,
        StudentValidation;

    /**
     * @var StudentRepository
     */
    private $storage;

    public function __construct(StudentRepository $storage)
    {
        $this->storage = $storage;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\ApiException
     */
    public function store(Request $request)
    {
        $this->rules = [
            // 'parent_account_code' => ['required', 'digits:6'],
            'name' => ['required', 'string', 'max:20'],
            'idendity_no' => ['required', 'string', 'digits:11'],
            'surname' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:tblStudent'],
        ];
        $data = $request->only(array_keys($this->rules));
        $data['parent_account_code'] = auth()->user()->account_code;
        $data['status'] = 1;
        try {
            $this->validateRequest($data, ['idendity_no']);
            $this->storage->create($data);
            return response()->json([
                'success' => true,
                'message' => [
                    'general' => trans('msg.item_created')
                ]
            ]);
        }
        catch (ApiException $e) {
            return response()->json($e->getMsg(), $e->getResponseCode());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
