<?php

namespace App\Http\Resources\Admin;

use App\Helpers\TimeHelper;
use Illuminate\Http\Resources\Json\Resource;

class ArticleGroupResource extends Resource
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
            'mobile_title'  => $this->mobile_title,
            'code'          => $this->code,
            'platform'      => $this->platform,
            'language'      => $this->language,
            'url'           => $this->url,
            'parent_id'     => $this->parent_id,
            'priority'      => $this->priority,
            'created_at'    => TimeHelper::timestampToString($this->created_at),
            'updated_at'    => TimeHelper::timestampToString($this->updated_at),
            'childs'        => ArticleGroupResource::collection($this->childs)
        ];
    }
}