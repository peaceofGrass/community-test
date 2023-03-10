<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function(Blueprint $table) {
            $table->tinyInteger('status')->default(0); // 0: 미지, 1: 통과, -1: 삭제
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
//    public function down()
//    {
//        Schema::table('posts', function(Blueprint $table) {
//            $table->dropColumn('status');
//        });
//    }
}
