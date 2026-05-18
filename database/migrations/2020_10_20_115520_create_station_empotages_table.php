<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStationEmpotagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('station_empotage', function (Blueprint $table) {
            $table->string('codestation_empotage',10)->primary();
            $table->string('idlieu',5);
            $table->string('lib_station',50);
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
        Schema::dropIfExists('station_empotages');
    }
}
