<?php namespace Mixtapes\Mixtapes\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateMixtapesMixtapesPlatform extends Migration
{
    public function up()
    {
        Schema::create('mixtapes_mixtapes_platform', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name', 20);
            $table->string('url', 100);
            $table->text('description');
            $table->string('author', 100);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('mixtapes_mixtapes_platform');
    }
}
