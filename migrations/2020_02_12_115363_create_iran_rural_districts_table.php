<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIranRuralDistrictsTable extends Migration
{
    private $tableName = 'iran_rural_districts';

    /**
     * Migration for dehestan
     *
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('province_id');
            $table->unsignedInteger('county_id');
            $table->unsignedInteger('sector_id');
            $table->string('code', 50)->unique();
            $table->boolean('status')->default(1);

            $table->foreign('province_id' )->references('id')->on('iran_provinces')->onDelete('cascade');
            $table->foreign('county_id' )->references('id')->on('iran_counties')->onDelete('cascade');
            $table->foreign('sector_id' )->references('id')->on('iran_sectors')->onDelete('cascade');
        });

        DB::statement("ALTER TABLE `$this->tableName` comment 'This table is equal to dehestan in farsi'");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->tableName);
    }
}
