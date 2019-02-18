<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Transaction;

class User extends Model
{
    /**
     * @var string
     */
    protected $table = 'user';

    /**
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'gender',
        'email',
        'address',
        'city',
        'zip',
        'country_code',
        'birthday',
    ];

    /**
     * Returns transactions created by user
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions() {
        return $this->hasMany(Transaction::class, 'user_id');
    }

    /**
     * Create transaction related to current user
     * @param array $data
     * @return Model|\Illuminate\Http\JsonResponse
     */
    public function addTransaction(array $data) {
        $provider = PaymentProvider::select('id')->where('name', $data['provider'])->first();
        if (!$provider) {
            return response()->json(['error' => "Payment provider doesn't exists"], 500);
        }

        return $this->transactions()->create([
            'provider_id' => $provider->id,
            'type' => $data['type'],
            'amount' => $data['amount'],
            'currency' => $data['currency'],
            'status' => \App\Transaction::STATUSES[array_rand(\App\Transaction::STATUSES)]
        ]);
    }
}
