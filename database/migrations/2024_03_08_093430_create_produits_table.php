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
        Schema::create('produits', function (Blueprint $table) {
            $table->id();
            $table->longText('description');
            $table->string('name');
            $table->integer('prix_achat');
            $table->integer('price');
            $table->integer('prix_technicien');
            $table->integer('prix_minimum');
            $table->string('stock');
            $table->string('fabricant')->nullable();
            $table->string('image_produit')->nullable();
            $table->unsignedBigInteger('categori_id');
            $table->foreign('categori_id')->
                            references('id')->
                            on('categoris')->
                            onDelete('cascade')->
                            onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produits');
    }
};
