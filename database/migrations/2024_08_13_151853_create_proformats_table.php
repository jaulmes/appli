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
        Schema::create('proformats', function (Blueprint $table) {
            $table->id();
            $table->string('nomClient')->nullable();
            $table->integer('numeroClient')->nullable();
            $table->integer('montantTotal');
            $table->integer('NetAPayer');
            $table->integer('totalAchat')->nullable();
            $table->integer('reduction')->nullable();
            $table->string('agentOperant')->nullable();
            $table->integer('qteTotal')->nullable();
            $table->string('date')->nullable();
            $table->string('statut')->nullable();
            $table->string('dateEncour')->nullable();
            $table->string('impot')->nullable();

            //client_id
            $table->unsignedBigInteger('client_id')->nullable();
            $table->foreign('client_id')->references('id')
                                        ->on('clients')
                                        ->onUpdate('cascade')
                                        ->onDelete('cascade');
            
            //user_key
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')
                                        ->on('users')
                                        ->onUpdate('cascade')
                                        ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proformats');
    }
};
