<?php

namespace App\Http\Controllers;

use App\Http\Resources\TransactionUser;
use App\Http\Resources\TransactionCollection;
use App\Http\Resources\Validation;
use App\Transaction;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = \App\Transaction::query();
        if ($request->get('order')) {
            $key = filter_var(key($request->get('order')), FILTER_SANITIZE_STRING);
            $value = filter_var(array_first($request->get('order')), FILTER_SANITIZE_STRING);
            $query->orderBy($key, $value);
        }

        if ($request->get('filters')) {
            $filters = $request->get('filters');
            if (isset($filters['status'])) {
                $status = filter_var($request->get('filters')['status'], FILTER_SANITIZE_STRING);
                $query->where('status', $status);
            }
        }

        $transactions = $query->paginate((int)$request->get('limit', 10));
        return response()->json(
            (new TransactionCollection($transactions))->additional(
                [
                    'order' => $request->get('order', ['id' => 'asc']),
                    'count' => Transaction::count()
                ]
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'provider' => 'required_without:provider_id',
            'type' => 'required',
            'amount' => 'required',
            'currency' => 'required',
            'user' => 'required|array',
            'user.first_name' => 'required',
            'user.last_name' => 'required',
            'user.gender' => 'required',
            'user.email' => 'required|email',
            'user.address' => 'required',
            'user.city' => 'required',
            'user.zip' => 'required',
            'user.country_code' => 'required',
            'user.birthday' => 'required'
        ], [
            'required' => 'Value is required and can\'t be empty'
        ]);

        if ($validator->fails()) {
            return response()->json(new Validation($validator->errors()), 422);
        }

        DB::beginTransaction();
        try {
            $user = User::updateOrCreate(
                ['email' => $data['user']['email']],
                [
                    'first_name' => $data['user']['first_name'],
                    'last_name' => $data['user']['last_name'],
                    'gender' => $data['user']['gender'],
                    'email' => $data['user']['email'],
                    'address' => $data['user']['address'],
                    'city' => $data['user']['city'],
                    'zip' => $data['user']['zip'],
                    'country_code' => $data['user']['country_code'],
                    'birthday' => $data['user']['birthday'],
                ]
            );

            $transaction = $user->addTransaction($data);

            if (!$transaction instanceof \App\Transaction) {
                throw new \Exception($transaction);
            }

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json(['error' => $exception->getMessage()], 500);
        }

        $transaction = $transaction->load('user');

        return response()->json(
            new TransactionUser($transaction)
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!is_numeric($id)) {
            return response()->status(400);
        }

        if ($transaction = Transaction::find($id)) {
            return response()->json(new \App\Http\Resources\Transaction($transaction));
        }

        return response()->noContent();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }
}
