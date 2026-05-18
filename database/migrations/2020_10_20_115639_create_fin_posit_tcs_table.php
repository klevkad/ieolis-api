<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinPositTcsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fin_posit_tc', function (Blueprint $table) {
            $table->unsignedBigInteger('idpositionnement')->primary();
            $table->boolean('confirm_intrant')->default(false);
            $table->unsignedInteger('compteur_arriv')->nullable();
            $table->dateTime('dateh_arrive');
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
        Schema::dropIfExists('fin_posit_tcs');
    }
}
