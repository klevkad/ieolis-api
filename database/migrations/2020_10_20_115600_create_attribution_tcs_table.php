<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributionTcsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attribution_tc', function (Blueprint $table) {
            $table->id('idattribution_tc');
            $table->unsignedBigInteger('idbooking_conteneur');
            $table->string('no_tc',13);
			$table->string('plom1',10);
			$table->string('plom2',10)->nullable();
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
        Schema::dropIfExists('attribution_tcs');
    }
}
