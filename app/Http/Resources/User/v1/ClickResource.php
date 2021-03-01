<?php

namespace App\Http\Resources\Frontend\v1;

use Illuminate\Http\Resources\Json\Resource;

class ClickResource extends Resource
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
            'id'    => $this->id,
            'ip'    => $this->ip,
            'device'    => $this->device,
            'user_id' => $this->user_id,
            'created_at'    => $this->created_at->toDateTimeString(),
        ];
    }
}
