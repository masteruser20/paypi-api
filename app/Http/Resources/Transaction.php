<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Transaction extends JsonResource
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
            'user' => $this->user->id,
            'status' => $this->status,
            'start_time' => $this->start_time,
            'end_time'  => $this->end_time
        ];
    }
}
