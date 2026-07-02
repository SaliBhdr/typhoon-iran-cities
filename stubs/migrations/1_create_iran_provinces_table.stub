<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Migration for Ostan.
     *
     * This table is equal to ostan in farsi.
     */
    public function up(): void
    {
        Schema::create('iran_provinces', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('code', 50)->unique();
            $table->string('short_code', 20);
            $table->boolean('status')->default(1);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('iran_provinces');
    }
};
