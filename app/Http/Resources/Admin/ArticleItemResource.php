<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\Resource;
use App\Helpers\TimeHelper;

class ArticleItemResource extends Resource
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
            'category'      => $this->groups->title ?? '',
            'group'         => $this->groups->title ?? '',
            'platform'      => $this->groups->platform ?? '',
            'language'      => $this->groups->language ?? '',
            'title'         => $this->title ?? '',
            'content'       => $this->content ?? 0,
            'click_cnt'     => $this->click_cnt ?? 0,
            'like_cnt'      => $this->like_cnt ?? 0,
            'dislike_cnt'   => $this->dislike_cnt ?? 0,
            'comment_cnt'   => $this->comment_cnt ?? 0,
            'share_cnt'     => $this->share_cnt ?? 0,
            'report_cnt'    => $this->report_cnt ?? 0,
            'name'          => $this->getUserName(),
            'created_at'    => TimeHelper::timestampToString($this->created_at),
        ];
    }
}