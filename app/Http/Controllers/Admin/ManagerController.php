<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;

class ManagerController extends BaseAdminController
{
    var $roles = ['administrator', 'manager', 'operator', 'analyst'];

    public function index()
    {
        $roles = User::rolesCount($this->roles);

        return view('admin.manager.index', compact('roles'));
    }
}