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
        Schema::create('controleurs', function (Blueprint $table) {
            $table->id();
            $table->string('ControleurId')->unique();
            $table->string('statut')->default('désactivé');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
             $table->unsignedBigInteger('profil_promoteur_id')->nullable();
            $table->foreign('profil_promoteur_id')->references('id')->on('profil_promoteurs')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('controleurs');
    }
};
