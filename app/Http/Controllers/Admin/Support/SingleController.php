<?php

namespace App\Http\Controllers\Admin\Support;

use App\Http\Controllers\Admin\BaseAdminController;
use Illuminate\Http\Request;

use App\Models\Article;

class SingleController extends BaseAdminController
{
    public function index()
    {
        return view('admin.support.single.index');
    }

    public function create(Request $request)
    {
        $article = $this->getCS($request);
        return view('admin.support.single.create', ['article' => $article]);
    }

    public function getCS(Request $request)
    {
        try {
            return Article::with('group')
                ->where('id', $request->revision)
                ->firstOrFail();
        } catch (\Exception $e) {
            return null;
        }
    }
}