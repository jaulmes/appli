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
        Schema::create('solde_compte_mensuels', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('compte_id');
            $table->date('date_capture');
            $table->string('solde_debut');
            $table->string('solde_fin')->nullable();
            $table->foreign('compte_id')->references('id')->on('comptes')->onDelete('cascade');
            $table->unique(['compte_id', 'date_capture']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solde_compte_mensuels');
    }
};
