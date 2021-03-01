<?php
use Illuminate\Database\Seeder;
use App\Models\ArticleGroup;
use App\Models\Tag;
use App\Models\Article;
use App\Models\File;
use App\Models\Click;
use App\Helpers\SlugHelper;

class PostsSeeder extends Seeder
{
    public function run()
    {
        /////////////////////////////////////////////////
        // 소개
        $row = [
            'title'         => '고객센터',
            'mobile_title'  => '고객센터',
            'code'          => 'support',
            'platform'      => 'web',
            'language'      => 'ko',
        ];
        $support = ArticleGroup::create($row);

        // 소개
        $row = [
            'title'         => '소개',
            'mobile_title'  => '소개',
            'code'          => 'introduce',
            'platform'      => 'web',
            'language'      => 'ko',
            'parent_id'     => $support->id,
        ];
        ArticleGroup::create($row);

        // 이용약관
        $row = [
            'title'         => '이용약관',
            'mobile_title'  => '이용약관',
            'code'          => 'terms',
            'platform'      => 'web',
            'language'      => 'ko',
            'parent_id'     => $support->id,
        ];
        ArticleGroup::create($row);

        // 개인정보취급방침
        $row = [
            'title'         => '개인정보취급방침',
            'mobile_title'  => '개인정보취급방침',
            'code'          => 'privacy',
            'platform'      => 'web',
            'language'      => 'ko',
            'parent_id'     => $support->id,
        ];
        ArticleGroup::create($row);

        // 공지사항
        $row = [
            'title'         => '공지사항',
            'mobile_title'  => '공지사항',
            'code'          => 'notice',
            'platform'      => 'web',
            'language'      => 'ko',
            'parent_id'     => $support->id,
        ];
        ArticleGroup::create($row);

        // 도움말
        $row = [
            'title'         => '도움말',
            'mobile_title'  => '도움말',
            'code'          => 'help',
            'platform'      => 'web',
            'language'      => 'ko',
            'parent_id'     => $support->id,
        ];
        ArticleGroup::create($row);
    }
}