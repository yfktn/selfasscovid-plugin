<?php namespace Yfktn\SelfAssCovid\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateYfktnSelfasscovid extends Migration
{
    public function up()
    {
        Schema::table('yfktn_selfasscovid_', function($table)
        {
            $table->integer('user_id')->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('yfktn_selfasscovid_', function($table)
        {
            $table->integer('user_id')->nullable(false)->change();
        });
    }
}
