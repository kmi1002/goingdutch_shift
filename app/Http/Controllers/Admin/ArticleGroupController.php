<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ArticleGroup;
use Illuminate\Http\Request;

class ArticleGroupController extends BaseAdminController
{
    public function index(Request $request)
    {
        $query = ArticleGroup::whereNull('parent_id');

        $groups = $query->get();
        $group = $query->where('code', '=', $request->type)->first();

        if ($group) {
            $title      = $group->title;
            $code       = $group->code;
            $parentId   = $group->id;
        } else {
            $title      = '생성';
            $code       = null;
            $parentId   = null;
        }

        return view('admin.article.group.index', compact('groups', 'title', 'code', 'parentId'));
    }
}