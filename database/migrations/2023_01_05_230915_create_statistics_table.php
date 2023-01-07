<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statistics', function (Blueprint $table) {
            $table->id();
            $table->date('last_update');
            $table->bigInteger('new_deaths');
            $table->bigInteger('total_deaths');
            $table->bigInteger('new_confirmed');
            $table->bigInteger('total_confirmed');
            $table->bigInteger('new_recovered');
            $table->bigInteger('total_recovered');
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
        Schema::dropIfExists('statistics');
    }
};
