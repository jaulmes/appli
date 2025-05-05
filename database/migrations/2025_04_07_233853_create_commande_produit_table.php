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
        Schema::create('commande_produit', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity');
            $table->integer('price');
            $table->string('status_produit')->nullable();
            $table->unsignedBigInteger('commande_id')->nullable();
            $table->foreign('commande_id')->references('id')
                                    ->on('commandes')
                                    ->onDelete('cascade')
                                    ->onUpdate('cascade');
            
            $table->unsignedBigInteger('produit_id')->nullable();
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
        Schema::dropIfExists('commande_produit');
    }
};
