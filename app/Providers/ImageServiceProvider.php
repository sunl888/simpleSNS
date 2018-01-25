<?php

namespace App\Providers;

use App\Services\ImageService;
use Illuminate\Support\ServiceProvider;
use League\Glide\Responses\LaravelResponseFactory;
use League\Glide\ServerFactory;
use Storage;

class ImageServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(\League\Glide\Server::class, function () {
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

        $this->app->singleton(ImageService::class, function () {
            $config = config('images');
            return new ImageService($config);
        });
    }
}
