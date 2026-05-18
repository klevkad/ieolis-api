<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinRetourCliponVerifsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fin_retour_clipon_verif', function (Blueprint $table) {
            $table->unsignedBigInteger('idretour_conteneur')->primary();
			$table->boolean('cadenas1')->default(false);
			$table->boolean('cadenas2')->default(false);
			$table->boolean('cadenas3')->default(false);
			$table->boolean('flexible1')->default(false);
            $table->boolean('flexible2')->default(false);
            $table->unsignedFloat('niv_carburant');
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
        Schema::dropIfExists('fin_retour_clipon_verifs');
    }
}
