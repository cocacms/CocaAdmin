<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoleMemberRelationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_member_relations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('member_id');
            $table->integer('role_id');
            $table->timestamps();
            $table->primary(['member_id', 'role_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_member_relations');
    }
}
