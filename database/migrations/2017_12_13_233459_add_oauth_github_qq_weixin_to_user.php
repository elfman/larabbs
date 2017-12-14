<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOauthGithubQqWeixinToUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('github_id')->nullable()->unique();
            $table->integer('qq_id')->nullable()->unique();
            $table->integer('weixin_id')->nullable()->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('github_id');
            $table->dropColumn('qq_id');
            $table->dropColumn('weixin_id');
        });
    }
}
