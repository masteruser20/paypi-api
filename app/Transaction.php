<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Transaction extends Model
{
    const STATUSES = [
        'success',
        'failed',
        'error'
    ];

    /**
     * @var string
     */
    protected $table = 'transaction';

    /**
     * @var array
     */
    protected $fillable = [
        'provider_id',
        'type',
        'amount',
        'currency',
        'status',
        'user_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * Get the user that created the transaction.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @param $value
     * @return mixed
     */
    public function getProviderIdAttribute($value) {
        if($this->exists) {
            return PaymentProvider::find($value)->name;
        }

        return $value;
    }
}
