<?php namespace Mixtapes\Mixtapes\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateMixtapesMixtapesTag extends Migration
{
    public function up()
    {
        Schema::table('mixtapes_mixtapes_tag', function($table)
        {
            $table->string('tag', 20)->change();
        });
    }
    
    public function down()
    {
        Schema::table('mixtapes_mixtapes_tag', function($table)
        {
            $table->string('tag', 10)->change();
        });
    }
}
