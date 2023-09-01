<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('publications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('Name');
            $table->string('StartPage');
            $table->string('EndPage');
            $table->string('UPP');
            $table->string('PublicationDate')->default(date('Y-m'));
            $table->string('PublicationNumber');
            $table->string('DOI')->nullable()->default(null);
            $table->foreignId('Type')
                ->default('1')
                ->references('id')
                ->on('types');
            $table->foreignId('Language')
                ->default('1')
                ->references('id')
                ->on('languages');
            $table->foreignId('Publisher')
                ->default('1')
                ->references('id')
                ->on('publishers');
            $table->foreignId('Country')
                ->default('1')
                ->references('id')
                ->on('countries');
            $table->foreignId('Supervisor')
                ->nullable()
                ->default(null)
                ->references('id')
                ->on('authors');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publications');
    }
};
