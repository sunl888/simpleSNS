<?php

namespace App\Providers;

use App\Repositories\VerificationCodeRepository;
use App\Services\PostService;
use App\Services\SendSmsService;
use App\Services\SlugGenerator;
use App\Services\SMSVerificationCode;
use App\Services\VisitorService;
use HTMLPurifier;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Support\ServiceProvider;
use League\Fractal\Manager as FractalManager;
use League\Glide\Responses\LaravelResponseFactory;
use League\Glide\ServerFactory;
use Overtrue\Socialite\SocialiteManager;
use Schema;
use Storage;

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
