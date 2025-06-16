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
        Schema::create('bon_commandes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('compte_id')->nullable();
            $table->string('montant')->nullable();
            $table->string('titre')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('date_livraison')->nullable();
            $table->string('date_commande')->nullable();
            $table->string('status')->default('En attente');
            $table->string('frais')->nullable();
            $table->foreign('compte_id')->references('id')
                                        ->on('comptes')
                                        ->onDelete('cascade')
                                        ->onUpdate('cascade');
            $table->foreign('user_id')->references('id')
                                        ->on('users')
                                        ->onDelete('cascade')
                                        ->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bon_commandes');
    }
};
