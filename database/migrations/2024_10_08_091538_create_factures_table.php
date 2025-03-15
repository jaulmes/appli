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
        Schema::create('factures', function (Blueprint $table) {
            $table->id();
            $table->string('numeroFacture');
            $table->unsignedBigInteger('vente_id')->nullable();
            $table->unsignedBigInteger('installation_id')->nullable();
            $table->unsignedBigInteger('proformat_id')->nullable();

            $table->foreign('proformat_id')->references('id')
            ->on('proformats');

            $table->foreign('vente_id')->references('id')
                                        ->on('ventes');

            $table->foreign('installation_id')->references('id')
                                        ->on('installations');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('factures');
    }
};
