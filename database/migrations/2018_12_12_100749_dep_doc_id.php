<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DepDocId extends Migration
{
    public function up()
    {
        Schema::create('DepDocId', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('Num')->unsigned()->nullable();
            $table->string('DepDocId', 10)->unique();
            $table->string('DepDocIdDescripcion', 25)->nullable();
            
            $table->nullableTimestamps();
            $table->SoftDeletes();
            $table->string('CreatorUserName', 250)->nullable();
            $table->string('CreatorFullUserName', 250)->nullable();
            $table->string('CreatorIP', 250)->nullable();
            $table->string('UpdaterUserName', 250)->nullable();
            $table->string('UpdaterFullUserName', 250)->nullable();
            $table->string('UpdaterIP', 250)->nullable();
            $table->string('DeleterUserName', 250)->nullable();
            $table->string('DeleterFullUserName', 250)->nullable();
            $table->string('DeleterIP', 250)->nullable();
       
        });
    }

    public function down()
    {
        Schema::dropIfExists('DepDocId');
    }

}
