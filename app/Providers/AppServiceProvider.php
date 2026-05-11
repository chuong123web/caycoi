<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Cache;

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
        // Force HTTPS in production (Railway serves via HTTPS but APP_URL may be http)
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        // Only load globalPlants for frontend views (NOT admin/filament)
        \Illuminate\Support\Facades\View::composer('layouts.app', function ($view) {
            $globalPlants = Cache::remember('global_plants', 300, function () {
                return \App\Models\Plant::active()->get()->map(function($plant) {
                    $img = $plant->image_url;

                    return [
                        'id' => $plant->slug,
                        'name' => $plant->name,
                        'vn' => $plant->name_vi ?: $plant->name,
                        'price' => $plant->price,
                        'tag' => $plant->tag,
                        'cat' => $plant->category,
                        'light' => $plant->light,
                        'img' => $img,
                        'description' => $plant->description,
                        'care_instructions' => $plant->care_instructions,
                    ];
                });
            });
            $view->with('globalPlants', $globalPlants);
        });
    }
}
