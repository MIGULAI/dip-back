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
        Schema::create('publication_plans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('Publication')
                ->references('id')
                ->on('publications');
            $table->foreignId('Plan')
                ->references('id')
                ->on('plans');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publication_plans');
    }
};
