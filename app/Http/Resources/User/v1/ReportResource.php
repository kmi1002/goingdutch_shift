<?php

namespace App\Http\Resources\Frontend\v1;

use Illuminate\Http\Resources\Json\Resource;

class ReportResource extends Resource
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
            'content'       => $this->content,
//            'answer'        => $this->answer,
            'ip'            => $this->ip,
            'state'         => $this->state,
            'user_id'       => $this->user_id,
//            'answer_id'     => $this->answer_id,
//            'slug'          => $this->slug,
        ];
    }
}
