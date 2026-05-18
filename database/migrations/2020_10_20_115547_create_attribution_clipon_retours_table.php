<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributionCliponRetoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attribution_clipon_retour', function (Blueprint $table) {
            $table->unsignedBigInteger('idretour_conteneur')->primary();
            $table->string('idclipon',7);
            $table->unsignedBigInteger('idlieu_appro_clip');
            $table->string('bon_appro_clip',20);
            $table->unsignedInteger('qte_appro_clip');
            $table->dateTime('dateh_arret_clip')->nullable();
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
        Schema::dropIfExists('attribution_clipon_retours');
    }
}
