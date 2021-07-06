<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIranProvincesTable extends Migration
{

    private $tableName = 'iran_provinces';

    /**
     * Migration for Ostan
     *
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('code', 50)->unique();
            $table->boolean('status')->default(1);
        });

        DB::statement("ALTER TABLE `$this->tableName` comment 'This table is equal to ostan in farsi'");
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
