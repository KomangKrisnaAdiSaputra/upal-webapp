<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('minute_counters', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->string('type');
            $table->string('lokasi');
            $table->string('sub_lokasi');
            $table->string('pompa_terpasang')->nullable();
            $table->time('jam')->nullable();
            $table->double('nilai')->nullable();
            $table->boolean('volume');
            $table->boolean('ampere');
            $table->text('keterangan')->nullable();
            $table->date('tanggal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('minute_counters');
    }
};
