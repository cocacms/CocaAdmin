<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOtherinfoMember extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->integer('sex')->default(0); //性别 0-未知 1-男 2-女
            $table->string('tel',11)->nullable(); //手机
            $table->string('mail',60)->nullable(); //邮箱
            $table->date('birthday')->nullable(); //生日
            $table->string('nickname',20)->nullable(); //昵称
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn('sex');
            $table->dropColumn('tel');
            $table->dropColumn('mail');
            $table->dropColumn('birthday');
            $table->dropColumn('nickname');

        });
    }
}
