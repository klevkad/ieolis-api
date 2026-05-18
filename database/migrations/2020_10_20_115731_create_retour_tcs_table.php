<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRetourTcsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retour_conteneur', function (Blueprint $table) {
            $table->unsignedBigInteger('idretour_conteneur')->primary();
            $table->unsignedBigInteger('idremorque');
            $table->unsignedBigInteger('idcamion');
            $table->unsignedBigInteger('idchauffeur');
            $table->unsignedBigInteger('idtransporteur');
            $table->unsignedBigInteger('idpositionnement');
            $table->string('bon_appro_cam',20);
            $table->unsignedFloat('qte_appro_cam');
            $table->unsignedFloat('compteur_sorti_cam');
            $table->string('num_plom_tc',10);
            $table->dateTime('dateh_sorti_cam');
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
        Schema::dropIfExists('retour_tcs');
    }
}
