<?php namespace Mixtapes\Mixtapes;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
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
