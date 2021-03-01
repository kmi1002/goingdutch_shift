<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\TimeHelper;
use App\Http\Controllers\Api\Admin\BaseApiController;
use Illuminate\Http\Request;
use App\Http\Resources\Admin\ArticleListResource;
use App\Http\Resources\Admin\ArticleItemResource;

use App\Models\Article;
use App\Models\ArticleGroup;
use App\Models\Click;
use App\Helpers\IPHelper;
use App\Models\File;

use App\Models\Tag;

use Browser;

class ArticleController extends BaseApiController
{
    public function index(Request $request)
    {
        try {
//            if (!\Auth::guard('admin')->check()) {
//                throw new \Exception('Unauthenticated', 401);
//            }

            $group          = $request->group;
            $page           = $request->page;
            $per_page       = $request->per_page;

            $is_published   = $request->is_published;

            // 관리자용 post_groups의 id를 찾는다
            $platform       = $request->platform ?? null;
            $language       = $request->language ?? null;

            $group_ids  = ArticleGroup::groupId($group, $platform, $language);

            // sub_group의 type이 중복될 가능성이 존재한다.
            $query = Article::with('files', 'tags', 'groups', 'parent')
                ->where(function ($query) use ($group_ids, $request, $is_published) {
                    $query->where('group_id', $group_ids);

                    if ($is_published == 'publish') {
                        $query->whereNotNull('published_at');
                    } else if ($is_published == 'temporary') {
                        $query->whereNull('published_at');
                    }

                    if (!empty($request->start_date)) {
                        $query->whereDate('created_at', '>=', $request->start_date);
                    }

                    if (!empty($request->end_date)) {
                        $query->whereDate('created_at', '<=', $request->end_date);
                    }
                })
                ->orderBy('posts.id', 'desc');

            // 검색어 필터
            if (!empty($request->search)) {
                $query = $query->join('users', 'user_id', '=', 'users.id')
                    ->where(function ($query) use ($request) {
                        $query->where('title', 'like', "%{$request->search}%")
                            ->orWhere('content', 'like', "%{$request->search}%")
                            ->orWhere('users.nick_name', 'like', "%{$request->search}%");
                    })->select('posts.*');
            }

            $article = $query->paginate($per_page, ['*'], 'page', $page);

            return ArticleListResource::collection($article);

        } catch (\Exception $e) {

            $code = $e->getCode();
            $msg = $e->getMessage();
        }

        return response($msg, $code);
    }

    public function store(Request $request)
    {
        try {
//            if (!\Auth::guard('admin')->check()) {
//                return response()->json('Unauthenticated', 200);
//            }
//
            // 사용자 정보
            $user = \Auth::guard('admin')->user();
            $user_id = $user->id;

            $group          = $request->group;

            // 글 데이터
            $title          = $request->title ?? null;
            $content        = $request->description ?? null;
            $link           = $request->link ?? null;
            $nick_name      = $request->nick_name ?? null;
            $email          = $request->email ?? null;
            $homepage       = $request->homepage ?? 0;
            $html           = $request->html ?? 0;
            $secret         = $request->secret ?? 0;
            $notice         = $request->notice ?? 0;
            $hide_comment   = $request->hide_comment ?? 0;
            $recevied_email = $request->recevied_email ?? 0;
            $parent_id      = $request->parent_id ?? null;

            // 추가 글 데이터
            $publish        = $request->publish ?? null;
            $cover          = $request->cover ?? null;
//            $youtube_tags   = $request->youtube_tags;
            $tags           = $request->tags;

            // 관리자용 post_groups의 id를 찾는다
            $platform       = $request->platform ?? null;
            $language       = $request->language ?? null;

            $group_id = ArticleGroup::groupId($group, $platform, $language);

            // 발행 & 임시저장을 구분한다
            $published_at = null;
            if ($publish == 'publish') {
                $published_at = TimeHelper::nowToString();
            }

            // parent_id를 기준으로 댓글을 판단한다
            if ($parent_id) {
                $parent_article = Article::findOrFail($parent_id);

                // 부모의 Group Id를 상속한다.
                $group_id = $parent_article->group_id;

                // 댓글
                Article::comment($parent_article);
            }

            // 글 생성
            $article = Article::create([
                'title'             => $title,
                'content'           => $content,
                'link'              => $link ?? null,
                'nick_name'         => $nick_name,
                'email'             => $email,
                'homepage'          => $homepage,
                'html'              => $html,
                'secret'            => $secret,
                'notice'            => $notice,
                'hide_comment'      => $hide_comment,
                'recevied_email'    => $recevied_email,
                'ip'                => IPHelper::realIP(),
                'device'            => Browser::platformName(),
                'user_id'           => $user_id,
                'group_id'          => $group_id,
                'parent_id'         => $parent_id,
                'published_at'      => $published_at,
            ]);

            // 태그 연결
            Tag::tag($article, $tags, 'article', $user_id);

//            //  유튜브 태그 연결
//            Tag::tag($article, $youtube_tags, 'youtube', $user_id);

            // 표지 등록
//            File::cover($article, $cover, $content);

            return new ArticleItemResource($article);

        } catch (\Exception $e) {
            $code = $e->getCode();
            $msg = $e->getMessage();
        }

        return response($msg, $code);
    }

    public function update(Request $request, $id)
    {
        try {
//            if (!\Auth::guard('admin')->check()) {
//                return response()->json('Unauthenticated', 200);
//            }

            // 사용자 정보
            $user = \Auth::guard('admin')->user();
            $user_id = $user->id;

            $update_type    = $request->update_type ?? 'modify';
            $title          = $request->title ?? null;
            $content        = $request->description ?? null;
            $cover          = $request->cover ?? null;
            $published_at   = TimeHelper::nowToString();

            $article = Article::findOrFail($id);

            switch($update_type) {
                case 'publish' : // 게시
                    $article->published_at  = $published_at;
                    break;

                case 'temporary' : // 임시 저장
                    $article->published_at  = null;
                    break;

                default: // 수정
                    $article->title         = $title;
                    $article->content       = $content;
                    break;
            }

            // DB 저장
            $article->save();

            // 표시를 다시 등록하는 경우
            if ($cover) {
                // article과 연결 된 파일을 연결 해제하고 삭제
                File::detachAndDeleteFiles($article);

                // 표지 다시 등록
                File::cover($article, $cover, $content);
            }

            return new ArticleItemResource($article);

        } catch (\Exception $e) {
            $code = $e->getCode();
            $msg = $e->getMessage();
        }

        return response($msg, $code);
    }

    public function show(Request $request, $id)
    {
        try {
            if (!\Auth::guard('admin')->check()) {
                throw new \Exception('Unauthenticated', 401);
            }

            $article = Article::with('groups')->where('id', $id)->firstOrFail();
            return new ArticleItemResource($article);

        } catch (\Exception $e) {
            $code = $e->getCode();
            $msg = $e->getMessage();
        }

        return response($msg, $code);
    }

    public function destroy($id)
    {
        try {
            if (!\Auth::guard('admin')->check()) {
                throw new \Exception('Unauthenticated', 401);
            }

            $article = Article::where('id', $id)->firstOrFail();

            if ($article) {

                // article과 연결 된 파일을 연결 해제하고 삭제
                File::detachAndDeleteFiles($article);

                // article 삭제
                $article->delete();

                return new ArticleItemResource($article);
            }

            return response()->json(['msg' => 'no content'], 204);


        } catch (\Exception $e) {
            $code = $e->getCode();
            $msg = $e->getMessage();
        }

        return response()->json(['code' => $code, 'msg' => $msg], $code);
    }
}