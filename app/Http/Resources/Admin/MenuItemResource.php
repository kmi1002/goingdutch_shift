<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\Resource;
use App\Helpers\TimeHelper;

class MenuItemResource extends Resource
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
            'id'                => $this->id,
            'group'             => $this->menuGroup->title,
            'code'              => $this->code,
            'title'             => $this->title,
            'sub_title'         => $this->sub_title,
            'description'       => $this->description,
            'caution'           => $this->caution,
            'original_price'    => $this->original_price,
            'discount_price'    => $this->discount_price,
            'discount_percent'  => $this->discount_percent,
            'recommend'         => $this->recommend,
            'active'            => $this->active,
            'priority'          => $this->priority,
            'group_id'          => $this->group_id,
            'created_at'        => TimeHelper::timestampToString($this->created_at),
            'updated_at'        => TimeHelper::timestampToString($this->updated_at),
            'deleted_at'        => TimeHelper::timestampToString($this->deleted_at),
        ];
    }
}