<?php namespace Yfktn\SelfAssCovid;

use System\Classes\PluginBase;
use System\Classes\PluginManager;
use Yfktn\SelfAssCovid\Controllers\SelfAssesmentCovid19;
use Yfktn\SelfAssCovid\Models\SelfAssCovid;
use Event;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
        return [
            'Yfktn\SelfAssCovid\Components\SelfAssCovid19' => 'selfAssCovid19'
        ];
    }

    public function boot()
    {
        // tambahkan link ke user supaya bisa meload username
        if(PluginManager::instance()->hasPlugin("RainLab.User")) {
            // ada plugin user
            SelfAssCovid::extend(function($model) {
                $model->belongsTo['user'] = [
                    'RainLab\User\Models\User',
                    'key' => 'user_id'
                ];
            });

            Event::listen('backend.list.extendColumns', function ($widget) {

                if (!$widget->getController() instanceof SelfAssesmentCovid19) {
                    return;
                }

                if (!$widget->model instanceof SelfAssCovid) {
                    return;
                }

                $widget->addColumns([
                    'user_nya' => [
                        'label' => 'Personil',
                        'relation' => 'user',
                        'searchable' => true,
                        'select' => "concat(username, ' (', surname , ')')"
                    ]
                ]);
            });
        }
    }

    public function registerSettings()
    {
    }
}
