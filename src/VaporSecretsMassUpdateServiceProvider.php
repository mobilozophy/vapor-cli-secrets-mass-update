<?php

namespace Mobilozophy\VaporSecretsMassUpdate;

use Illuminate\Support\ServiceProvider;
use Mobilozophy\VaporSecretsMassUpdate\SecretUpdateCommand;

class VaporSecretsMassUpdateServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    public function boot()
    {
        // Register the command if we are using the application via the CLI
        if ($this->app->runningInConsole()) {
            $this->commands([
                SecretUpdateCommand::class,
            ]);
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
    }
}
