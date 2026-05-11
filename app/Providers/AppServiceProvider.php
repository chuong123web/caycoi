<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            $globalPlants = \App\Models\Plant::active()->get()->map(function($plant) {
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
            $view->with('globalPlants', $globalPlants);
        });
    }
}
