<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIranSectorsTable extends Migration
{
    /**
     * Migration for bakhsh
     *
     * Run the migrations.
     *
     * This table is equal to bakhsh in farsi
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iran_sectors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('province_id');
            $table->unsignedInteger('county_id');
            $table->string('code', 50)->unique();
            $table->string('short_code', 20);
            $table->boolean('status')->default(1);

            $table->foreign('province_id')->references('id')->on('iran_provinces')->onDelete('cascade');
            $table->foreign('county_id')->references('id')->on('iran_counties')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('iran_sectors');
    }
}
