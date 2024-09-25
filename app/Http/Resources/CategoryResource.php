<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
          'id'=>$this->id,
          'name'=>$this->name,
          'total_amount'=>$this->total_amount,
          'percent'=>$this->percent,
          'icon'=>new IconResource($this->icon),
          'payments'=>CategoryPaymentResource::collection($this->payments),
        ];
    }
}
