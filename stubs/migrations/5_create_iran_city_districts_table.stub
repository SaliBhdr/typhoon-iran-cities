<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Migration for mantaghe shahri.
     *
     * This table is equal to mantaghe shari in farsi.
     */
    public function up(): void
    {
        Schema::create('iran_city_districts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedTinyInteger('district');
            $table->unsignedInteger('province_id');
            $table->unsignedInteger('county_id');
            $table->unsignedInteger('sector_id');
            $table->unsignedInteger('city_id');
            $table->string('code', 50)->unique();
            $table->string('short_code', 20);
            $table->boolean('status')->default(1);

            $table->foreign('province_id')->references('id')->on('iran_provinces')->onDelete('cascade');
            $table->foreign('county_id')->references('id')->on('iran_counties')->onDelete('cascade');
            $table->foreign('sector_id')->references('id')->on('iran_sectors')->onDelete('cascade');
            $table->foreign('city_id')->references('id')->on('iran_cities')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('iran_city_districts');
    }
};
