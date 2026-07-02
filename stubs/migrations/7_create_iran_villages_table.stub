<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Migration for abadi.
     *
     * This table is equal to abadi in farsi.
     */
    public function up(): void
    {
        Schema::create('iran_villages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedTinyInteger('type')
                ->comment('0 means a typical village.  1 means industrial zone, a small group of buildings, facilities, factories and so on');
            $table->unsignedInteger('diag')->nullable();
            $table->unsignedInteger('province_id');
            $table->unsignedInteger('county_id');
            $table->unsignedInteger('sector_id');
            $table->unsignedInteger('rural_district_id');
            $table->string('code', 50)->unique();
            $table->string('short_code', 20);
            $table->boolean('status')->default(1);

            $table->foreign('province_id')->references('id')->on('iran_provinces')->onDelete('cascade');
            $table->foreign('county_id')->references('id')->on('iran_counties')->onDelete('cascade');
            $table->foreign('sector_id')->references('id')->on('iran_sectors')->onDelete('cascade');
            $table->foreign('rural_district_id')->references('id')->on('iran_rural_districts')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('iran_villages');
    }
};
