<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDemandeBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_demande_booking', function (Blueprint $table) {
            $table->id('iddemande_booking');
            $table->unsignedBigInteger('idutilisateur_client');
            $table->unsignedBigInteger('idlieu_arrive');
            $table->unsignedBigInteger('idtransporteur');
            $table->string('ct_num',10);
            $table->string('noescale',10);
            $table->string('payeurfret',10);
            $table->string('produit',6);
            $table->string('nobooking',20)->unique();
            $table->date('date_demande');
            $table->boolean('si_valider')->default(false);
            $table->boolean('si_transporteur_eolis')->default(false);
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
        Schema::dropIfExists('demande_bookings');
    }
}
