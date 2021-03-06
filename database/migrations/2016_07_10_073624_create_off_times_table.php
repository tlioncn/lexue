<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOffTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('off_times', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('teacher_id');
            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');

            $table->unsignedInteger('time_slot_id')->nullable();
            $table->foreign('time_slot_id')->references('id')->on('time_slots')->onDelete('cascade');

            $table->date('date');
            $table->boolean('all_day')->default(false);

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
        Schema::drop('off_times');
    }
}
