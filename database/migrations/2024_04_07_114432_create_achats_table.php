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
        Schema::create('achats', function (Blueprint $table) {
            $table->id();
            $table->string('date');
            $table->string('statut')->nullable();
            $table->string('montantVerse')->nullable();
            $table->string('qte')->nullable();
            $table->integer('total');
            $table->string('updated_by')->nullable();
            $table->string('impot')->nullable();
            
            //compte_key
            $table->unsignedBigInteger('compte_id')->nullable();
            $table->foreign('compte_id')->references('id')
                                        ->on('comptes')
                                        ->onUpdate('cascade')
                                        ->onDelete('cascade');
            //user_id
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
        Schema::dropIfExists('achats');
    }
};
