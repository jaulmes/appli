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
        Schema::create('pack_installation', function (Blueprint $table) {
            $table->id();
            $table->string('prix')->nullable();
            $table->string('quantity')->nullable();
            $table->unsignedBigInteger('pack_id')->nullable();
            $table->foreign('pack_id')->references('id')
                                    ->on('packs')
                                    ->onDelete('cascade')
                                    ->onUpdate('cascade');
            $table->unsignedBigInteger('installation_id')->nullable();
            $table->foreign('installation_id')->references('id')
                                    ->on('installations')
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
        Schema::dropIfExists('pack_installation');
    }
};
