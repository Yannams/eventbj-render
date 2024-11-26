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
        Schema::create('type_tickets', function (Blueprint $table) {
            $table->id();
            $table->string('nom_ticket');
            $table->string('prix_ticket')->nullable();
            $table->string('frais_ticket')->nullable();
            $table->string('format');
            $table->text('texte')->nullable();
            $table->string('lien')->nullable();
            $table->string('event_link')->nullable();
            $table->string('place_dispo');
            $table->string('quantite');
            $table->string('image_ticket');
            $table->string('methodeProgrammationLancement');
            $table->timestamp('Date_heure_lancement')->nullable();
            $table->string('methodeProgrammationFermeture');
            $table->timestamp('Date_heure_fermeture')->nullable();
            $table->unsignedBigInteger('evenement_id')->nullable();
            $table->foreign('evenement_id')->references('id')->on('evenements')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('type_tickets');
    }
};
