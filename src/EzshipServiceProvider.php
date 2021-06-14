<?php

namespace Hosomikai\Ezship;

use Illuminate\Support\ServiceProvider;

class EzshipServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'ezship');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'ezship');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
            $this->registerConsoleCommands();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/ezship.php', 'ezship');

        // Register the service the package provides.
        $this->app->singleton('ezship', function ($app) {
            return new Ezship();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['ezship'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__ . '/../config/ezship.php' => config_path('ezship.php'),
        ], 'ezship.config');

        //publish migration
        $this->publishes([
            __DIR__ . '/../database/migrations/' => database_path('migrations'),
        ], 'ezship.migrations');

        // Publishing the views.
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/ezship'),
        ], 'ezship.views');

        // Publishing the translation files.
        $this->publishes([
            __DIR__ . '/../resources/lang' => resource_path('lang/vendor/ezship'),
        ], 'ezship.lang');
    }

    protected function registerConsoleCommands()
    {
    }
}
