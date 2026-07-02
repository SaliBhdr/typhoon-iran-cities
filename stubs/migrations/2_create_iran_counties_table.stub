<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Migration for Shahrestan.
     *
     * This table is equal to shahrestan in farsi.
     */
    public function up(): void
    {
        Schema::create('iran_counties', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->unsignedInteger('province_id');
            $table->string('code', 50)->unique();
            $table->string('short_code', 20);
            $table->boolean('status')->default(1);

            $table->foreign('province_id')->references('id')->on('iran_provinces')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('iran_counties');
    }
};
