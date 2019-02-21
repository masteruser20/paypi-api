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

    protected $appends = ['state'];

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
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'user_id');
    }

    /**
     * Create transaction related to current user
     * @param array $data
     * @return Model|\Illuminate\Http\JsonResponse
     */
    public function addTransaction(array $data)
    {
        $attributes = [];
        if (isset($data['provider_id'])) {
            $provider = PaymentProvider::find($data['provider_id']);
        } else {
            $provider = PaymentProvider::where('name', $data['provider'])->first();
            if (!$provider) {
                return response()->json(['error' => "Payment provider doesn't exists"], 500);
            }
        }

        $status = \App\Transaction::STATUSES[array_rand(\App\Transaction::STATUSES)];
        if(isset($data['attributes'])) {
            $attributes = $data['attributes'];
            $status = 'cancelled';
            $validAdditionalData = $provider->validateAdditionalData($attributes);
            if (!$validAdditionalData) {
                $status = 'cancelled';
            }
        }

        return $this->transactions()->create([
            'provider_id' => $provider->id,
            'type' => $data['type'],
            'amount' => $data['amount'],
            'currency' => $data['currency'],
            'status' => $status,
            'attributes' => $attributes
        ]);
    }

    public function getStateAttribute() {
        return '';
    }
}
