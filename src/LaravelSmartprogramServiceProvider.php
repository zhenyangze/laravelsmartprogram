<?php

namespace yangze\LaravelSmartprogram;

use Illuminate\Support\ServiceProvider;
use yangze\LaravelSmartprogram\Baidu\Payment;
use yangze\LaravelSmartprogram\Baidu\SmartProgram;

class LaravelSmartprogramServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'yangze');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'yangze');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laravelsmartprogram.php', 'laravelsmartprogram');

        // Register the service the package provides.
          
        $apps = [
            'smart_program' => SmartProgram::class,
            'payment' => Payment::class,
        ];
        foreach($apps as $type => $class) {
            if (empty(config('laravelsmartprogram.' . $type))) {
                continue;
            }
            foreach(config('laravelsmartprogram.' . $type) as $account => $config) {
                $name = 'laravelsmartprogram.' . $type . $account;
                $this->app->singleton($name, function() use ($class, $config) {
                    return new $class($config);
                });

                $name = 'baidu.'  .$type . $account;
                $this->app->singleton($name, function() use ($class, $config) {
                    return new $class($config);
                });
            }
            $this->app->alias('laravelsmartprogram.' . $type . 'default', 'laravelsmartprogram.' . $type);
            $this->app->alias('baidu.' . $type . 'default', 'baidu.' . $type);
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['laravelsmartprogram'];
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
            __DIR__.'/../config/laravelsmartprogram.php' => config_path('laravelsmartprogram.php'),
        ], 'laravelsmartprogram.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/yangze'),
        ], 'laravelsmartprogram.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/yangze'),
        ], 'laravelsmartprogram.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/yangze'),
        ], 'laravelsmartprogram.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
