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
        Schema::create('plans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('AuthorId')
                ->references('id')
                ->on('authors');
            $table->year('Year');
            $table->integer('Theses')->default(0);
            $table->integer('ProfetionalArticles')->default(0);
            $table->integer('Scopus')->default(0);
            $table->integer('Manuals')->default(0);
            $table->boolean('Stat')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
