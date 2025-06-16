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
        Schema::create('bon_commande_produit', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bon_commande_id');
            $table->unsignedBigInteger('produit_id');
            $table->integer('quantity')->default(1);
            $table->string('price')->nullable();
            $table->foreign('bon_commande_id')->references('id')
                                                ->on('bon_commandes')
                                                ->onDelete('cascade');
            $table->foreign('produit_id')->references('id')
                                            ->on('produits')
                                            ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bon_commande_produit');
    }
};
