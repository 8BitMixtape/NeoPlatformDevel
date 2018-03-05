<?php namespace Mixtapes\Mixtapes\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableDeleteMixtapesMixtapesTags extends Migration
{
    public function up()
    {
        Schema::dropIfExists('mixtapes_mixtapes_tags');
    }
    
    public function down()
    {
        Schema::create('mixtapes_mixtapes_tags', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('mixtape_id');
            $table->integer('tag_id');
        });
    }
}