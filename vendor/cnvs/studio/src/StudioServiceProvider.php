<?php

namespace Studio;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use Studio\Console\InstallCommand;

class StudioServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register the package services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/studio.php' => config_path('studio.php'),
            ], 'studio-config');

            $this->mergeConfigFrom(
                __DIR__.'/../config/studio.php', 'studio'
            );

            $this->commands([
                InstallCommand::class,
            ]);
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            InstallCommand::class,
        ];
    }
}
