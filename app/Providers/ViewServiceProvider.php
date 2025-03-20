<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
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
        // Controleer of de code niet draait in de console en of de tabellen bestaan
        if (! app()->runningInConsole() && Schema::hasTable('posts') && Schema::hasTable('categories')) {

            // Haal alleen gegevens op als de database klaar is
            $breakingNews = Post::published()
                ->latest()
                ->take(6)
                ->get();

            $categories = Category::withCount('posts')->having('posts_count', '>', 0)->get();

            // Deel deze variabelen met alle views
            View::share([
                'breakingNews' => $breakingNews,
                'categories' => $categories,
            ]);
        }
    }
}
