<?php

namespace App\Http\Resources\Frontend\v1;


use Illuminate\Http\Resources\Json\Resource;

class ShareResource extends Resource
{
    var $isExisted = 0;

    public function __construct($resource, $isExisted)
    {
        parent::__construct($resource);
        $this->isExisted = $isExisted;
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
            'id'    => $this->id,
            'provider'    => $this->provider,
            'ip'    => $this->ip,
            'device'    => $this->device,
            'url'    => (env('APP_SHARE_URL') . '/share/' . $this->share_key),
            'user_id' => $this->user_id,
            'created_at'    =>  ($this->isExisted) ? $this->created_at : $this->created_at->toDateTimeString(),
            // 'created_at'    =>  ($this->created_at instanceof \Carbon\Carbon) ? $this->created_at->toDateTimeString() : $this->created_at,
            'is_existed' => $this->isExisted
        ];
    }   
}
