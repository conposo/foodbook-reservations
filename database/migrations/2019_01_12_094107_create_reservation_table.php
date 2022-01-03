<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedSmallInteger('restaurant_id');

            $table->string('status', 16);

            $table->unsignedSmallInteger('creator_id');

            $table->unsignedTinyInteger('total_guests');

            $table->date('date');
            $table->time('time');

            $table->unsignedSmallInteger('table')->nullable();

            $table->unsignedTinyInteger('parking')->nullable();
            
            $table->string('notes', 1024)->nullable();

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
        Schema::dropIfExists('reservations');
    }
}
