<?php

/*
 * add .styleci.yml
 */

namespace App\Providers;

use HTMLPurifier;
use App\Services\PostService;
use App\Services\SlugGenerator;
use App\Services\SendSmsService;
use App\Services\VisitorService;
use Illuminate\Hashing\BcryptHasher;
use App\Services\SMSVerificationCode;
use Illuminate\Support\ServiceProvider;
use Overtrue\Socialite\SocialiteManager;
use League\Fractal\Manager as FractalManager;
use App\Repositories\VerificationCodeRepository;

class ServiceServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(SMSVerificationCode::class, function ($app) {
            return new SMSVerificationCode(
                app(VerificationCodeRepository::class),
                app(BcryptHasher::class),
                config('alidayu'));
        });

        $this->app->singleton(SendSmsService::class, function ($app) {
            return new SendSmsService(config('alidayu'));
        });

        $this->app->singleton(FractalManager::class, function ($app) {
            return new FractalManager();
        });

        $this->app->singleton(PostService::class, function () {
            return new PostService();
        });

        $this->app->singleton(VisitorService::class, function ($app) {
            return new VisitorService($app->make('request'));
        });

        $this->app->singleton(SlugGenerator::class, function () {
            return new SlugGenerator();
        });

        $this->app->singleton(HTMLPurifier::class, function ($app) {
            return new HTMLPurifier($app['files']);
        });

        $this->app->singleton(SocialiteManager::class, function ($app) {
            return new SocialiteManager(
                array_merge(
                    config('socialite', []),
                    config('services', [])
                ), $app->make('request'));
        });
    }
}
