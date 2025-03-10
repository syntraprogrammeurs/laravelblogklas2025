<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class GlobalDataServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Globale cache-gegevens voor alle views beschikbaar maken
        View::composer('*', function ($view) {
            // Cache gebruikersstatistieken
            $totalUsers = Cache::remember('totalUsers', 600, fn() => User::count());
            $activeUsers = Cache::remember('activeUsers', 600, fn() => User::where('is_active', 1)->count());
            $inactiveUsers = $totalUsers - $activeUsers;

            // Cache post-statistieken
            $totalPosts = Cache::remember('totalPosts', 600, fn() => Post::count());
            $publishedPosts = Cache::remember('publishedPosts', 600, fn() => Post::where('is_published', 1)->count());
            $unpublishedPosts = $totalPosts - $publishedPosts;

            // Stuur deze data naar alle views
            $view->with(compact(
                'totalUsers', 'activeUsers', 'inactiveUsers',
                'totalPosts', 'publishedPosts', 'unpublishedPosts'
            ));
        });





    }
}
