<?php

namespace App\Providers;

use App\Models\CreativeActivity;
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
        View::composer(['layouts.app', 'home', 'welcome'], function ($view) {
            $view->with('sharedActivities', CreativeActivity::all());
        });
    }
}
