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

        $user = Auth::getUser();

        $this->mixtape = $this->loadMixtape();
        $this->page['mixtape'] = $this->mixtape;
        
        //todo use middleware
        if($user->id != $this->mixtape->user_id) {
            return Redirect::back();               
        }

    }

    public function onUpdate(){

        $zip = new \ZipArchive;

        $user = Auth::getUser();
        $id = Request::segment(4);
        $hex_file = Input::file('hex_file');

        $mixtape = Mixtape::find($id);

        if($user->id != $mixtape->user_id) {
            return Redirect::back();               
        }

        $validator = Validator::make(
            $form = Input::all(), [
               'name' => 'required',
               'description' => 'required',
            ]
        );

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();;   
        }
        
        $hex_file = Input::file('hex_file');

        

        $mixtape->name = Input::get('name');
        $mixtape->description = Input::get('description');
        $mixtape->save();

    }
 
    protected function loadMixtape(){
        $id = Request::segment(4);
        $query = Mixtape::find($id);
        
        return $query;
    }

    public $mixtape;

}

?>