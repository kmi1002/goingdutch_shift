<?php

namespace App\Http\Resources\Admin;

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
            'role'          => $this->roleCode(),
            'role_name'     => $this->roleName(),
            'channel'   => $this->getUserProvider(),
            'name'      => $this->getUserName(),
            'email'     => $this->email,
            'gender'    => $this->gender,
            'age'       => $this->age,
            'log_count'  => $this->userLogs()->count(),
            'logined_at' => $this->lastLoginedAt(),
            'activated' => $this->isActivated(),
            'gender_age'     => $this->getGenderAndAge(),
            'created_at'    => TimeHelper::timestampToString($this->created_at),
            'deleted_at'    => TimeHelper::timestampToString($this->deleted_at),
        ];
    }
}