<?php namespace Mixtapes\Mixtapes\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateMixtapesMixtapesPlatforms extends Migration
{
    public function up()
    {
        Schema::create('mixtapes_mixtapes_platforms', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('mixtape_id');
            $table->integer('platform_id');
            $table->primary(['mixtape_id','platform_id']);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('mixtapes_mixtapes_platforms');
    }
}