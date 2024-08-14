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
        Schema::create('detail_achats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBiginteger('achat_id');
            $table->unsignedBiginteger('produit_id');
            $table->integer('quantite');
            $table->integer('prixUnitaire');
            $table->integer('total');


            $table->foreign('achat_id')->references('id')
                 ->on('achats')
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
        Schema::dropIfExists('detail_achats');
    }
};
