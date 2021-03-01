<?php

namespace App\Http\Controllers\Api\Vendor;

use Illuminate\Http\Request;
use App\Http\Resources\Vendor\RevisionResource;

use App\Models\Article;
use App\Models\ArticleGroup;

class SupportController extends ArticleController
{
    public function revision(Request $request, $group)
    {
        try {
            if (!\Auth::guard('admin')->check()) {
                throw new \Exception('Unauthenticated', 401);
            }

            $group_code = $request->group_code;
            $platform   = $request->platform;
            $language   = $request->language;

            // post_groups의 id를 찾는다
            $group_id = ArticleGroup::groupId($group_code, $platform, $language);

            $revisions = Article::with('groups')
                ->whereHas('groups', function ($query) use ($request, $group_id) {
                    $query->where('id', $group_id);
                })
                ->whereNull('parent_id')
                ->orderBy('id', 'desc')
                ->get();

            return RevisionResource::collection($revisions);

        } catch (\Exception $e) {
            $code = $e->getCode();
            $msg = $e->getMessage();
        }

        return response($msg, $code);
    }
}