<?php namespace Mixtapes\Mixtapes\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateMixtapesMixtapes2 extends Migration
{
    public function up()
    {
        Schema::table('mixtapes_mixtapes_', function($table)
        {
            $table->integer('user_id');
        });
    }
    
    public function down()
    {
        Schema::table('mixtapes_mixtapes_', function($table)
        {
            $table->dropColumn('user_id');
        });
    }
}
