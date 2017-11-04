<?php

namespace Tokenly\TokenpassClient\Provider;

use Exception;
use Laravel\Socialite\SocialiteServiceProvider;
use Tokenly\TokenpassClient\Socialite\TokenpassSocialiteManager;
use Tokenly\TokenpassClient\Tokenpass;
use Tokenly\TokenpassClient\TokenpassAPI;

/**
* 
*/
class TokenpassServiceProvider extends SocialiteServiceProvider
{
    
    public function boot() {
        $config_source = realpath(__DIR__.'/../../config/tokenpass.php');
        $this->publishes([$config_source => config_path('tokenpass.php')], 'config');
    }

    public function register() {
        $this->app->bind('tokenpass', function($app) {
            return new Tokenpass();
        });

        $this->app->bind('Tokenly\TokenpassClient\TokenpassAPI', function($app) {
            return new TokenpassAPI();
        });

        $this->app->bind('Laravel\Socialite\Contracts\Factory', function ($app) {
            return new TokenpassSocialiteManager($app);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['Laravel\Socialite\Contracts\Factory'];
    }

}
