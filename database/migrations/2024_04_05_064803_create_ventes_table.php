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
            $table->string('nomClient');
            $table->integer('numeroClient');
            $table->integer('montantTotal');
            $table->integer('montantVerse')->nullable();
            $table->integer('totalAchat')->nullable();
            $table->integer('reduction')->nullable();
            $table->integer('qteTotal');
            $table->string('date');
            $table->string('statut');
            $table->string('dateEncour');
            $table->string('impot')->nullable();
            
            //compte_key
            $table->unsignedBigInteger('compte_id')->nullable();
            $table->foreign('compte_id')->references('id')
                                        ->on('comptes')
                                        ->onUpdate('cascade')
                                        ->onDelete('cascade');
            
            //user_key
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')
                                        ->on('users')
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
        Schema::dropIfExists('ventes');
    }
};
