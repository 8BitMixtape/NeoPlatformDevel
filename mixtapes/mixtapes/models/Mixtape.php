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

    public $belongsTo = [
        'user' => 'RainLab\User\Models\User'
    ];

    public $attachOne = [
        'hex_file' => 'System\Models\File',
        'wav_file' => 'System\Models\File',
        'zip_file' => 'System\Models\File'        
    ];
}
