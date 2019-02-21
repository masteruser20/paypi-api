<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class PaymentProvider extends Model
{
    /**
     * @var string
     */
    protected $table = 'provider';

    protected $casts = [
        'additional_data' => 'array',
        'types' => 'array'
    ];

    public static function boot()
    {
        parent::boot();

        self::updated(function () {
            Cache::forget('payment_methods');
        });
    }

    public function validateAdditionalData(array $attributes): bool {
        if(!$attributes || empty($attributes)) {
            return false;
        }

        foreach($this->additional_data as $fields) {
            if($fields['required'] && empty($attributes[$fields['name']])) {
                return false;
            }
        }

        return true;
    }
}
