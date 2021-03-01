<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\Resource;
use App\Helpers\StringHelper;
use App\Helpers\TimeHelper;

class ArticleListResource extends Resource
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
            'category'      => $this->group->title ?? '',
            'group'         => $this->group->title ?? '',
            'platform'      => $this->group->platform ?? '',
            'language'      => $this->group->language ?? '',
            'title'         => StringHelper::plainText($this->title, 30),
            'click_cnt'     => $this->click_cnt,
            'like_cnt'      => $this->like_cnt,
            'dislike_cnt'   => $this->dislike_cnt,
            'comment_cnt'   => $this->comment_cnt,
            'share_cnt'     => $this->share_cnt,
            'report_cnt'    => $this->report_cnt,
            'name'          => $this->getUserName(),
            'slug'          => $this->url(),
            'created_at'    => TimeHelper::timestampToString($this->created_at),
            'updated_at'    => TimeHelper::timestampToString($this->updated_at),
            'published_at'  => TimeHelper::timestampToString($this->published_at)
        ];
    }
}