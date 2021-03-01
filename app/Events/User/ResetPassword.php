<?php

namespace App\Events\User;

use Illuminate\Queue\SerializesModels;
use App\Models\User;

class ResetPassword
{
    use SerializesModels;

    /**
     * @var \App\Models\User
     */
    public $user;

    /**
     * @var string
     */
    public $token;

    /**
     * Create a new event instance.
     *
     * @param  \App\Models\User  $user
     * @param $token  String
     */
    public function __construct(User $user, String $token)
    {
        $this->user     = $user;
        $this->token    = $token;
    }
}