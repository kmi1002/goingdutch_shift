<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\Resource;

class SupportListResource extends Resource
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
            'id' => $this->id,
            'category' => $this->group->title ?? '',
            'platform' => $this->group->platform ?? '',
            'language' => $this->group->language ?? '',
            'title' => $this->title,
            'content' => $this->removeHtmlContent(),
            'name' => $this->getUserName(),
            'created_at' => $this->created_at->toDateTimeString(),
            'published_at' => $this->published_at,
        ];
    }
}