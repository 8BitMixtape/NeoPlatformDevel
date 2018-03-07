<?php namespace Mixtapes\Mixtapes\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateMixtapesMixtapes5 extends Migration
{
    public function up()
    {
        Schema::table('mixtapes_mixtapes_', function($table)
        {
            $table->string('short_description', 100)->nullable();
            $table->string('url_soundcloud', 300)->nullable();
            $table->string('url_youtube', 300)->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('mixtapes_mixtapes_', function($table)
        {
            $table->dropColumn('short_description');
            $table->dropColumn('url_soundcloud');
            $table->dropColumn('url_youtube');
        });
    }
}
