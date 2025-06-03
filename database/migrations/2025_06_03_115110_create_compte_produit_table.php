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
        Schema::create('compte_produit', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('compte_id')->nullable();
            $table->unsignedBigInteger('produit_id')->nullable();
            $table->string('montant')->nullable();

            $table->foreign('compte_id')->references('id')
                                        ->on('comptes')
                                        ->onDelete('cascade')
                                        ->onUpdate('cascade');

            $table->foreign('produit_id')->references('id')
                                        ->on('produits')
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
        Schema::dropIfExists('compte_produit');
    }
};
