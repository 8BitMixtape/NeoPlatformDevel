<?php namespace Mixtapes\Mixtapes\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateMixtapesMixtapesTags extends Migration
{
    public function up()
    {
        Schema::table('mixtapes_mixtapes_tags', function($table)
        {
            $table->renameColumn('mixtape_tag_id', 'mixtape_tags_id');
        });
    }
    
    public function down()
    {
        Schema::table('mixtapes_mixtapes_tags', function($table)
        {
            $table->renameColumn('mixtape_tags_id', 'mixtape_tag_id');
        });
    }
}
