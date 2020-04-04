<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeCategoryTable extends Migration
{
    public function up()
    {
        Schema::table('category', function (Blueprint $table) {
            $table->boolean('archive')->default(false)->change();
        });
    }

    public function down()
    {
        Schema::table('category', function (Blueprint $table) {
            $table->boolean('archive')->change();
        });
    }
}
