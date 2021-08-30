<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use SaliBhdr\TyphoonIranCities\Enums\TargetTypeEnum;

class CreateIranRegionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iran_regions', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('type', TargetTypeEnum::ALL);
            $table->unsignedInteger('parent_id')->nullable();
            $table->unsignedInteger('province_id')->nullable();
            $table->unsignedInteger('county_id')->nullable();
            $table->unsignedInteger('sector_id')->nullable();
            $table->unsignedInteger('city_id')->nullable();
            $table->unsignedInteger('rural_district_id')->nullable();
            $table->string('name');
            $table->string('code', 50)->unique();
            $table->string('short_code', 20);
            $table->boolean('status')->default(1);

            $table->foreign('parent_id')->references('id')->on('iran_regions')->onDelete('cascade');
            $table->foreign('province_id')->references('id')->on('iran_regions')->onDelete('cascade');
            $table->foreign('county_id')->references('id')->on('iran_regions')->onDelete('cascade');
            $table->foreign('sector_id')->references('id')->on('iran_regions')->onDelete('cascade');
            $table->foreign('city_id')->references('id')->on('iran_regions')->onDelete('cascade');
            $table->foreign('rural_district_id')->references('id')->on('iran_regions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('iran_regions');
    }
}
