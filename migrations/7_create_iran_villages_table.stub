<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIranVillagesTable extends Migration
{
    private $tableName = 'iran_villages';

    /**
     * Migration for abadi
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
            $table->unsignedTinyInteger('type')
                ->comment('0 stands for normal village. 1 stands for blocked village');
            $table->unsignedInteger('diag')->nullable();
            $table->unsignedInteger('province_id');
            $table->unsignedInteger('county_id');
            $table->unsignedInteger('sector_id');
            $table->unsignedInteger('rural_district_id');
            $table->string('code', 50)->unique();
            $table->boolean('status')->default(1);

            $table->foreign('province_id')->references('id')->on('iran_provinces')->onDelete('cascade');
            $table->foreign('county_id')->references('id')->on('iran_counties')->onDelete('cascade');
            $table->foreign('sector_id')->references('id')->on('iran_sectors')->onDelete('cascade');
            $table->foreign('rural_district_id')->references('id')->on('iran_rural_districts')->onDelete('cascade');
        });

        DB::statement("ALTER TABLE `$this->tableName` comment 'This table is equal to abadi in farsi'");

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
