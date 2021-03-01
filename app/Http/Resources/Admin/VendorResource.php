<?php

namespace App\Http\Resources\Admin;

use App\Helpers\TimeHelper;
use Illuminate\Http\Resources\Json\Resource;

class VendorResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $this
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'company'       => $this->company,
            'email'         => $this->email,
            'introduce'     => $this->introduce,
            'dpt_code'      => $this->dpt_code,
            'address'       => $this->address,
            'home_url'      => $this->home_url,
            'naver_url'     => $this->naver_url,
            'facebook_url'  => $this->facebook_url,
            'kakaoplus_url'    => $this->kakaoplus_url,
            'copyright'     => $this->copyright,
            'user'          => new UserResource($this->user)
        ];
    }
}