<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LoanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->resource->getOriginal('id'),
            'title' => $this->resource->getOriginal('title'),
            'amount' => $this->resource->getOriginal('amount'),
            'formatted_amount' => 'BDT ' . $this->resource->getOriginal('amount'),
            'type' => $this->resource->getOriginal('type'),
            'returned' => $this->resource->getOriginal('returned'),
            'created' => date('d M, Y h:ia', strtotime($this->resource->getOriginal('created_at')))
        ];
    }
}
