<?php

namespace App\Http\Controllers\Api\Vendor;

use App\Helpers\DebugHelpers;
use App\Http\Controllers\Api\Vendor\BaseApiController;

use App\Http\Resources\Admin\ArticleGroupMainTreeResource;
use App\Http\Resources\Admin\ArticleGroupResource;
use Illuminate\Http\Request;

use App\Models\ArticleGroup;

class ArticleGroupController extends BaseApiController
{
    public function index(Request $request)
    {
        try {
            $groups = ArticleGroup::where(function ($query) use ($request) {
                    if (!empty($request->group_code)) {
                        $query->where('code', $request->group_code);
                    }

                    if (!empty($request->search)) {
                        $query->where('title', 'like', "%{$request->search_text}%");
                    }

                    if (!empty($request->start_date)) {
                        $query->whereDate('created_at', '>=', $request->start_date);
                    }

                    if (!empty($request->end_date)) {
                        $query->whereDate('created_at', '<=', $request->end_date);
                    }
                })
                ->whereNull('parent_id')
                ->get();

            $tmp = ArticleGroupMainTreeResource::collection($groups);
            $tmp = json_decode(json_encode($tmp));
            $tmp = $this->flatten($tmp);

            return response()->json(['data' => $tmp], 200);

        } catch (\Exception $e) {
            $code = $e->getCode();
            $msg = $e->getMessage();
        }

        return response($msg, $code);
    }

    public function store(Request $request)
    {
        try {
            $parent_id  = $request->parent_id ?? null;
            $title      = $request->title;
            $code       = $request->code;
            $platform   = $request->platform;
            $language   = $request->language;

            $groups = ArticleGroup::createGroup($parent_id, $title, $code, $platform, $language);
            if ($groups) {
                return new ArticleGroupResource($groups);
            }

            return response()->json(['msg' => 'no content'], 201);

        } catch (\Exception $e) {
            $code = $e->getCode();
            $msg = $e->getMessage();
        }

        return response($msg, $code);
    }

    public function show(Request $request, $id)
    {
        try {
            $group = ArticleGroup::selectGroup($id);
            if ($group) {
                return new ArticleGroupResource($group);
            }

            return response()->json(['msg' => 'no content'], 202);

        } catch (\Exception $e) {
            $code = $e->getCode();
            $msg = $e->getMessage();
        }

        return response($msg, $code);
    }

    public function update(Request $request, $id)
    {
        try {
            $parent_id  = $request->parent_id ?? null;
            $title      = $request->title;
            $code       = $request->code;
            $platform   = $request->platform;
            $language   = $request->language;

            $group = ArticleGroup::updateGroup($id, $parent_id, $title, $code, $platform, $language);
            if ($group) {
                return new ArticleGroupResource($group);
            }

            return response()->json(['msg' => 'no content'], 201);

        } catch (\Exception $e) {
            $code = $e->getCode();
            $msg = $e->getMessage();
        }

        return response()->json(['code' => $code, 'msg' => $msg], $code);
    }

    public function destroy($id)
    {
        try {
            $group = ArticleGroup::deleteGroup($id);
            if ($group) {
                return new ArticleGroupResource($group);
            }

            return response()->json(['msg' => 'no content'], 202);

        } catch (\Exception $e) {
            $code = $e->getCode();
            $msg = $e->getMessage();
        }

        return response()->json(['code' => $code, 'msg' => $msg], $code);
    }

    public function flatten($elements)
    {
        $flatArray = array();

        foreach ($elements as $element) {
            if (is_array($element->childs)) {
                $flatArray[] = $element;
                $flatArray = array_merge($flatArray, $this->flatten($element->childs));
                unset($element->childs);
            } else {
                $flatArray[] = $element;
            }
        }

        return $flatArray;
    }

    public function tree(Request $request)
    {
        try {
//            if (!\Auth::guard('admin')->check()) {
//                throw new \Exception('Unauthenticated', 401);
//            }

            $parent_id = $request->parent_id;

            // 최상위 그룹 ID를 구하기
            $parent_root_id = ArticleGroup::groupRootId($parent_id);

            $groups = ArticleGroup::where(function ($query) use ($parent_root_id) {
                    if (!empty($parent_root_id)) {
                        $query->where('id', $parent_root_id);
                    }
                })
                ->get();

            $tmp = ArticleGroupMainTreeResource::collection($groups);
            $tmp = json_decode(json_encode($tmp));
            $tmp = $this->flatten($tmp);

            if (count($tmp) > 0 && !empty($request->$parent_id)) {
                unset($tmp[0]);
            }

            return response()->json(['data' => $tmp], 200);

        } catch (\Exception $e) {
            $code = $e->getCode();
            $msg = $e->getMessage();
        }

        return response($msg, $code);
    }
}
