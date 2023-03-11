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
        Schema::create('authors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('Orcid', 16)->nullable()->unique();
            $table->string('Scopus')->nullable();
            $table->string('SerName');
            $table->string('Name');
            $table->string('Patronic')
                ->nullable()
                ->default(null);
            $table->string('SerNameEng')
                    ->nullable()
                    ->default(null);
            $table->string('NameEng')
                    ->nullable()
                    ->default(null);
            $table->string('PatronicEng')
                    ->nullable()
                    ->default(null);
            $table->foreignId('Position')
                ->default('1')
                ->references('id')
                ->on('positions');
            $table->foreignId('Department')
                ->default('1')
                ->references('id')
                ->on('departments');
            $table->foreignId('Specialty')
                ->default('1')
                ->references('id')
                ->on('specialties');
            $table->foreignId('Degree')
                ->default('1')
                ->references('id')
                ->on('degrees');
            $table->foreignId('Rank')
                ->default('1')
                ->references('id')
                ->on('ranks');
            $table->boolean('PlanningStatus')->default(false);
            $table->date('StartDate')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('authors');
    }
};
