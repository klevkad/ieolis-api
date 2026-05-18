<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncidentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incidents', function (Blueprint $table) {
            $table->id();
            $table->string('nobooking',20);
            $table->string('no_tc',13);
            $table->unsignedInteger('type_incident_id');
            $table->string('codetype',4);
            $table->text('commentaire');
            $table->unsignedInteger('action'); // 0 = Annuler, 1 = Recommencer
            $table->json('old_data');
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
        Schema::dropIfExists('incidents');
    }
}
