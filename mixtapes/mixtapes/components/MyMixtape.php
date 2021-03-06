<?php namespace Mixtapes\Mixtapes\Components;

use Cms\Classes\ComponentBase;
use Mixtapes\Mixtapes\Models\Mixtape;
use Input;
use Auth;
use Redirect;

class MyMixtape extends ComponentBase
{

    public function componentDetails(){
        return [
            'name' => 'MyMixtape',
            'description' => 'List of all current user mixtape'
        ];
    }

    public function onDelete(){
        $mixtape_id = (Input::get('id'));
        $mixtape = Mixtape::destroy($mixtape_id);
        return Redirect::refresh();
    }

    public function onRun(){
        $this->mixtapes = $this->loadMixtape();
    }

    protected function loadMixtape(){

        $user = Auth::getUser();        
        $options = [];
        $options['userid'] = $user->id;       
        $query =  Mixtape::listFrontEnd($options);        
        return $query;
    }

    public $mixtapes;

}