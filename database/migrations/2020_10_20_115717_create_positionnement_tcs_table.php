<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePositionnementTcsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('positionnement_tc', function (Blueprint $table) {
            $table->id('idpositionnement');
            $table->unsignedBigInteger('idremorque');
            $table->unsignedBigInteger('idcamion');
            $table->unsignedBigInteger('idchauffeur');
            $table->unsignedBigInteger('idtransporteur');
            $table->unsignedBigInteger('idactivites');
            $table->unsignedBigInteger('idlieu_depart');
            $table->unsignedBigInteger('idlieu_arrive');
            $table->unsignedBigInteger('idlieu_appro');
            $table->unsignedBigInteger('idattribution_tc');
            $table->unsignedFloat('compteur_depart');
            $table->dateTime('dateh_depart');
            $table->boolean('intrant')->default(false);
            $table->unsignedFloat('qte_appro');
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
        Schema::dropIfExists('positionnement_tcs');
    }
}
