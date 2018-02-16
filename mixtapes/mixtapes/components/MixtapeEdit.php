<?php namespace Mixtapes\Mixtapes\Components;

use Cms\Classes\ComponentBase;
use Input;
use Validator;
use Redirect;
use Flash;
use Auth;
use File;
use Request;
use ValidationException;

use Mixtapes\Mixtapes\Models\Mixtape;


class MixtapeEdit extends ComponentBase
{
    
    public function componentDetails()
    {
        return [
            'name' => 'Edit Mixtape',
            'description' => 'Edit user uploaded mixtape'
        ];
    }
    
    public function onRun(){
        $this->mixtape = $this->loadMixtape();
        $this->page['mixtape'] = $this->mixtape;
    }

    public function onUpdate(){
        dd("die");
    }
 
    protected function loadMixtape(){

        $id = Request::segment(4);
        $query = Mixtape::find($id);
        return $query;
    }

    public $mixtape;

}

?>