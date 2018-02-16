<?php namespace Mixtapes\Mixtapes\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateMixtapesMixtapes3 extends Migration
{
    public function up()
    {
        Schema::table('mixtapes_mixtapes_', function($table)
        {
            $table->text('hex')->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('mixtapes_mixtapes_', function($table)
        {
            $table->text('hex')->nullable(false)->change();
        });
    }
}
