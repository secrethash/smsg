<?php

namespace Secrethash\Smsg;

use Illuminate\Support\ServiceProvider;

use Symfony\Component\Finder\Finder;

use Illuminate\Filesystem\Filesystem;

class SmsgServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Publishes the Config File
        $configPath = __DIR__ . '/config/smsg.php';
        $this->publishes([$configPath => config_path('smsg.php')]);
        $this->mergeConfigFrom($configPath, 'smsg');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->make('Secrethash\Smsg\Smsg');
        // require __DIR__ . "/HTTP/routes.php"; 

        $this->bindFacade();
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('smsg');
    }

    private function bindFacade() {
        $this->app->bind('smsg', function($app) {
            return new smsg();
        });
    }

}
