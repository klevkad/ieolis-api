<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRetourTcPropreMoyensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retour_tc_propre_moy', function (Blueprint $table) {
            $table->unsignedBigInteger('idretour_tc')->primary();
            $table->unsignedBigInteger('idattribution_tc');
			$table->string('transporteur',30);
			$table->string('immat_camion',20);
			$table->string('immat_remorque',20);
			$table->string('nom_chauffeur',20);
			$table->string('prenom_chauffeur',50);
            $table->string('num_pc',20);
            $table->string('num_plom_tc',10);
            $table->dateTime('dateh_retour');
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
        Schema::dropIfExists('retour_tc_propre_moyens');
    }
}
