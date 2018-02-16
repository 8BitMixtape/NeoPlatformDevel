<?php namespace Mixtapes\Mixtapes\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateMixtapesMixtapes2 extends Migration
{
    public function up()
    {
        Schema::create('mixtapes_mixtapes_', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->text('description');
            $table->text('hex');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('mixtapes_mixtapes_');
    }
}
