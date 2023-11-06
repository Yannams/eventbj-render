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
            $table->string('nom_evenement');
            $table->string('localisation');
            $table->boolean('isOnline');
            $table->timestamp('date_heure_debut')->nullable();
            $table->timestamp('date_heure_fin')->nullable();
            $table->text('description');
            $table->string('cover_event');
            $table->unsignedBigInteger('type_evenement_id')->nullable();
            $table->foreign('type_evenement_id')->references('id')->on('type_evenements')->onDelete('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
