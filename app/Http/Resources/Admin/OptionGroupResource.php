<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\Resource;
use App\Helpers\TimeHelper;

class OptionGroupResource extends Resource
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
            'title'         => $this->title,
            'priority'      => $this->priority,
            'active'        => $this->active,
            'parent_id'     => $this->parent_id,
            'vendor_id'     => $this->vendor_id,
            'created_at'    => TimeHelper::timestampToString($this->created_at),
            'updated_at'    => TimeHelper::timestampToString($this->updated_at),
            'deleted_at'    => TimeHelper::timestampToString($this->deleted_at),
        ];
    }
}