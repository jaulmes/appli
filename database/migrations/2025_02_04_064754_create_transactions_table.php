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
            $table->date('date')->nullable();
            $table->time('heure')->nullable();
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
                                        ->onDelete('cascade')
                                        ->onUpdate('cascade');

            $table->unsignedBigInteger('charge_id')->nullable();
            $table->foreign('charge_id')->references('id')
                                        ->on('charges')
                                        ->onUpdate('cascade')
                                        ->onDelete('cascade');
            
            $table->unsignedBigInteger('chargeDetail_id')->nullable();
            $table->foreign('chargeDetail_id')->references('id')
                                        ->on('charge_details')  
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
