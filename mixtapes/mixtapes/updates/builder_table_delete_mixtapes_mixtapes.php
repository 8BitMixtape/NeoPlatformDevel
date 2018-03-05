<?php namespace Mixtapes\Mixtapes\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableDeleteMixtapesMixtapes extends Migration
{
    public function up()
    {
        Schema::dropIfExists('mixtapes_mixtapes_');
    }
    
    public function down()
    {
        Schema::create('mixtapes_mixtapes_', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->string('name', 255)->nullable();
            $table->text('description')->nullable();
            $table->string('user', 255)->nullable();
            $table->text('hex')->nullable();
            $table->string('url', 255)->nullable();
        });
    }
}