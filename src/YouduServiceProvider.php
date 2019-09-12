<?php

namespace Huangdijia\Youdu;

use App\Channels\YouduChannel;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\ServiceProvider;

class YouduServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__ . '/../config/youdu.php' => $this->app->basePath('config/youdu.php')]);
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/youdu.php', 'youdu');

        foreach (config('youdu.apps', []) as $name => $config) {
            $this->app->singleton('youdu.' . $name, function () use ($config) {
                return new Youdu(config('youdu.api'), (int) config('youdu.buin'), $config['app_id'], $config['ase_key']);
            });
        }

        $this->app->make(ChannelManager::class)->extend('youdu', function ($app) {
            return $app->make(YouduChannel::class);
        });
    }

    public function provides()
    {
        return collect(config('youdu.apps', []))
            ->transform(function ($item, $name) {
                return 'youdu.' . $name;
            })
            ->all();
    }
}
