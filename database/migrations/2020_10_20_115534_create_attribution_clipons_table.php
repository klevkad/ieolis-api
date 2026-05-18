<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributionCliponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attribution_clipon', function (Blueprint $table) {
            $table->unsignedBigInteger('idattribution_tc')->primary();
			$table->string('idclipon',7);
            $table->unsignedBigInteger('idlieu_appro')->nullable();
            $table->unsignedInteger('qte_appro')->default(0);
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
        Schema::dropIfExists('attribution_clipons');
    }
}
