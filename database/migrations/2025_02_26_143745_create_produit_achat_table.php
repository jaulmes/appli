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
        Schema::create('produit_achat', function (Blueprint $table) {
            $table->id();
            $table->string('price');
            $table->integer('quantity');
            $table->unsignedBigInteger('produit_id');
            $table->unsignedBigInteger('achat_id');

            //liaison evec les cles etrangere
            $table->foreign('produit_id')->references('id')
                                        ->on('produits')
                                        ->onDelete('cascade')
                                        ->onUpdate('cascade');
            
            $table->foreign('achat_id')->references('id')
                                        ->on('achats')
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
        Schema::dropIfExists('produit_achats');
    }
};
