<?php namespace Mixtapes\Mixtapes\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateMixtapesMixtapes5 extends Migration
{
    public function up()
    {
        Schema::table('mixtapes_mixtapes_', function($table)
        {
            $table->integer('flarum_id')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('mixtapes_mixtapes_', function($table)
        {
            $table->dropColumn('flarum_id');
        });
    }
}
