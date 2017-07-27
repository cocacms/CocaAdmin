<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->string('tag');
            $table->string('link')->nullable();
            $table->string('target',18)->nullable();
            $table->text('description')->nullable();
            $table->text('content')->nullable();
            $table->string('pic')->nullable();
            $table->integer('show')->default(1); //1显示 0不显示
            $table->integer('order')->default(0); //ASC
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promos');
    }
}
