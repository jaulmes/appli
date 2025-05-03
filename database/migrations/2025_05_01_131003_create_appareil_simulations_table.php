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
        Schema::create('appareil_simulations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('quantity');
            $table->string('power');
            $table->string('duration');
            $table->unsignedBigInteger('simulation_id');
            $table->foreign('simulation_id')->references('id')
                                            ->on('simulations')
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
        Schema::dropIfExists('appareil_simulations');
    }
};
