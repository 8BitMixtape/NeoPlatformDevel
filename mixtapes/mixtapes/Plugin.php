<?php namespace Mixtapes\Mixtapes;

use System\Classes\PluginBase;
use Mixtapes\Mixtapes\Classes\Flarum;

use Event;
use Input;

class Plugin extends PluginBase
{
    public function boot()
    {
        Event::listen('rainlab.user.login', function($user) {
            $flarum = new Flarum();
            $username = $user->username;
            $email = $user->email;
            $flarum->login($username, $email);
        });

        Event::listen('rainlab.user.logout', function($user) {
            $flarum = new Flarum();
            $flarum->logout();
        });

                /*
         * Look at session for locale using middleware
         */
        \Cms\Classes\CmsController::extend(function($controller) {
            $controller->middleware(\Mixtapes\Mixtapes\Classes\LocaleMiddleware::class);
        });
    }

    public function registerComponents()
    {
        return [
            'Mixtapes\Mixtapes\Components\MixtapeUpload' => 'mixtapeupload',
            'Mixtapes\Mixtapes\Components\MixtapeHex' => 'mixtapehex',
            'Mixtapes\Mixtapes\Components\MyMixtape' => 'mymixtape',            
            'Mixtapes\Mixtapes\Components\MixtapeEdit' => 'mixtapeedit'                        
        ];
    }

    public function registerSettings()
    {
    }
}
