<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropMirrorConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('mirror_configs');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('mirror_configs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->boolean('active');
            $table->text('data');
            $table->timestamps();
        });
    }
}
