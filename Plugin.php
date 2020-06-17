<?php namespace Yfktn\SelfAssCovid;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
        return [
            'Yfktn\SelfAssCovid\Components\SelfAssCovid19' => 'selfAssCovid19'
        ];
    }

    public function registerSettings()
    {
    }
}
