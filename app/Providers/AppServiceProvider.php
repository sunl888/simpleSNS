<?php

namespace App\Providers;

use App\Repositories\VerificationCodeRepository;
use App\Services\SendSmsService;
use App\Services\SMSVerificationCode;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Support\ServiceProvider;
use League\Fractal\Manager as FractalManager;
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
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);

            /*\DB::listen(function ($query) {
                $sql = str_replace('?', '%s', $query->sql);
                foreach ($query->bindings as $binding) {
                    $binding = (string)$binding;
                }
                $sql = sprintf($sql, ...$query->bindings);
                \Log::info('sql', [$sql, $query->time, url()->current()]);
            });*/
        }

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
    }
}
