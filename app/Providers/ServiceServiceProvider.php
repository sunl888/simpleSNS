<?php

namespace App\Providers;

use App\Repositories\VerificationCodeRepository;
use App\Services\SendSmsService;
use App\Services\SMSVerificationCode;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Support\ServiceProvider;

class ServiceServiceProvider extends ServiceProvider
{

    public function boot()
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

    }
}
