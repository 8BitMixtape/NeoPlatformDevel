<?php namespace Mixtapes\Mixtapes\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateMixtapesMixtapesTags2 extends Migration
{
    public function up()
    {
        Schema::table('mixtapes_mixtapes_tags', function($table)
        {
            $table->integer('mixtape_id')->unsigned()->change();
            $table->integer('mixtape_tags_id')->unsigned()->change();
            $table->primary(['mixtape_id','mixtape_tags_id']);
        });
    }
    
    public function down()
    {
        Schema::table('mixtapes_mixtapes_tags', function($table)
        {
            $table->dropPrimary(['mixtape_id','mixtape_tags_id']);
            $table->integer('mixtape_id')->unsigned(false)->change();
            $table->integer('mixtape_tags_id')->unsigned(false)->change();
        });
    }
}
