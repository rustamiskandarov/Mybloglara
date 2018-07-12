<?php

namespace App\Providers;

use App\Post;
use App\Category;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('sidebar', function ($view){
            $view->with('popularPosts', Post::getPopularPosts());//вернёт 3 популярные статьи
            $view->with('featuredPosts', Post::getFeaturedPosts());//вернёт 3 рекомендованных поста
            $view->with('recentPosts', Post::getRecentPosts());//вернёт 4 последние по дате статьи
            $view->with('categories', Category::all());
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
