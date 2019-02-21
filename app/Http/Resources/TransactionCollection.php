<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TransactionCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data'  => $this->collection,
            'pagination' => [
                'limit' => $this->perPage(),
                'page'  => $this->currentPage(),
                'order' => $this->additional['order']
            ],
            'count' => $this->additional['count']
        ];
    }
}
