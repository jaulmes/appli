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
        Schema::create('ventes', function (Blueprint $table) {
            $table->id();
            $table->string('nomClient')->nullable();
            $table->integer('numeroClient')->nullable();
            $table->integer('montantTotal')->nullable();
            $table->integer('NetAPayer')->nullable();
            $table->integer('montantVerse')->nullable();
            $table->integer('totalAchat')->nullable();
            $table->integer('reduction')->nullable();
            $table->string('agentOperant')->nullable();
            $table->string('commission')->nullable();
            $table->integer('qteTotal')->nullable();
            $table->string('date')->nullable();
            $table->string('statut')->nullable();
            $table->string('dateEncour')->nullable();
            $table->string('impot')->nullable();
            
            //compte_key
            $table->unsignedBigInteger('compte_id')->nullable();
            $table->foreign('compte_id')->references('id')
                                        ->on('comptes')
                                        ->onUpdate('cascade')
                                        ->onDelete('cascade');

            //client_id
            $table->unsignedBigInteger('client_id')->nullable();
            $table->foreign('client_id')->references('id')
                                        ->on('clients')
                                        ->onUpdate('cascade')
                                        ->onDelete('cascade');
            
            //user_key
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')
                                        ->on('users')
                                        ->onUpdate('cascade')
                                        ->onDelete('cascade');

            $table->unsignedBigInteger('commande_id')->nullable();
            $table->foreign('commande_id')->references('id')
                                        ->on('commandes')
                                        ->onUpdate('cascade')
                                        ->onDelete('cascade');
            $table->string('dateLimitePaiement')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventes');
    }
};
