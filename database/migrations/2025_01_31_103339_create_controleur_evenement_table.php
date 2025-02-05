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
        Schema::create('controleur_evenement', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('controleur_id')->nullable();
            $table->foreign('controleur_id')->references('id')->on('controleurs')->onDelete('cascade');
            $table->unsignedBigInteger('evenement_id')->nullable();
            $table->foreign('evenement_id')->references('id')->on('evenements')->onDelete('cascade');
            $table->string('name');
            $table->string('telephone')->nullable();
            $table->string('email')->nullable();
            $table->string('statut_affectation')->default('non affecté');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('controleur_evenement');
    }
};
