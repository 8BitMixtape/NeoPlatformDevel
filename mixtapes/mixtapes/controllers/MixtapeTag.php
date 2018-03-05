<?php namespace Mixtapes\Mixtapes\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class MixtapeTag extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public function __construct()
    {
        parent::__construct();
    }
}
