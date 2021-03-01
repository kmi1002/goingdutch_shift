<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;

class BaseApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware(['role:administrator|manager|operator|analyst']);
    }
}