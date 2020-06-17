<?php namespace Yfktn\SelfAssCovid\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class SelfAssesmentCovid19 extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController'    ];
    
    public $listConfig = 'config_list.yaml';

    public $requiredPermissions = [
        'yfktn_selfasscovid_man' 
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Yfktn.SelfAssCovid', 'self-ass-covid-menu');
    }
}
