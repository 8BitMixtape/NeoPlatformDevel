<?php namespace Mixtapes\Mixtapes\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateMixtapesMixtapes extends Migration
{
    public function up()
    {
        Schema::create('mixtapes_mixtapes_', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->string('user')->nullable();
            $table->text('hex')->nullable();
            $table->string('url')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('mixtapes_mixtapes_');
    }
}
