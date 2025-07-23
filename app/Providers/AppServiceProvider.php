<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        if ($this->app->runningInConsole()) {
            $this->app->make(\Illuminate\Queue\QueueManager::class)->createPayloadUsing(function () {
                return ['auth' => auth()->check()];
            });
        }
    }
}
