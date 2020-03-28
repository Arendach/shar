<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSlugToCategory extends Migration
{
    public function up()
    {
        Schema::table('category', function (Blueprint $table) {
            $table->string('slug', 256)->unique();
        });
    }

    public function down()
    {
        Schema::table('category', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
}
