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
        Schema::create('achat_paiements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('achat_id');
            $table->unsignedBigInteger('compte_id');
            $table->string('montant');
            $table->unsignedBigInteger('user_id');
            $table->foreign('achat_id')->references('id')->on('achats')->onDelete('cascade');
            $table->foreign('compte_id')->references('id')->on('comptes')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('achat_paiements');
    }
};
