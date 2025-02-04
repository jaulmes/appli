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
        Schema::create('produit_transaction', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('produit_id')->nullable();
            $table->unsignedBigInteger('transaction_id')->nullable();

            $table->foreign('produit_id')->references('id')
                                        ->on('produits');
            $table->foreign('transaction_id')->references('id')
                                        ->on('transactions');

            $table->integer('quantity');
            $table->integer('price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produit_transaction');
    }
};
