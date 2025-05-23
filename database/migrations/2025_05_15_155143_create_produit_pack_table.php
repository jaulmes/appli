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
        Schema::create('produit_pack', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('produit_id');
            $table->unsignedBigInteger('pack_id');
            $table->string('quantity');
            $table->string('price');
            $table->foreign('produit_id')->references('id')
                                        ->on('produits')
                                        ->onDelete('cascade')
                                        ->onUpdate('cascade');
            $table->foreign('pack_id')->references('id')
                                        ->on('packs')
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
        Schema::dropIfExists('produit_pack');
    }
};
