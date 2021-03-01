<?php

namespace App\Http\Resources\Admin;

use App\Helpers\TimeHelper;
use Illuminate\Http\Resources\Json\Resource;

class PaymentResource extends Resource
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
            'dpt_code'      => $this->dpt_code,
            'order_no'      => $this->order_no,
            'name'          => $this->name,
            'email'         => $this->email,
            'tel'           => $this->tel,
            'address'       => $this->address,
            'table_no'      => $this->table_no,
            'currency'      => $this->currency,
            'item'          => $this->item,
            'count'         => $this->count,
            'price'         => $this->price,
            'ip'            => $this->ip,
            'device'        => $this->device,
            'type'          => $this->type(),
            'data'          => $this->data,
            'status'        => $this->status,
            'result'        => $this->result,
            'message'       => $this->message,
            'user_id'       => $this->user_id,
            'created_at'    => TimeHelper::timestampToString($this->created_at),
            'items'         => PaymentItemResource::collection($this->paymentItems)
        ];
    }
}
