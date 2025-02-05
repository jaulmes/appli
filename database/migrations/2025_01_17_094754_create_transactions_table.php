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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->time('heure');
            $table->string('nomClient')->nullable();
            $table->string('moi')->nullable();//moi de l'anne en cour
            $table->integer('numeroClient')->nullable();
            $table->string('type');
            $table->integer('montantVerse')->nullable();
            $table->integer('prixAchat')->nullable();
            $table->json('produit')->nullable();
            $table->string('impot')->nullable();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')
                                        ->on('users')
                                        ->onUpdate('cascade')
                                        ->onDelete('cascade');
                 
            $table->unsignedBigInteger('compte_id')->nullable();
            $table->foreign('compte_id')->references('id')
                                        ->on('comptes')
                                        ->onUpdate('cascade')
                                        ->onDelete('cascade');

            $table->unsignedBigInteger('recu_id')->nullable();
            $table->foreign('recu_id')->references('id')
                                        ->on('recus')
                                        ->onUpdate('cascade')
                                        ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
