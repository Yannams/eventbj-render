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
        Schema::create('evenements', function (Blueprint $table) {
            $table->id();
            $table->string('nom_evenement')->nullable();
            $table->string('localisation')->nullable();
            $table->boolean('isOnline')->nullable();
            $table->timestamp('date_heure_debut')->nullable();
            $table->timestamp('date_heure_fin')->nullable();
            $table->text('description')->nullable();
            $table->string('cover_event')->nullable();
            $table->string('Fréquence');
            $table->unsignedBigInteger('type_evenement_id')->nullable();
            $table->foreign('type_evenement_id')->references('id')->on('type_evenements')->onDelete('cascade');
            $table->unsignedBigInteger('promoteur_id')->nullable();
            $table->foreign('promoteur_id')->references('id')->on('promoteurs')->onDelete('cascade');
            $table->unsignedBigInteger('type_lieu_id')->nullable();
            $table->foreign('type_lieu_id')->references('id')->on('type_lieus')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evenements');
    }
};
