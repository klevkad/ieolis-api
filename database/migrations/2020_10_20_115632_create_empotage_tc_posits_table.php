<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpotageTcPositsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empotage_tc_posit', function (Blueprint $table) {
            $table->id('idempotage_tc');
            $table->unsignedBigInteger('idpositionnement');
            $table->string('codestation_empotage',10);
            $table->dateTime('datehdeb_empot');
            $table->dateTime('datehfin_empot');
            $table->boolean('si_depassement_facture')->default(false);
			$table->string('observation');
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
        Schema::dropIfExists('empotage_tc_posits');
    }
}
