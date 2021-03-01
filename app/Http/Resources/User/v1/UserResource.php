<?php

namespace App\Http\Resources\Frontend\v1;

use App\Helpers\TimeHelper;
use Illuminate\Http\Resources\Json\Resource;

class UserResource extends Resource
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
            'id'        => $this->id,
            'channel'   => $this->getUserProvider(),
            'name'      => $this->getUserName(),
            'email'     => $this->email,
            'gender'    => $this->gender,
            'age'       => $this->age,
            'log_count'  => $this->userLogs()->count(),
            'logined_at' => $this->lastLoginedAt(),
            'activated' => $this->getActivated(),
            'gender_age'     => $this->getGenderAndAge(),
            'created_at'    => TimeHelper::timestampToString($this->created_at),
            'profile_bg_path'    => $this->getProfileBg(),
            'profile_photo_path'    => $this->getProfilePhoto(),
            'krc_total' => $this->myPublishKrc() + $this->myShareKrc() + $this->myRecvCommentsKrc(),
        ];
    }
}
