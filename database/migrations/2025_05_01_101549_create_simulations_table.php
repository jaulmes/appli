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
        Schema::create('simulations', function (Blueprint $table) {
            $table->id();
            $table->longText('appareils');
            $table->string('coeficient_securite');
            $table->string('tension_entre_panneau');
            $table->string('ensoleillement_site');
            $table->string('efficacite_installation');
            $table->string('autonomie_generale');
            $table->string('tension_batterie');
            $table->string('tension_sortie_batterie');
            $table->string('DOD_batterie');
            $table->string('energie_totale');
            $table->string('besoin_energetique_journalier');
            $table->string('unite_batterie');
            $table->string('batteri_souhaite');
            $table->string('nombre_watt_panneaux');
            $table->string('nombre_panneaux');
            $table->string('puissance_champ_panneaux');
            $table->string('capacite_batterie');
            $table->string('nombre_batteries');
            $table->string('courant_minimun_controlleur');
            $table->string('puissance_convertisseur');
            $table->string('unite_capacite_batterie');
            $table->unsignedBigInteger('simuleur_id');
            $table->foreign('simuleur_id')->references('id')
                                            ->on('simuleurs')
                                            ->onDelete('cascade');
            $table->unsignedBigInteger('client_simuleur_id')->nullable();
            $table->foreign('client_simuleur_id')->references('id')
                                                ->on('client_simuleurs')
                                                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('simulations');
    }
};
