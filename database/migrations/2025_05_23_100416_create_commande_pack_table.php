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
        Schema::create('commande_pack', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity');
            $table->integer('prix');
            $table->unsignedBigInteger('commande_id')->nullable();
            $table->foreign('commande_id')->references('id')
                                    ->on('commandes')
                                    ->onDelete('cascade')
                                    ->onUpdate('cascade');
            
            $table->unsignedBigInteger('pack_id')->nullable();
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
        Schema::dropIfExists('commande_pack');
    }
};
