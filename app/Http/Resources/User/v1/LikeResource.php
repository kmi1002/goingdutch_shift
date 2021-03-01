<?php

namespace App\Http\Resources\Frontend\v1;

use Illuminate\Http\Resources\Json\Resource;
use App\Models\Like;

class LikeResource extends Resource
{
    var $cnt = 0;

    public function __construct($resource, $cnt, $krc)
    {
        parent::__construct($resource);

        $this->cnt = $cnt;
        $this->krc = $krc;

    }

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
            'ip'            => $this->ip,
            'device'        => $this->device,
            'user_id'       => $this->user_id,
            'created_at'    => $this->created_at,
            'like_cnt'      => $this->cnt,
            'krc_total'     => $this->krc
        ];
    }
}
