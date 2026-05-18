<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApproCarburantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appro_carburants', function (Blueprint $table) {
            $table->id();
            $table->string('idengin',7);
            $table->string('bon_appro',20)->nullable();
            $table->unsignedFloat('qte_appro');
            $table->date('date_appro');
            $table->unsignedBigInteger('idlieu_appro')->nullable();
            $table->morphs('model');
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
        Schema::dropIfExists('appro_carburants');
    }
}
