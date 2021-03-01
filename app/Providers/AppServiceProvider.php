<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Models\Article;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application docker.
     *
     * @return void
     */
    public function boot()
    {
        // HTTPS 적용
        $this->app['request']->server->set('HTTPS', $this->app->environment() != 'local');


        // 글 생성시 slug를 자동으로 추가한다.
        Article::created(function($post) {
            if (!empty($post)) {
                $post->updateSlug();
            }
        });
    }

    /**
     * Register any application docker.
     *
     * @return void
     */
    public function register()
    {
        // 이것은 내가 컨트롤하는 곳이 아니다

        if ($this->app->environment() == 'local') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }
}
