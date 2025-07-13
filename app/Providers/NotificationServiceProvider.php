<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\User;

class NotificationServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        View::composer('layouts.app', function ($view) {
            if (auth()->check()) {
                $unreadNotifications = auth()->user()->unreadNotifications()->latest()->take(5)->get();
                $view->with('unreadNotifications', $unreadNotifications);
            } else {
                $view->with('unreadNotifications', collect([]));
            }
        });
    }
} 