<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Tag;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;

class AppServiceProvider extends ServiceProvider
{


    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('article-search', function (Request $request) {
        return Limit::perMinute(10)->by($request->ip());
        });

        Event::listen(Login::class, function (Login $event): void {
            Log::info('auth.login', [
            'user_id' => $event->user->getAuthIdentifier(),
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
                ]);
            });

        Event::listen(Registered::class, function (Registered $event): void {
            Log::info('auth.registered', [
                'user_id' => $event->user->getAuthIdentifier(),
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        });

        Event::listen(Logout::class, function (Logout $event): void {
            Log::info('auth.logout', [
                'user_id' => $event->user?->getAuthIdentifier(),
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
});
        if(Schema::hasTable('categories')){
            $categories = Category::all();
            View::share(['categories' => $categories]);
        }
        if(Schema::hasTable('tags')){
            $tags = Tag::all();
            View::share(['tags' => $tags]);
        }
    }
}
