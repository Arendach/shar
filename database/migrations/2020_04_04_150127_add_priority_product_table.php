<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPriorityProductTable extends Migration
{
    public function up()
    {
        Schema::table('product', function (Blueprint $table){
            $table->integer('priority')->default(0);
        });
    }

    public function down()
    {
        Schema::table('product', function (Blueprint $table){
            $table->dropColumn('priority');
        });
    }
}
