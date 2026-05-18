<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChargeursTable extends Migration
{
    protected $connection = 'parc';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chargeurs', function (Blueprint $table) {
            $table->id();
            $table->string('libelle',10)->unique();
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
        Schema::dropIfExists('chargeurs');
    }
}
