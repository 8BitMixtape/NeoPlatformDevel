<?php namespace Mixtapes\Mixtapes\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateMixtapesMixtapes4 extends Migration
{
    public function up()
    {
        Schema::table('mixtapes_mixtapes_', function($table)
        {
            $table->text('info')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('mixtapes_mixtapes_', function($table)
        {
            $table->dropColumn('info');
        });
    }
}
