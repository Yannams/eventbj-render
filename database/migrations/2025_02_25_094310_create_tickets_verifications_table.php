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
        Schema::create('tickets_verifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ticket_id')->nullable(); 
            $table->foreign('ticket_id')->references('id')->on('tickets')->onDelete('cascade');
            $table->unsignedBigInteger('controleur_id')->nullable();
            $table->foreign('controleur_id')->references('id')->on('controleurs')->onDelete('cascade');
            $table->unsignedBigInteger('evenement_id');
            $table->foreign('evenement_id')->references('id')->on('evenements')->onDelete('cascade');
            $table->unsignedBigInteger('profil_promoteur_id')->nullable();
            $table->foreign('profil_promoteur_id')->references('id')->on('profil_promoteurs')->onDelete('cascade');
            $table->enum('statut', ['ticket valide', 'ticket invalide', 'ticket vérifié']);
            $table->string('nom_controleur');
            $table->string('num_controleur');
            $table->string('mail_controleur');
          
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets_verifications');
    }
};
