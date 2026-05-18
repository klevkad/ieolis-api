<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReptcsTable extends Migration
{
    protected $connection = 'parc';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reptcs', function (Blueprint $table) {
            $table->id();
            $table->string('numerotc',12);
            $table->string('codeparc',12);
            $table->date('daterecep');
            $table->dateTime('debutrep');
            $table->dateTime('finrep');
            $table->string('obs');
            $table->float('cout');
            $table->boolean('prepasurf')->default(false);
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
        Schema::dropIfExists('reptcs');
    }
}
