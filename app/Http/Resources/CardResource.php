<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CardResource extends JsonResource
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
            "id" => $this->id,
            "address_city" => $this->address_city,
            "address_country" => $this->address_country,
            "address_line1" => $this->address_line1,
            "address_line2" => $this->address_line2,
            "address_state" => $this->address_state,
            "address_zip" => $this->address_zip,
            "brand" => $this->brand,
            "country" => $this->country,
            "cvc_check" => $this->cvc_check,
            "exp_month" => $this->exp_month,
            "exp_year" => $this->exp_year,
            "last4" => $this->last4,
            "name" => $this->name,
        ];
    }
}
