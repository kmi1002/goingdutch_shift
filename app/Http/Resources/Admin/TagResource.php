<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\Resource;

class TagResource extends Resource
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
            'id'            => $this->id,
            'name'          => $this->name,
            'slug'          => $this->slug,
            'state_main'    => $this->state_main,
            'state_open'    => $this->state_open,
            'user_name'     => $this->users->getUserName(),
            'created_at'    => $this->created_at->toDateTimeString(),
        ];
    }
}