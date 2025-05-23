<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Livewire\on;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pack_vente', function (Blueprint $table) {
            $table->id();
            $table->string('prix')->nullable();
            $table->string('quantity')->nullable();
            $table->unsignedBigInteger('pack_id')->nullable();
            $table->foreign('pack_id')->references('id')
                                    ->on('packs')
                                    ->onDelete('cascade')
                                    ->onUpdate('cascade');
            $table->unsignedBigInteger('vente_id')->nullable();
            $table->foreign('vente_id')->references('id')
                                    ->on('ventes')
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
        Schema::dropIfExists('pack_vente');
    }
};
