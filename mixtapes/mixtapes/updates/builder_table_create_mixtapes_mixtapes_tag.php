<?php namespace Mixtapes\Mixtapes\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateMixtapesMixtapesTag extends Migration
{
    public function up()
    {
        Schema::create('mixtapes_mixtapes_tag', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('tag', 10);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('mixtapes_mixtapes_tag');
    }
}