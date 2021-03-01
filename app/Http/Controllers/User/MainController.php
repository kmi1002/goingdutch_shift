<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        $vendors = Vendor::with('user')
            ->whereHas('user', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->get();
        return view('user.main.index', ['vendors' => $vendors]);
    }
}