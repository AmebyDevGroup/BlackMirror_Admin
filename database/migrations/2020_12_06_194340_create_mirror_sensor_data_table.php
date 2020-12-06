<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMirrorSensorDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mirror_sensor_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('mirror_id');
            $table->string('source');
            $table->longText('data');
            $table->timestamps();

            $table->foreign('mirror_id')
                ->references('id')
                ->on('mirrors')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mirror_sensor_data');
    }
}
