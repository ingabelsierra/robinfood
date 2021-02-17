<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
   
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            
            $table->bigIncrements('id');
            $table->string('question');            
            $table->integer('poll_id');
            $table->timestamps();             
            
        });
    }
   
    public function down()
    {
        Schema::dropIfExists('questions');
    }
}
