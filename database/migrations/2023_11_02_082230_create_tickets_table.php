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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('code_QR')->nullable();
            $table->string('LienUnique')->nullable();
            $table->string('transaction_id');
            $table->string('statut');
            $table->text('signature')->nullable();
            $table->unsignedBigInteger('type_ticket_id')->nullable();
            $table->foreign('type_ticket_id')->references('id')->on('type_tickets')->onDelete('cascade');
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
        Schema::dropIfExists('tickets');
    }
};
