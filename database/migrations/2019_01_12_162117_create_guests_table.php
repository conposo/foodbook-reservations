<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGuestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guests', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('reservation_id');
            
            $table->unsignedInteger('guest_order');
            $table->string('guest_type', 10);
            
            $table->unsignedInteger('user_id')->nullable();
            
            $table->string('status', 16)->nullable();
            
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
        Schema::dropIfExists('guests');
    }
}
