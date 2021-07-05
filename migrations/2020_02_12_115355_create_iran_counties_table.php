<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIranCountiesTable extends Migration
{
    private $tableName = 'iran_counties';

    /**
     * Migration for Shahrestan
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
            $table->unsignedInteger('province_id');
            $table->string('code', 50)->unique();
            $table->boolean('status')->default(1);

            $table->foreign('province_id' )->references('id')->on('iran_provinces')->onDelete('cascade');
        });

        DB::statement("ALTER TABLE `$this->tableName` comment 'This table is equal to shahrestan in farsi'");
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
