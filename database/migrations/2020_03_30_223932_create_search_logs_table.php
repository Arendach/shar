<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSearchLogsTable extends Migration
{
    public function up()
    {
        Schema::create('search_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('query', 256);
            $table->string('user_agent');
            $table->dateTime('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('search_logs');
    }
}
