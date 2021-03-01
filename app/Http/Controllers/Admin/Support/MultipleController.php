<?php

namespace App\Http\Controllers\Admin\Support;

use App\Http\Controllers\Admin\BaseAdminController;
use Illuminate\Http\Request;

use App\Models\Article;

class MultipleController extends BaseAdminController
{
    public function index()
    {
        return view('admin.support.multiple.index');
    }

    public function create()
    {
        return view('admin.support.multiple.create');
    }

    public function show(Request $request, $id)
    {
        $article = Article::with('groups')->findOrFail($id);
        return view('admin.support.multiple.show', compact('article'));
    }

    public function edit(Request $request, $id)
    {
        $article = Article::with('groups')->findOrFail($id);
        return view('admin.support.multiple.edit',compact('article'));
    }

}