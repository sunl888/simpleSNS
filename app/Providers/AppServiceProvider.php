<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            // IdeHelper
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);

            \DB::listen(function ($query) {
                $sql = str_replace('?', '%s', $query->sql);
                foreach ($query->bindings as $binding) {
                    $binding = (string)$binding;
                }
                $sql = sprintf($sql, ...$query->bindings);
                \Log::info('sql', [$sql, $query->time, url()->current()]);
            });
        }

    }
}
