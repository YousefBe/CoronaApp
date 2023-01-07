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
            $table->date('last_update')->default(\Carbon\Carbon::now());
            $table->bigInteger('new_deaths')->default(0);
            $table->bigInteger('total_deaths')->default(0);
            $table->bigInteger('new_confirmed')->default(0);
            $table->bigInteger('total_confirmed')->default(0);
            $table->bigInteger('new_recovered')->default(0);
            $table->bigInteger('total_recovered')->default(0);
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
