<?php namespace Mixtapes\Mixtapes\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateMixtapesMixtapesTags2 extends Migration
{
    public function up()
    {
        Schema::create('mixtapes_mixtapes_tags', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('mixtape_id');
            $table->integer('tag_id');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('mixtapes_mixtapes_tags');
    }
}