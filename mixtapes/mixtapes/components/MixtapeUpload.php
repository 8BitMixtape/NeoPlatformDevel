<?php namespace Mixtapes\Mixtapes\Components;

use Cms\Classes\ComponentBase;

use Mixtapes\Mixtapes\Models\Mixtape;
use Mixtapes\Mixtapes\Models\MixtapeTag;
use Mixtapes\Mixtapes\Classes\Flarum;

use Input;
use Validator;
use Redirect;
use Flash;
use Auth;
use File;
use ValidationException;
use Request;

class MixtapeUpload extends ComponentBase
{
    
    public function componentDetails()
    {
        return [
            'name' => 'Upload Form',
            'description' => 'Upload mixtape'
        ];
    }
    
    public function onRun(){
        $this->page['tags'] = $this->loadTags();
    }

    public function onSave(){

        $user = Auth::getUser();
        $zip = new \ZipArchive;
        $mixtape = new Mixtape();

        $form = Input::all();
        $hex_file = Input::file('hex_file');


        if($hex_file){

        $hex_filename = $hex_file->getClientOriginalName();
        $hex_path = $hex_file->getPathName();
        $hex_ino_filename = substr($hex_filename,0,-8); //remove .ino.zip
        
        $hex_wav_filename = $hex_ino_filename . '.wav';
        $hex_hex_filename = $hex_ino_filename . '.hex';
        $hex_main_filename = $hex_ino_filename . '.cpp';


            if ($zip->open($hex_path) === TRUE) {

                $wav_string = $zip->getFromName($hex_wav_filename);
                $hex_string = $zip->getFromName($hex_hex_filename);
                $main_string = $zip->getFromName($hex_main_filename);

                $result = preg_match('/(\/\*).*?(\*\/)|(\/\/).*?(\n)/s', $main_string, $matches, PREG_OFFSET_CAPTURE);

                if (($result > 0))
                {
                    $info_string = ($matches[0][0]);
                    $mixtape->info = $info_string;
                }
                        
                if ($wav_string)
                {
                    $extracted_wav_file = (new \System\Models\File)->fromData($wav_string, $hex_wav_filename);
                    $mixtape->wav_file = $extracted_wav_file;
                }

                if ($hex_string)
                {
                    $extracted_hex_file = (new \System\Models\File)->fromData($hex_string, $hex_hex_filename);
                    $mixtape->hex_file = $extracted_hex_file;
                }            

                if ($wav_string || $hex_string)
                {
                    $form['valid_zip_file'] = 1;
                }

                $zip->close();

            } else {
                Flash::error('Zip Extraction Failed!');
            }
            
        }


        Validator::extend('valid_tags', function($attribute, $value, $parameters) {
            $tags_input = $value;
            $tags_id = MixtapeTag::all()->lists('id');
            if( !is_array($tags_input)) $tags_input = [$tags_input];
            foreach ($tags_input as $tag_value) {
                if(!in_array($tag_value, $tags_id))
                    return false;
            }            
            return true;
        }, "Tags not valid");
        

        $validator = Validator::make(
            $form, [
               'name' => 'required',
               'description' => 'required',
               'hex_file' => 'required',
               'tags' => 'required|valid_tags'
            ]
        );


        $validator->sometimes('valid_zip_file', 'required', function($input) {
            if($input->hex_file === null)
            {
                return false;
            }else{
                return true;
            }
        });

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();;   
        }

        $flarum = new Flarum();
        $mixtape_url = url('/mixtape/detail',$mixtape->id);
        $flarum_msg = 'Synth name: ' . Input::get('name') . '\nUrl: ' . $mixtape_url . '\nDescription: \n\n\n\n' . Input::get('description');
        $flarum_res_arr = $flarum->createDiscussion($user->username, '[mixtape] ' . Input::get('name'), $flarum_msg);


        $flarum_id = $flarum_res_arr['discuss_id'];
        $flarum_post_id = $flarum_res_arr['post_id'];
        
        $mixtape->name = Input::get('name');
        $mixtape->description = Input::get('description');        
        $mixtape->user_id = $user->id;
        $mixtape->zip_file = $hex_file;
        $mixtape->flarum_id = $flarum_id;
        $mixtape->flarum_post_id = $flarum_post_id;

        $success = $mixtape->save();

        Flash::success('Mixtape added!');

        
        return Redirect::back();
     }
 
     protected function loadTags(){
        $query = MixtapeTag::all();
        return $query;
    }

     public $tags;
}

?>