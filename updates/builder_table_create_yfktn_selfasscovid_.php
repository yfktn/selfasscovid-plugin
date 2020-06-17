<?php namespace Yfktn\SelfAssCovid\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateYfktnSelfasscovid extends Migration
{
    public function up()
    {
        Schema::create('yfktn_selfasscovid_', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->smallInteger('jawab01')->unsigned()->default(0);
            $table->smallInteger('jawab02')->unsigned()->default(0);
            $table->smallInteger('jawab03')->unsigned()->default(0);
            $table->smallInteger('jawab04')->unsigned()->default(0);
            $table->smallInteger('jawab05')->unsigned()->default(0);
            $table->smallInteger('jawab06')->unsigned()->default(0);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('yfktn_selfasscovid_');
    }
}
