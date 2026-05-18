<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePositionnementTcPropreMoyensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posit_propre_moy', function (Blueprint $table) {
            $table->unsignedBigInteger('idattribution_tc')->primary();
			$table->string('transporteur',30);
			$table->string('immat_camion',20);
			$table->string('immat_remorque',20);
			$table->string('nom_chauffeur',20);
			$table->string('prenom_chauffeur',50);
            $table->string('num_pc',20);
            $table->dateTime('dateh_sortie');
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
        Schema::dropIfExists('positionnement_tc_propre_moyens');
    }
}
