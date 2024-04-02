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
        Schema::create('evenement_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('evenement_id')->nullable();
            $table->foreign('evenement_id')->references('id')->on('evenements')->onDelete('cascade');

            $table->boolean('like');
            $table->timestamp('date_like')->nullable();
            $table->timestamp('date_unlike')->nullable();
            $table->integer('nombre_click');
            $table->timestamp('Date_click')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evenement_user');
    }
};
