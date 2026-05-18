<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributionCliponRetourVerifsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attribution_clipon_ret_verif', function (Blueprint $table) {
            $table->unsignedBigInteger('idretour_conteneur')->primary();
			$table->boolean('cadenas1')->default(false);
			$table->boolean('cadenas2')->default(false);
			$table->boolean('cadenas3')->default(false);
			$table->boolean('flexible1')->default(false);
            $table->boolean('flexible2')->default(false);
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
        Schema::dropIfExists('attribution_clipon_retour_verifs');
    }
}
