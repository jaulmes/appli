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
        Schema::create('recus', function (Blueprint $table) {
            $table->id();
            $table->string('numero_recu');
            $table->unsignedBigInteger('vente_id')->nullable();
            $table->foreign('vente_id')->references('id')
                                        ->on('ventes')
                                        ->onDelete('cascade')
                                        ->onUpdate('cascade');
            $table->unsignedBigInteger('installation_id')->nullable();
            $table->foreign('installation_id')->references('id')
                                    ->on('installations')
                                    ->onDelete('cascade')
                                    ->onUpdate('cascade');
            $table->unsignedBigInteger('compte_id')->nullable();
            $table->foreign('compte_id')->references('id')
                                    ->on('comptes')
                                    ->onDelete('cascade')
                                    ->onUpdate('cascade');
            $table->unsignedBigInteger('transaction_id')->nullable();
            $table->unsignedBigInteger('charge_id')->nullable();
            
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')
                                        ->on('users')
                                        ->onDelete('cascade')
                                        ->onUpdate('cascade');
            $table->unsignedBigInteger('client_id')->nullable();
            $table->foreign('client_id')->references('id')
                                        ->on('clients')
                                        ->onDelete('cascade')
                                        ->onUpdate('cascade');
            $table->unsignedBigInteger('agent_id')->nullable();
            $table->string('montant_recu')->nullable();
            $table->string('remarque')->nullable();
            $table->string('reste')->nullable();
            $table->string('dateLimitePaiement')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recus');
    }
};
