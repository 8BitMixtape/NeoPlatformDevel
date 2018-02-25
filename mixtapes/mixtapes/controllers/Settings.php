<?php namespace Mixtapes\Mixtapes\Controllers;

use Mixtapes\Mixtapes\Models\Mixtape;
use Mixtapes\Mixtapes\Classes\Flarum;

use Backend\Classes\Controller;
use BackendMenu;
use Html;

class Settings extends Controller
{

    public function index()    // <=== Action method
    {
        $this->pageTitle = 'Mixtape - Sync';

    }

    public function onDoSomething()
    {        

        $flarum = new Flarum();

        
        $mixtapes = $this->loadMixtapeNotInForum();

        foreach ($mixtapes as $mixtape) {
           $mixtape_url = url('/mixtape/detail',$mixtape->id);
           $flarum_msg = "Synth name: " . $mixtape->name . "\nUrl: " . $mixtape_url . "\nDescription: \n\n\n\n" . ($mixtape->description);
           $flarum_id = $flarum->createDiscussion($mixtape->user->username, '[mixtape] ' . $mixtape->name, $flarum_msg);
           if ($flarum_id > 0)
           {
            $mixtape->flarum_id = $flarum_id;
            $mixtape->save();
           }
           sleep(10);
        }

        $this->vars['mixtapes'] = $mixtapes;

        return [
            '#myDiv' => $this->makePartial('mypartial')
        ];

    }


    protected function loadMixtapeNotInForum(){
        $query = Mixtape::where('flarum_id', '=', NULL)->get();
        return $query;
    }

    
}
