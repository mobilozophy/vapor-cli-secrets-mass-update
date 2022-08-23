<?php
/*
 * Mobilozophy, LLC (https://mobilozophy.com)
 * 1324 Seven Springs Blvd
 * New Port Richey, FL 34655
 * Copyright (c) 2022.  - All Rights Reserved
 * This file is part of mzCONNECT by Mobilozophy. Unauthorized copying of this file, via any medium is strictly prohibited
 *  Proprietary and confidential
 */

namespace Mobilozophy\VaporSecretsMassUpdate;

use Illuminate\Support\ServiceProvider;
use Mobilozophy\Wifi\Console\SecretUpdateCommand;
use Mobilozophy\Wifi\Livewire\Partials\Slideovers\AddEditWifiProviderServiceSlideoverModal;
use Mobilozophy\Wifi\Livewire\Partials\Slideovers\EditWifiAccessPointSlideoverModal;
use Mobilozophy\Wifi\Livewire\WifiGuest\Login;
use Mobilozophy\Wifi\Livewire\WifiGuest\Registration;
use Mobilozophy\Wifi\Livewire\WifiGuest\WifiGuest;
use Mobilozophy\Wifi\Livewire\WMP\ManageWifiSettings;
use Mobilozophy\Wifi\Views\Components\WiFiGuestLayout;

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

        // Assets
        if ($this->app->runningInConsole()) {
            // Publish assets
            $this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/mobilozophy/wifi'),
            ], 'assets');

            $this->publishes([
                __DIR__.'/../config/mz-wifi.php' => base_path('config/mz-wifi.php'),
            ], 'config');
        }

        $this->mergeConfigFrom(__DIR__.'/../config/mz-wifi.php', 'mz-wifi');

        // Migrations
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        // Routes
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
        $this->loadRoutesFrom(__DIR__.'/../routes/captive-portal.php');

        // Views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'mz-wifi');

        $this->loadViewComponentsAs('mz-wifi', [
            WiFiGuestLayout::class,
        ]);

        // Livewire Components
        Livewire::component(
            'mz-wifi-manage-wifi-settings',
            ManageWifiSettings::class
        );
        Livewire::component(
            'mz-wifi-slideover-add-edit-providerService',
            AddEditWifiProviderServiceSlideoverModal::class
        );
        Livewire::component(
            'mz-wifi-slideover-edit-access-point',
            EditWifiAccessPointSlideoverModal::class
        );
        Livewire::component(
            'mz-wifi-guest',
            WifiGuest::class
        );

        Livewire::component(
            'mz-wifi-wifi-guest-registration',
            Registration::class
        );
        Livewire::component(
            'mz-wifi-wifi-guest-login',
            Login::class
        );
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('wifi', function ($app) {
            return new WifiProviderManager($app);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['wifi'];
    }
}
