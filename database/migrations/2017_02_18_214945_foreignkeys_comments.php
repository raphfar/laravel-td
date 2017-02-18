<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ForeignkeysComments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

            Schema::table('comments', function (Blueprint $table) {
                $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');
                $table->foreign('user_id')->references('id')->on('users');
            });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
