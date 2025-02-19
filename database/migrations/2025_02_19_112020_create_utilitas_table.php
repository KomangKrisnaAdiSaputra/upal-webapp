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
        Schema::create('utilitas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_customer');
            $table->uuid('id_user');
            $table->string('jenis');
            $table->string('satuan');
            $table->date('tanggal');
            $table->string('nilai');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('utilitas');
    }
};
