<?php

namespace App\Http\Resources\Admin;

use App\Helpers\TimeHelper;
use Illuminate\Http\Resources\Json\Resource;

class PaymentItemResource extends Resource
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
            'title'         => $this->title,
            'price'         => $this->price,
            'options'      => $this->optionString(),
        ];
    }
}
