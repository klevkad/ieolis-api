<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingTcsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_conteneur', function (Blueprint $table) {
            $table->id('idbooking_conteneur');
            $table->unsignedBigInteger('iddemande_booking');
            $table->string('codetype_tc',5);
            $table->unsignedInteger('nb_tcs');
            $table->unsignedInteger('nb_tcs_def');
            $table->date('date_posit_souhait');
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
        Schema::dropIfExists('booking_tcs');
    }
}
