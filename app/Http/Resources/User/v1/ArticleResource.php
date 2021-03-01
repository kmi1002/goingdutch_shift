<?php

namespace App\Http\Resources\Frontend\v1;

use Illuminate\Http\Resources\Json\Resource;

class ArticleResource extends Resource
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
            'name'    => $this->nick_name ?? $this->users->nick_name,
            'title'    => $this->title,
            'thumbnail' => $this->thumbnail(),
            'time_ago' => $this->timeAgo(),
            'krc_total' => $this->krc,
            'like_cnt' => $this->like_cnt,
            'comment_cnt' => $this->comment_cnt,
            'share_cnt' => $this->share_cnt,
            'slug'      => $this->url(),
            'clicks_count' => $this->clicks_count, // 지금은 안 쓰이긴 함.
            'tmp_click_cnt' => $this->totalClickCount(),  // 지금은 안 쓰이긴 함.
            'calibrated_like_cnt' => $this->getCalibratedLike()
        ];
    }
}
