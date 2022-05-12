<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class BalanceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'details' => $this->details,
            'amount' => $this->amount,
            'formatted_amount' => 'BDT ' . $this->amount,
            'method' => $this->method->name,
            'method_id' => $this->method_id,
            'created' => date('d M, Y h:ia', strtotime($this->created_at))
        ];
    }
}
