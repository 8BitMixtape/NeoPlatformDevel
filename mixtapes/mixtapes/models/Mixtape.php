<?php namespace Mixtapes\Mixtapes\Models;

use Model;

/**
 * Model
 */
class Mixtape extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = true;

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'mixtapes_mixtapes_';

    public $belongsToMany = [
        'tags' => [
            'Mixtapes\Mixtapes\Models\MixtapeTag',
            'table'    => 'mixtapes_mixtapes_tags'
        ]
    ];


    public $belongsTo = [
        'user' => 'RainLab\User\Models\User'
    ];

    public $attachOne = [
        'hex_file' => 'System\Models\File',
        'wav_file' => 'System\Models\File',
        'zip_file' => 'System\Models\File'        
    ];


    public static $allowedSortingOptions = array (
        'name desc' => 'Name - desc',
        'name asc' => 'Name - asc',
        'year desc' => 'Year - desc',
        'year asc' => 'Year - asc'
    );


    public function scopeListFrontEnd($query, $options = []){
        extract(array_merge([
            'page' => 1,
            'perPage' => 100,
            'sort' => 'updated_ats desc',
            'tags' => null,
            'year' => '',
            'userid' => null
        ], $options));
        if(!is_array($sort)){
            $sort = [$sort];
        }

        if($userid !== null) {
            $query->where('user_id', $userid);
        }

        $query->orderBy("created_at", "desc");

        // foreach ($sort as $_sort){
        //     if(in_array($_sort, array_keys(self::$allowedSortingOptions))){
        //         $parts = explode(' ', $_sort);
        //         if(count($parts) < 2){
        //             array_push($parts, 'desc');
        //         }
        //         list($sortField, $sortDirection) = $parts;
        //         $query->orderBy($sortField, $sortDirection);
        //     }
        // }
        
        
        if($tags !== null) {
            if(!is_array($tags)){
                $tags = [$tags];
            }
            foreach ($tags as $tag){
                $query->whereHas('tags', function($q) use ($tag){
                    $q->where('id', '=', $tag);
                });
            }
        }
        $lastPage = $query->paginate($perPage, $page)->lastPage();
        if($lastPage < $page){
            $page = 1;
        }
 
        return $query->paginate($perPage, $page);
    }

}


