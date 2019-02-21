<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Validation extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $error = ['isEmpty' => 'Value is required and can\'t be empty'];
        return [
            'validation_messages' => [
                'provider' => $this->when($this->resource->get('provider'), $error),
                'type' => $this->when($this->resource->get('type'), $error),
                'amount' => $this->when($this->resource->get('amount'), $error),
                'currency' => $this->when($this->resource->get('currency'), $error),
                'user' => [
                    'first_name' => $this->when($this->resource->get('user.first_name'), $error),
                    'last_name' => $this->when($this->resource->get('user.last_name'), $error),
                    'email' => $this->when($this->resource->get('user.email'), $error),
                    'gender' => $this->when($this->resource->get('user.gender'), $error),
                    'address' => $this->when($this->resource->get('user.address'), $error),
                    'city' => $this->when($this->resource->get('user.city'), $error),
                    'zip' => $this->when($this->resource->get('user.zip'), $error),
                    'country_code' => $this->when($this->resource->get('user.country_code'), $error),
                    'birthday' => $this->when($this->resource->get('user.birthday'), $error),
                ]
            ]
        ];
    }
}
