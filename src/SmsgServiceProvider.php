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
        $this->publishes([
        __DIR__.'./config/smsg.php' => config_path('smsg.php'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->mergeConfigFrom(
        __DIR__.'./config/smsg.php', 'smsg'
        );
        $this->app->make('Secrethash\Smsg\Smsg');
        require __DIR__ . "/HTTP/routes.php"; 

        $this->app['smsg'] = $this->app->share(function($app)
        {
            return new Smsg;
        });
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

}
