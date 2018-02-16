<?php namespace Mixtapes\Mixtapes\Components;

use Cms\Classes\ComponentBase;
use Mixtapes\Mixtapes\Models\Mixtape;
use Input;

class MixtapeHex extends ComponentBase
{

    public function componentDetails(){
        return [
            'name' => 'MixtapeHex',
            'description' => 'Get Mixtape Hex attachment'
        ];
    }


    public function onRun(){
        ($this->mixtapes = $this->loadMixtape());
    }

    protected function loadMixtape(){

        $id = $this->param('id');
        $query = Mixtape::find($id);
        return $query;
    }

    public $mixtapes;

}