<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingTcFinalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_final_tc', function (Blueprint $table) {
            $table->id('idbooking_final_tc');
            $table->unsignedBigInteger('iddemande_booking');
            $table->string('no_declaration',20);
            $table->string('nobookingfin',20)->unique();
            $table->string('plomb1',10);
            $table->string('plomb2',10)->nullable();
            $table->unsignedFloat('poids_brut');
            $table->unsignedFloat('volume');
            $table->boolean('plein_vide');
            $table->foreignId('created_by')->nullable()->references('id')->on('users')->onDelete('restrict');
            $table->foreignId('updated_by')->nullable()->references('id')->on('users')->onDelete('restrict');
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
        Schema::dropIfExists('booking_tc_finals');
    }
}
