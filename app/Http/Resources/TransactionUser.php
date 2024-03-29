<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionUser extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'provider' => $this->provider_id,
            'type' => $this->type,
            'amount' => $this->amount,
            'currency' => $this->currency,
            'status'    => $this->status,
            'user' => $this->user,
        ];
    }
}
