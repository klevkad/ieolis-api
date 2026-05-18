<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReptcSidesTable extends Migration
{
    protected $connection = 'parc';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reptc_sides', function (Blueprint $table) {
            $table->string('id',12)->primary();
            $table->string('libelle',40);
            $table->boolean('enabled')->default(true);
            $table->foreignId('created_by')->nullable()->references('id')->on('users')->onDelete('restrict');
            $table->foreignId('updated_by')->nullable()->references('id')->on('users')->onDelete('restrict');
            $table->foreignId('deleted_by')->nullable()->references('id')->on('users')->onDelete('restrict');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reptc_sides');
    }
}
