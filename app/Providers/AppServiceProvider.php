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

        $this->app->singleton(\League\Glide\Server::class, function ($app) {
            $config = config('images');
            return ServerFactory::create([
                'response' => new LaravelResponseFactory($this->app->make('request')),
                'source' => Storage::disk($config['source_disk'])->getDriver(),
                'cache' => Storage::disk($config['cache_disk'])->getDriver(),
                'source_path_prefix' => $config['source_path_prefix'],
                'cache_path_prefix' => $config['cache_path_prefix'],
                'base_url' => $config['base_url'],
                'presets' => $config['presets'],
                'defaults' => $config['default_style']
            ]);
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
