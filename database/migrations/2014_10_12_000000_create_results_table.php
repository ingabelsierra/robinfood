<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResultsTable extends Migration
{
   
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {
            
            $table->bigIncrements('id');
            $table->string('client_name');
            $table->integer('poll_id');
            $table->integer('question_id');
            $table->integer('answer_id');
            $table->timestamps();
        });
    }
   
    public function down()
    {
        Schema::dropIfExists('results');
    }
}
