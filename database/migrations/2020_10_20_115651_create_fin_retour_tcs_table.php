<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinRetourTcsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fin_retour_tc', function (Blueprint $table) {
            $table->unsignedBigInteger('idretour_conteneur')->primary();
			$table->unsignedBigInteger('idlieu_appro_cli_arr')->nullable();
			$table->unsignedBigInteger('idlieu_appro_cam')->nullable();
            $table->unsignedInteger('compteur_arriv_cam')->nullable();
            $table->unsignedFloat('qte_appro_arrive_cam')->default(0);
            $table->unsignedFloat('qte_appro_arrive_clipon')->default(0);
            $table->dateTime('dateh_arriv_cam');
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
        Schema::dropIfExists('fin_retour_tcs');
    }
}
