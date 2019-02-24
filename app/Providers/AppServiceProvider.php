<?php

namespace App\Providers;

use App\Models\Configure;
use App\Models\Record;
use App\Observers\ConfigureObserver;
use App\Observers\RecordObserver;
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
        Record::observe(RecordObserver::class);
        Configure::observe(ConfigureObserver::class);
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
