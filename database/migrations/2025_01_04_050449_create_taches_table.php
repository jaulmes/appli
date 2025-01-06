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
        Schema::create('taches', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->longText('description');
            $table->string('statut');
            $table->string('etat');//attribue ou non a un utilisateur
            $table->string('date_debut');
            $table->string('date_fin');
            $table->foreignId('created_by')->constrained('users')
                                            ->onDelete('cascade');
            $table->foreignId('assigned_to')->nullable()
                                            ->constrained('users')
                                            ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taches');
    }
};
