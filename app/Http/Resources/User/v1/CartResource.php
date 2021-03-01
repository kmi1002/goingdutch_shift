<?php

namespace App\Http\Resources\Frontend\v1;

use Illuminate\Http\Resources\Json\Resource;

class CartResource extends Resource
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
            'session_id'    => $this->session_id,
            'ip'            => $this->ip,
            'device'        => $this->device,
            'menu_id'       => $this->menu_id,
            'option_1'      => $this->option_1,
            'option_2'      => $this->option_2,
            'option_3'      => $this->option_3,
            'option_4'      => $this->option_4,
            'option_5'      => $this->option_5,
            'option_6'      => $this->option_6,
            'option_7'      => $this->option_7,
            'option_8'      => $this->option_8,
            'option_9'      => $this->option_9,
            'option_10'      => $this->option_10,
            'vendor_id'     => $this->vendor_id,
            'user_id'       => $this->user_id,
        ];
    }
}
