<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Observers\FileModelObserver;
use App\Models\FileModel;

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
        FileModel::observe(FileModelObserver::class);
    }
}
