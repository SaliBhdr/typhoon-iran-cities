<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIranProvincesTable extends Migration
{

    /**
     * Migration for Ostan
     *
     * Run the migrations.
     *
     * This table is equal to ostan in farsi
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iran_provinces', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('code', 50)->unique();
            $table->string('short_code', 20);
            $table->boolean('status')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('iran_provinces');
    }
}
