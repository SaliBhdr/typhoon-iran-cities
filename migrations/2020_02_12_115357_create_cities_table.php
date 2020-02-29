<?php

use App\City;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('province_id');
            $table->unsignedInteger('county_id');
            $table->string('name');
            $table->boolean('status')->default(1);
            $table->timestamps();

            $table->unique(['name', 'province_id','county_id']);
            $table->foreign('province_id' )->references('id')->on('provinces')->onDelete('cascade');
            $table->foreign('county_id' )->references('id')->on('counties')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cities');
    }
}
