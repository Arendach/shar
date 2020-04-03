<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTimestampsToCategoryTable extends Migration
{
    public function up()
    {
        Schema::table('category', function (Blueprint $table) {
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('category', function (Blueprint $table) {
            $table->dropTimestamps();
        });
    }
}
